<?php

use Illuminate\Support\Facades\Route;
use InverterCatalog\Http\Controllers\InverterCatalogController;

Route::middleware(['web', 'auth'])->prefix('admin/inverter-catalog')->name('inverter-catalog.')->group(function () {
    Route::get('/', [InverterCatalogController::class, 'index'])->name('index');
    Route::get('create', [InverterCatalogController::class, 'create'])->name('create');
    Route::post('store', [InverterCatalogController::class, 'store'])->name('store');
    Route::get('{inverter}', [InverterCatalogController::class, 'show'])->name('show');
    Route::get('{inverter}/edit', [InverterCatalogController::class, 'edit'])->name('edit');
    Route::put('{inverter}', [InverterCatalogController::class, 'update'])->name('update');
    Route::delete('{inverter}', [InverterCatalogController::class, 'destroy'])->name('destroy');
    Route::get('last-record', [InverterCatalogController::class, 'lastRecord'])->name('last-record');
});
