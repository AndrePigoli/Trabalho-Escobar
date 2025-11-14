<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CarModelController as AdminCarModelController;
use App\Http\Controllers\Admin\ColorController as AdminColorController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleCatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VehicleCatalogController::class, 'index'])->name('home');
Route::get('/veiculos/{vehicle}', [VehicleCatalogController::class, 'show'])->name('vehicles.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])
    ->get('/dashboard', function () {
        return redirect()->route('admin.vehicles.index');
    })
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('brands', AdminBrandController::class)->except('show');
        Route::resource('models', AdminCarModelController::class)
            ->parameters(['models' => 'model'])
            ->except('show');
        Route::resource('colors', AdminColorController::class)->except('show');
        Route::resource('vehicles', AdminVehicleController::class)->except('show');
    });

require __DIR__.'/auth.php';
