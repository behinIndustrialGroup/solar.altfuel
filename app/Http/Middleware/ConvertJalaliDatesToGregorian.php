<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;

class ConvertJalaliDatesToGregorian
{
    public function handle(Request $request, Closure $next)
    {
        $inputs = $request->all();

        array_walk_recursive($inputs, function (&$value, $key) {
            if (!is_string($value)) {
                return;
            }

            $converted = $this->convertIfJalaliDate($value, $key);
            if ($converted !== null) {
                $value = $converted;
            }
        });

        $request->merge($inputs);

        return $next($request);
    }

    private function convertIfJalaliDate(string $value, string $key): ?string
    {
        $value = trim(convertPersianToEnglish($value));

        if ($value === '') {
            return null;
        }

        $dateTime = $this->matchDateTime($value);
        if ($dateTime !== null) {
            return $dateTime;
        }

        $dateOnly = $this->matchDateOnly($value);
        if ($dateOnly !== null) {
            return $dateOnly;
        }

        return null;
    }

    private function matchDateOnly(string $value): ?string
    {
        if (!preg_match('#^(\d{4})[-/](\d{1,2})[-/](\d{1,2})$#', $value, $matches)) {
            return null;
        }

        [, $year, $month, $day] = $matches;
        return $this->convertJalaliDateParts((int)$year, (int)$month, (int)$day);
    }

    private function matchDateTime(string $value): ?string
    {
        $pattern = '#^(\d{4})[-/](\d{1,2})[-/](\d{1,2})[ T](\d{1,2}):(\d{1,2})(?::(\d{1,2}))?$#';
        if (!preg_match($pattern, $value, $matches)) {
            return null;
        }

        [, $year, $month, $day, $hour, $minute] = $matches;
        $second = $matches[6] ?? '00';

        $dateStr = $this->convertJalaliDateParts((int)$year, (int)$month, (int)$day);
        if ($dateStr === null) {
            return null;
        }

        return sprintf(
            '%s %02d:%02d:%02d',
            $dateStr,
            (int)$hour,
            (int)$minute,
            (int)$second
        );
    }

    private function convertJalaliDateParts(int $year, int $month, int $day): ?string
    {
        if ($year < 1200 || $year > 1500 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
            return null;
        }

        try {
            $jalali = CalendarUtils::toGregorian($year, $month, $day);
            $gYear = $jalali[0];
            $gMonth = $jalali[1];
            $gDay = $jalali[2];

            if (!checkdate($gMonth, $gDay, $gYear)) {
                return null;
            }

            return sprintf('%04d-%02d-%02d', $gYear, $gMonth, $gDay);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
