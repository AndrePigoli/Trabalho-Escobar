<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index(): View
    {
        $models = CarModel::with('brand')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.models.index', compact('models'));
    }

    public function create(): View
    {
        $brands = Brand::orderBy('name')->get();

        return view('admin.models.create', compact('brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255', 'unique:car_models,name,NULL,id,brand_id,'.$request->brand_id],
        ]);

        CarModel::create($validated);

        return redirect()
            ->route('admin.models.index')
            ->with('status', 'Modelo cadastrado com sucesso.');
    }

    public function edit(CarModel $model): View
    {
        $brands = Brand::orderBy('name')->get();

        return view('admin.models.edit', compact('model', 'brands'));
    }

    public function update(Request $request, CarModel $model): RedirectResponse
    {
        $validated = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255', 'unique:car_models,name,'.$model->id.',id,brand_id,'.$request->brand_id],
        ]);

        $model->update($validated);

        return redirect()
            ->route('admin.models.index')
            ->with('status', 'Modelo atualizado com sucesso.');
    }

    public function destroy(CarModel $model): RedirectResponse
    {
        $model->delete();

        return redirect()
            ->route('admin.models.index')
            ->with('status', 'Modelo removido.');
    }
}
