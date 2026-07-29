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

if(!function_exists('toJalaliFormatted')){
    function toJalaliFormatted($date, $format = 'Y-m-d'){
        try{
            $jDate = toJalali($date);
            if ($jDate instanceof Jalalian) {
                return $jDate->format($format);
            }
            return $date;
        }catch(Exception $e){
            return $date;
        }
    }
}

if(!function_exists('toGregorian')){
    function toGregorian($jalaliDate, $format = 'Y-m-d H:i:s'){
        try{
            if (empty($jalaliDate) || is_null($jalaliDate)) {
                return $jalaliDate;
            }

            $jalaliDate = convertPersianToEnglish($jalaliDate);

            $detectedFormat = null;
            $separator = '-';
            if (strpos($jalaliDate, '/') !== false) {
                $separator = '/';
            }

            $hasTime = strpos($jalaliDate, ':') !== false;
            $datePart = $jalaliDate;
            $timePart = '';
            if ($hasTime) {
                $parts = explode(' ', $jalaliDate, 2);
                $datePart = trim($parts[0]);
                $timePart = ' ' . trim($parts[1]);
            }

            $dateComponents = explode($separator, $datePart);
            if (count($dateComponents) === 3) {
                $year = intval($dateComponents[0]);
                $month = intval($dateComponents[1]);
                $day = intval($dateComponents[2]);

                if ($year > 1500) {
                    return Carbon::parse($jalaliDate)->format($format);
                }

                $gregorian = \Morilog\Jalali\CalendarUtils::toGregorian($year, $month, $day);
                $gregorianDateStr = sprintf('%04d-%02d-%02d', $gregorian[0], $gregorian[1], $gregorian[2]) . $timePart;
                return Carbon::parse($gregorianDateStr)->format($format);
            }

            return Carbon::parse($jalaliDate)->format($format);
        }catch(Exception $e){
            return $jalaliDate;
        }
    }
}

if(!function_exists('toGregorianDate')){
    function toGregorianDate($jalaliDate){
        return toGregorian($jalaliDate, 'Y-m-d');
    }
}