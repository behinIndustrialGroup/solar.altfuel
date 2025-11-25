<?php

use BehinInit\App\Http\Controllers\AccessController;

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