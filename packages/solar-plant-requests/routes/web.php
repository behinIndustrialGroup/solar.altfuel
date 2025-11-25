<?php

use Illuminate\Support\Facades\Route;
use SolarPlantRequests\Http\Controllers\AllSolarPlantRequestController;
use SolarPlantRequests\Http\Controllers\SolarPlantRequestController;

Route::middleware(['web', 'auth'])->prefix('solar-plant-requests')->name('solar-plant-requests.')->group(function () {
    Route::get('/', [SolarPlantRequestController::class, 'index'])->name('index');
    Route::post('/', [SolarPlantRequestController::class, 'store'])->name('store');

    Route::prefix('all-requests')->name('all-requests.')->group(function(){
        Route::get('/', [AllSolarPlantRequestController::class, 'index'])->name('index');
        Route::post('{solarPlantRequest}/assign-contractor', [SolarPlantRequestController::class, 'assignContractor'])->name('assign-contractor');
    }); 
});
