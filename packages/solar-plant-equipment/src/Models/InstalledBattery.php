<?php

namespace SolarPlantEquipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstalledBattery extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'battery_model_id',
        'serial_number',
        'equipment_tag',
        'installation_location',
        'status',
        'notes',
    ];

    /**
     * Valid status values
     */
    const STATUSES = [
        'installed'  => 'نصب شده',
        'active'     => 'در حال بهره‌برداری',
        'faulty'     => 'معیوب',
        'replaced'   => 'تعویض شده',
        'removed'    => 'از مدار خارج شده',
    ];

    /**
     * Valid installation location values
     */
    const INSTALLATION_LOCATIONS = [
        'battery_rack'       => 'رک باتری',
        'battery_cabinet'    => 'کابینت باتری',
        'battery_room'       => 'اتاق باتری',
        'storage_container'  => 'کانتینر ذخیره‌ساز',
        'other'              => 'سایر',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SolarProject::class, 'project_id');
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(\BatteryCatalog\Models\BatteryCatalog::class, 'battery_model_id');
    }
}
