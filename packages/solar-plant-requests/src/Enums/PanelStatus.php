<?php

namespace SolarPlantRequests\Enums;

enum PanelStatus: string
{
    case PENDING_APPROVAL = 'pending_approval';
    case APPROVED = 'approved';
    case RESERVED = 'reserved';
    case USED = 'used';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_APPROVAL => 'در انتظار تایید',
            self::APPROVED => 'تایید شده',
            self::RESERVED => 'رزرو شده',
            self::USED => 'استفاده شده',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->label()])
            ->all();
    }
}
