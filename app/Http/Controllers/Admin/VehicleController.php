<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::with(['brand', 'model', 'color'])
            ->latest()
            ->paginate(10);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create(): View
    {
        return view('admin.vehicles.create', [
            'brands' => Brand::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
            'models' => CarModel::with('brand')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateVehicle($request);

        $photos = collect($validated['photos'])
            ->filter(fn (?string $url) => filled($url))
            ->values();

        if ($photos->count() < 3) {
            return back()
                ->withInput()
                ->withErrors(['photos' => 'Informe pelo menos 3 URLs de fotos.']);
        }

        $primaryIndex = $this->resolvePrimaryIndex($request, $photos->count());

        DB::transaction(function () use ($validated, $photos, $primaryIndex): void {
            /** @var \App\Models\Vehicle $vehicle */
            $vehicle = Vehicle::create(array_merge(
                collect($validated)->except('photos')->toArray(),
                ['main_photo_url' => $photos->get($primaryIndex)]
            ));

            $photos->each(function (string $url, int $index) use ($vehicle, $primaryIndex): void {
                $vehicle->photos()->create([
                    'url' => $url,
                    'is_primary' => $index === $primaryIndex,
                ]);
            });
        });

        return redirect()
            ->route('admin.vehicles.index')
            ->with('status', 'Veículo cadastrado com sucesso.');
    }

    public function edit(Vehicle $vehicle): View
    {
        $vehicle->load('photos');

        return view('admin.vehicles.edit', [
            'vehicle' => $vehicle,
            'brands' => Brand::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
            'models' => CarModel::with('brand')->orderBy('name')->get(),
            'photoUrls' => $vehicle->photos->pluck('url')->toArray(),
            'primaryIndex' => max($vehicle->photos->search(fn ($photo) => $photo->is_primary), 0),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $validated = $this->validateVehicle($request, $vehicle->id);

        $photos = collect($validated['photos'])
            ->filter(fn (?string $url) => filled($url))
            ->values();

        if ($photos->count() < 3) {
            return back()
                ->withInput()
                ->withErrors(['photos' => 'Informe pelo menos 3 URLs de fotos.']);
        }

        $primaryIndex = $this->resolvePrimaryIndex($request, $photos->count());

        DB::transaction(function () use ($vehicle, $validated, $photos, $primaryIndex): void {
            $vehicle->update(array_merge(
                collect($validated)->except('photos')->toArray(),
                ['main_photo_url' => $photos->get($primaryIndex)]
            ));

            $vehicle->photos()->delete();

            $photos->each(function (string $url, int $index) use ($vehicle, $primaryIndex): void {
                $vehicle->photos()->create([
                    'url' => $url,
                    'is_primary' => $index === $primaryIndex,
                ]);
            });
        });

        return redirect()
            ->route('admin.vehicles.index')
            ->with('status', 'Veículo atualizado com sucesso.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('status', 'Veículo removido.');
    }

    private function validateVehicle(Request $request, ?int $vehicleId = null): array
    {
        $currentYear = (int) now()->year + 1;

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'brand_id' => ['required', 'exists:brands,id'],
            'car_model_id' => [
                'required',
                Rule::exists('car_models', 'id')->where(fn ($query) => $query->where('brand_id', $request->input('brand_id'))),
            ],
            'color_id' => ['required', 'exists:colors,id'],
            'year' => ['required', 'integer', 'min:1960', 'max:'.$currentYear],
            'mileage' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'photos' => ['required', 'array', 'min:3'],
            'photos.*' => ['required', 'url'],
        ]);
    }

    private function resolvePrimaryIndex(Request $request, int $photoCount): int
    {
        $index = max(0, (int) $request->input('main_photo_index', 0));

        return min($index, $photoCount - 1);
    }
}
