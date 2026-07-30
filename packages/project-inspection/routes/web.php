<?php

use Illuminate\Support\Facades\Route;
use ProjectInspection\Http\Controllers\ProjectInspectionController;

Route::middleware(['web', 'auth'])->prefix('admin/project-inspections')->name('project-inspection.inspections.')->group(function () {

    Route::get('/',                        [ProjectInspectionController::class, 'index'])->name('index');
    Route::get('create',                   [ProjectInspectionController::class, 'create'])->name('create');
    Route::post('/',                       [ProjectInspectionController::class, 'store'])->name('store');
    Route::get('{inspection}',             [ProjectInspectionController::class, 'show'])->name('show');
});
