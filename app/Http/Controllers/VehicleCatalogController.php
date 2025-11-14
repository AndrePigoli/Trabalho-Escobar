<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\ViewModels\VehicleCatalogViewModel;
use Illuminate\Contracts\View\View;

class VehicleCatalogController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::with(['brand', 'model', 'color', 'photos'])
            ->latest()
            ->paginate(9);

        $stats = [
            'total' => Vehicle::count(),
            'brands' => Vehicle::distinct('brand_id')->count('brand_id'),
            'newest_year' => Vehicle::max('year') ?? now()->year,
        ];

        $recentActivity = Vehicle::select(['id', 'title', 'brand_id', 'updated_at', 'price'])
            ->with('brand:id,name')
            ->latest('updated_at')
            ->take(3)
            ->get();

        $catalog = new VehicleCatalogViewModel($vehicles, $stats, $recentActivity);

        return view('vehicles.index', compact('catalog'));
    }

    public function show(Vehicle $vehicle): View
    {
        $vehicle->load(['brand', 'model', 'color', 'photos']);

        $relatedVehicles = Vehicle::with(['brand', 'model'])
            ->whereKeyNot($vehicle->getKey())
            ->latest()
            ->take(3)
            ->get();

        return view('vehicles.show', compact('vehicle', 'relatedVehicles'));
    }
}
