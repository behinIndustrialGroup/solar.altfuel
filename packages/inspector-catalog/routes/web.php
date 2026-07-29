<?php

use Illuminate\Support\Facades\Route;
use InspectorCatalog\Http\Controllers\InspectorCatalogController;

Route::middleware(['web', 'auth'])->prefix('admin/inspector-catalog')->name('inspector-catalog.')->group(function () {
    Route::get('/',                  [InspectorCatalogController::class, 'index'])->name('index');
    Route::get('create',             [InspectorCatalogController::class, 'create'])->name('create');
    Route::post('store',             [InspectorCatalogController::class, 'store'])->name('store');
    Route::get('last-record',        [InspectorCatalogController::class, 'lastRecord'])->name('last-record');
    Route::get('{inspector}',        [InspectorCatalogController::class, 'show'])->name('show');
    Route::get('{inspector}/edit',   [InspectorCatalogController::class, 'edit'])->name('edit');
    Route::put('{inspector}',        [InspectorCatalogController::class, 'update'])->name('update');
    Route::delete('{inspector}',     [InspectorCatalogController::class, 'destroy'])->name('destroy');
});
