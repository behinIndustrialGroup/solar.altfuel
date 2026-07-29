<?php

use Behin\Sms\Controllers\SmsController;
use Illuminate\Support\Facades\Route;

Route::name('sms.')->prefix('sms')->group(function(){
    Route::post('send', [SmsController::class, 'send'])->name('send');
});
