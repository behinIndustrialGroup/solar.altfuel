<?php

namespace SolarPlantRequests\Enums;

enum ApplicantType: string
{
    case INDIVIDUAL = 'individual';
    case COMPANY = 'company';
    case FOREIGNER = 'foreigner';

    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUAL => 'شخص حقیقی',
            self::COMPANY => 'شخص حقوقی',
            self::FOREIGNER => 'اتباع',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $type) => [$type->value => $type->label()])->all();
    }
}
