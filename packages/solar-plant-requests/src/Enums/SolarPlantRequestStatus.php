<?php

namespace SolarPlantRequests\Enums;

enum SolarPlantRequestStatus: string
{
    case INITIAL = 'initial_registration';
    case UNDER_REVIEW = 'under_review';
    case CONTRACTOR_ASSIGNED = 'contractor_assigned';
    case EQUIPMENT_INSTALLATION = 'equipment_installation';
    case INSPECTION = 'inspection';
    case CERTIFICATE_ISSUED = 'certificate_issued';

    public function label(): string
    {
        return match ($this) {
            self::INITIAL => 'ثبت اولیه',
            self::UNDER_REVIEW => 'بررسی درخواست',
            self::CONTRACTOR_ASSIGNED => 'تخصیص پیمانکار',
            self::EQUIPMENT_INSTALLATION => 'تخصیص تجهیزات',
            self::INSPECTION => 'بازرسی و ثبت نتیجه',
            self::CERTIFICATE_ISSUED => 'صدور گواهی',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $status) => [$status->value => $status->label()])->all();
    }
}
