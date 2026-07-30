<?php

namespace SolarPlantEquipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstalledInverter extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'inverter_model_id',
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
        'electrical_room'      => 'اتاق برق',
        'control_room'         => 'اتاق کنترل',
        'equipment_container'  => 'کانکس تجهیزات',
        'outdoor'              => 'فضای باز',
        'wall_mounted'         => 'روی دیوار',
        'on_structure'         => 'روی استراکچر',
        'other'                => 'سایر',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SolarProject::class, 'project_id');
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(\InverterCatalog\Models\InverterCatalog::class, 'inverter_model_id');
    }
}
