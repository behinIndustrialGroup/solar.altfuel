<?php

use Illuminate\Support\Facades\Route;
use BatteryCatalog\Http\Controllers\BatteryCatalogController;

Route::middleware(['web', 'auth'])->prefix('admin/battery-catalog')->name('battery-catalog.')->group(function () {
    Route::get('/', [BatteryCatalogController::class, 'index'])->name('index');
    Route::get('create', [BatteryCatalogController::class, 'create'])->name('create');
    Route::post('store', [BatteryCatalogController::class, 'store'])->name('store');
    Route::get('{battery}', [BatteryCatalogController::class, 'show'])->name('show');
    Route::get('{battery}/edit', [BatteryCatalogController::class, 'edit'])->name('edit');
    Route::put('{battery}', [BatteryCatalogController::class, 'update'])->name('update');
    Route::delete('{battery}', [BatteryCatalogController::class, 'destroy'])->name('destroy');
    Route::get('last-record', [BatteryCatalogController::class, 'lastRecord'])->name('last-record');
});
