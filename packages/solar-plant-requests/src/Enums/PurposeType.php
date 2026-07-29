<?php

namespace SolarPlantRequests\Enums;

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
