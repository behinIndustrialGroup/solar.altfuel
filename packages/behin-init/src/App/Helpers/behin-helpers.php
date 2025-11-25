<?php

use BehinInit\App\Http\Controllers\AccessController;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;


if (!function_exists('access')) {
    function access($method_name) {
        return (new AccessController($method_name))->check();
    }
}

if (!function_exists('convertPersianToEnglish')) {
    function convertPersianToEnglish($string) {
        static $map = [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',
        ];

        return strtr($string, $map);
    }
}

if(!function_exists('toJalali')){
    function toJalali($date){
        try{
            if (is_string($date)) {
                $date = Carbon::parse($date);
            }
            if (is_int($date)) {
                $date = Carbon::createFromTimestamp($date, 'Asia/Tehran');
            }
            // Log::info("function toJalali Used By user". Auth::user()->name);
            $jDate = Jalalian::fromCarbon($date);
            return $jDate;
        }catch(Exception $e){
            return $date;
        }
        
    }
}