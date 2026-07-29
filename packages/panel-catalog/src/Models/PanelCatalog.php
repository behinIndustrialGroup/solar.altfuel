<?php

namespace PanelCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class PanelCatalog extends Model
{
    protected $table = 'panels_catalog';

    protected $fillable = [
        'brand',
        'manufacture',
        'country_of_manufacture',
        'model',
        'model_code',
        'technology',
        'panel_type',
        'rated_power_wp',
        'module_efficiency',
        'number_of_cells',
        'cell_type',
        'voc',
        'isc',
        'vmp',
        'imp',
        'max_system_voltage',
        'temperature_coefficient',
        'power_tolerance',
        'product_warranty',
        'performance_warranty',
        'iec_61215',
        'iec_61730',
        'connector_type',
        'dimensions',
        'weight',
        'datasheet_path',
        'datasheet_version',
        'union_approval_status',
        'production_date',
        'discontinuation_date',
        'lab_certified',
        'lab_name',
    ];

    protected $casts = [
        'iec_61215' => 'boolean',
        'iec_61730' => 'boolean',
        'lab_certified' => 'boolean',
        'production_date' => 'date',
        'discontinuation_date' => 'date',
    ];

    public function getUnionApprovedAttribute(): bool
    {
        return $this->lab_certified
            && !empty($this->lab_name)
            && $this->iec_61215
            && $this->iec_61730;
    }
}
