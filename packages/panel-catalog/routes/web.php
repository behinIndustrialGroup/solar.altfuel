<?php

use Illuminate\Support\Facades\Route;
use PanelCatalog\Http\Controllers\PanelCatalogController;

Route::middleware(['web', 'auth'])->prefix('admin/panel-catalog')->name('panel-catalog.')->group(function () {
    Route::get('/', [PanelCatalogController::class, 'index'])->name('index');
    Route::get('create', [PanelCatalogController::class, 'create'])->name('create');
    Route::post('store', [PanelCatalogController::class, 'store'])->name('store');
    Route::get('last-record', [PanelCatalogController::class, 'lastRecord'])->name('last-record');
});
