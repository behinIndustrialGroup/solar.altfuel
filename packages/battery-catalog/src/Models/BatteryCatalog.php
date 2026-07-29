<?php

namespace BatteryCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class BatteryCatalog extends Model
{
    protected $table = 'batteries_catalog';

    protected $fillable = [
        'brand',
        'manufacture',
        'country_of_manufacture',
        'model_name',
        'model_code',
        'battery_type',
        'energy_capacity_kwh',
        'capacity_ah',
        'nominal_voltage',
        'max_charge_current',
        'max_discharge_current',
        'cycle_life',
        'depth_of_discharge',
        'expandable',
        'max_parallel_units',
        'ip_rating',
        'communication_protocols',
        'dimensions',
        'weight',
        'warranty_years',
        'standards',
        'datasheet_path',
        'union_approved',
        'union_approval_date',
        'notes',
        'lab_certified',
        'lab_name',
    ];

    protected $casts = [
        'expandable' => 'boolean',
        'union_approved' => 'boolean',
        'lab_certified' => 'boolean',
        'communication_protocols' => 'array',
        'standards' => 'array',
        'energy_capacity_kwh' => 'decimal:2',
        'capacity_ah' => 'decimal:2',
        'nominal_voltage' => 'decimal:2',
        'max_charge_current' => 'decimal:2',
        'max_discharge_current' => 'decimal:2',
        'depth_of_discharge' => 'decimal:2',
        'weight' => 'decimal:2',
        'union_approval_date' => 'date',
    ];

    /**
     * Check if the battery is union approved
     * 
     * @return bool
     */
    public function getUnionApprovedStatusAttribute(): bool
    {
        return $this->lab_certified
            && !empty($this->lab_name)
            && !empty($this->datasheet_path)
            && $this->union_approved;
    }

    /**
     * Get available battery types
     * 
     * @return array
     */
    public static function getBatteryTypes(): array
    {
        return config('battery-catalog.battery_types', []);
    }

    /**
     * Get available standards
     * 
     * @return array
     */
    public static function getAvailableStandards(): array
    {
        return config('battery-catalog.standards', []);
    }

    /**
     * Get available laboratories
     * 
     * @return array
     */
    public static function getApprovedLabs(): array
    {
        return config('battery-catalog.approved_labs', []);
    }

    /**
     * Get available communication protocols
     * 
     * @return array
     */
    public static function getCommunicationProtocols(): array
    {
        return config('battery-catalog.communication_protocols', []);
    }

    /**
     * Get available IP ratings
     * 
     * @return array
     */
    public static function getIpRatings(): array
    {
        return config('battery-catalog.ip_ratings', []);
    }
}
