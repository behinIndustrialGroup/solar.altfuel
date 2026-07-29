<?php

namespace SolarPlantEquipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstalledPanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'panel_model_id',
        'serial_number',
        'section_number',
        'string_number',
        'panel_number',
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(SolarProject::class, 'project_id');
    }
}
