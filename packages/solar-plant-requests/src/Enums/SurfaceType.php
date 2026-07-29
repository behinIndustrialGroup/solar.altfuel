<?php

namespace SolarPlantRequests\Enums;

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
