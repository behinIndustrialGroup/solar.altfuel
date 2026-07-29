<?php

namespace SolarPlantRequests\Enums;

enum UsageType: string
{
    case VILLA = 'villa';
    case INDUSTRIAL = 'industrial';
    case COMMERCIAL = 'commercial';
    case AGRICULTURE = 'agriculture';
    case APARTMENT = 'apartment';

    public function label(): string
    {
        return match ($this) {
            self::VILLA => 'ویلایی',
            self::INDUSTRIAL => 'صنعتی',
            self::COMMERCIAL => 'تجاری',
            self::AGRICULTURE => 'کشاورزی',
            self::APARTMENT => 'آپارتمان',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $type) => [$type->value => $type->label()])->all();
    }
}
