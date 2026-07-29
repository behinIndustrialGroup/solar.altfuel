<?php

namespace InverterCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class InverterCatalog extends Model
{
    protected $table = 'inverters_catalog';

    protected $fillable = [
        'brand',
        'manufacture',
        'country_of_manufacture',
        'model_name',
        'model_code',
        'inverter_type',
        'rated_power_kw',
        'mppt_count',
        'strings_per_mppt',
        'max_dc_input_voltage',
        'max_input_current',
        'max_output_current',
        'output_voltage',
        'output_frequency',
        'max_efficiency',
        'protection_level',
        'cooling_type',
        'dc_switch',
        'ac_switch',
        'reverse_polarity_protection',
        'display',
        'anti_islanding_protection',
        'leakage_current_protection',
        'spd_type',
        'thd',
        'mpp_voltage_range',
        'communication_protocols',
        'max_pv_input_power',
        'warranty_period',
        'standards',
        'datasheet_path',
        'notes',
        'lab_certified',
        'lab_name',
    ];

    protected $casts = [
        'dc_switch' => 'boolean',
        'ac_switch' => 'boolean',
        'reverse_polarity_protection' => 'boolean',
        'display' => 'boolean',
        'anti_islanding_protection' => 'boolean',
        'leakage_current_protection' => 'boolean',
        'spd_type' => 'boolean',
        'lab_certified' => 'boolean',
        'standards' => 'array',
        'communication_protocols' => 'array',
        'rated_power_kw' => 'decimal:2',
        'max_dc_input_voltage' => 'decimal:2',
        'max_input_current' => 'decimal:2',
        'max_output_current' => 'decimal:2',
        'output_voltage' => 'decimal:2',
        'output_frequency' => 'decimal:2',
        'max_efficiency' => 'decimal:2',
        'thd' => 'decimal:2',
        'max_pv_input_power' => 'decimal:2',
    ];

    /**
     * Check if the inverter is union approved
     * 
     * @return bool
     */
    public function getUnionApprovedAttribute(): bool
    {
        return $this->lab_certified
            && !empty($this->lab_name)
            && !empty($this->datasheet_path);
    }

    /**
     * Get available standards
     * 
     * @return array
     */
    public static function getAvailableStandards(): array
    {
        return config('inverter-catalog.standards', []);
    }

    /**
     * Get available laboratories
     * 
     * @return array
     */
    public static function getApprovedLabs(): array
    {
        return config('inverter-catalog.approved_labs', []);
    }

    /**
     * Get available inverter types
     * 
     * @return array
     */
    public static function getInverterTypes(): array
    {
        return config('inverter-catalog.inverter_types', []);
    }

    /**
     * Get available cooling types
     * 
     * @return array
     */
    public static function getCoolingTypes(): array
    {
        return config('inverter-catalog.cooling_types', []);
    }

    /**
     * Get available communication protocols
     * 
     * @return array
     */
    public static function getCommunicationProtocols(): array
    {
        return config('inverter-catalog.communication_protocols', []);
    }
}
