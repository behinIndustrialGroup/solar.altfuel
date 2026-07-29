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

enum SurfaceType: string
{
    case FLAT = 'flat';
    case SLOPED = 'sloped';
    case GROUND = 'ground';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::FLAT => 'تخت',
            self::SLOPED => 'شیبدار',
            self::GROUND => 'زمین',
            self::OTHER => 'سایر',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $type) => [$type->value => $type->label()])->all();
    }
}

enum PurposeType: string
{
    case OFF_GRID = 'off_grid';
    case ON_GRID = 'on_grid';
    case HYBRID = 'hybrid';

    public function label(): string
    {
        return match ($this) {
            self::OFF_GRID => 'مصرف شخصی (Off-grid)',
            self::ON_GRID => 'فروش به شبکه (On-grid)',
            self::HYBRID => 'هیبرید (Hybrid)',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $type) => [$type->value => $type->label()])->all();
    }
}
