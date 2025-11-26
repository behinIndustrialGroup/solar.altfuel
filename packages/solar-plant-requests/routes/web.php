<?php

use Illuminate\Support\Facades\Route;
use SolarPlantRequests\Http\Controllers\AllSolarPlantRequestController;
use SolarPlantRequests\Http\Controllers\ContractorSolarPlantRequestController;
use SolarPlantRequests\Http\Controllers\Panel\CreateController;
use SolarPlantRequests\Http\Controllers\Inverter\CreateController as InverterCreateController;
use SolarPlantRequests\Http\Controllers\Battery\CreateController as BatteryCreateController;
use SolarPlantRequests\Http\Controllers\SolarPlantRequestController;

Route::middleware(['web', 'auth'])->prefix('solar-plant-requests')->name('solar-plant-requests.')->group(function () {
    Route::get('/', [SolarPlantRequestController::class, 'index'])->name('index');
    Route::post('/', [SolarPlantRequestController::class, 'store'])->name('store');

    Route::prefix('all-requests')->name('all-requests.')->group(function(){
        Route::get('/', [AllSolarPlantRequestController::class, 'index'])->name('index');
        Route::post('{solarPlantRequest}/assign-contractor', [AllSolarPlantRequestController::class, 'assignContractor'])->name('assign-contractor');
    }); 

    Route::prefix('contractor')->name('contractor.')->group(function(){
        Route::get('/', [ContractorSolarPlantRequestController::class, 'index'])->name('index');
        Route::get('{solarPlantRequest}/show', [ContractorSolarPlantRequestController::class, 'show'])->name('show');
    }); 

    Route::prefix('panel')->name('panel.')->group(function(){
        Route::post('{solarPlantRequest}/store', [CreateController::class, 'addPanelToRequest'])->name('store');
    });

    Route::prefix('battery')->name('battery.')->group(function(){
        Route::post('{solarPlantRequest}/store', [BatteryCreateController::class, 'addBatteryToRequest'])->name('store');
    });

    Route::prefix('inverter')->name('inverter.')->group(function(){
        Route::post('{solarPlantRequest}/store', [InverterCreateController::class, 'addInverterToRequest'])->name('store');
    });
});
