<?php

use Illuminate\Support\Facades\Route;
use SolarPlantRequests\Http\Controllers\SolarPlantRequestController;

Route::middleware(['web', 'auth'])->prefix('solar-plant-requests')->name('solar-plant-requests.')->group(function () {
    Route::get('/', [SolarPlantRequestController::class, 'index'])->name('index');
    Route::post('/', [SolarPlantRequestController::class, 'store'])->name('store');
    Route::post('{solarPlantRequest}/assign-contractor', [SolarPlantRequestController::class, 'assignContractor'])->name('assign-contractor');
});
