<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Validator::extend('jalali_date', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }
            if (!is_string($value)) {
                return false;
            }
            $value = trim(convertPersianToEnglish($value));
            if (!preg_match('#^(\d{4})[-/](\d{1,2})[-/](\d{1,2})$#', $value, $matches)) {
                return false;
            }
            [, $year, $month, $day] = $matches;
            try {
                return CalendarUtils::checkDate((int)$year, (int)$month, (int)$day);
            } catch (\Throwable $e) {
                return false;
            }
        });

        Validator::replacer('jalali_date', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'فیلد :attribute باید یک تاریخ شمسی معتبر باشد.');
        });

        Validator::extend('jalali_after', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }
            $data = $validator->getData();
            $otherValue = $data[$parameters[0]] ?? null;
            if (empty($otherValue)) {
                return true;
            }
            try {
                $value = trim(convertPersianToEnglish($value));
                $otherValue = trim(convertPersianToEnglish($otherValue));
                $currentTs = $this->jalaliToTimestamp($value);
                $otherTs = $this->jalaliToTimestamp($otherValue);
                return $currentTs > $otherTs;
            } catch (\Throwable $e) {
                return false;
            }
        });

        Validator::replacer('jalali_after', function ($message, $attribute, $rule, $parameters) {
            return str_replace(
                [':attribute', ':date'],
                [$attribute, $parameters[0] ?? ''],
                'فیلد :attribute باید تاریخی بعد از :date باشد.'
            );
        });

        Validator::extend('jalali_before', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }
            $data = $validator->getData();
            $otherValue = $data[$parameters[0]] ?? null;
            if (empty($otherValue)) {
                return true;
            }
            try {
                $value = trim(convertPersianToEnglish($value));
                $otherValue = trim(convertPersianToEnglish($otherValue));
                $currentTs = $this->jalaliToTimestamp($value);
                $otherTs = $this->jalaliToTimestamp($otherValue);
                return $currentTs < $otherTs;
            } catch (\Throwable $e) {
                return false;
            }
        });

        Validator::replacer('jalali_before', function ($message, $attribute, $rule, $parameters) {
            return str_replace(
                [':attribute', ':date'],
                [$attribute, $parameters[0] ?? ''],
                'فیلد :attribute باید تاریخی قبل از :date باشد.'
            );
        });
    }

    private function jalaliToTimestamp(string $jalaliDate): int
    {
        $jalaliDate = preg_replace('#/+#', '-', $jalaliDate);
        return Jalalian::fromFormat('Y-m-d', $jalaliDate)->toCarbon()->timestamp;
    }
}
