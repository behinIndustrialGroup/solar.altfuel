<?php

namespace ProjectInspection\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SolarPlantEquipment\Models\SolarProject;

class ProjectInspection extends Model
{
    use HasFactory;

    protected $table = 'project_inspections';

    protected $fillable = [
        'inspector_id',
        'project_id',
        'visit_date',
        'result',
        'rejection_reason',

        'project_info_matches_system',
        'plant_capacity_correct',
        'installation_location_correct',
        'project_info_notes',

        'panel_brand_union_approved',
        'panel_brand_matches_project',
        'panel_model_approved',
        'panel_serial_correct',
        'panel_quantity_correct',
        'panel_intact',
        'panel_orientation_correct',
        'panel_angle_correct',
        'panel_notes',

        'structure_standard',
        'bolts_tightened',
        'no_corrosion',
        'proper_ground_clearance',
        'structure_notes',

        'cable_standard',
        'proper_cross_section',
        'proper_cabling',
        'mc4_connectors_standard',
        'dc_cabling_notes',

        'inverter_info_matches_project',
        'inverter_brand_approved',
        'inverter_model_approved',
        'inverter_serial_correct',
        'inverter_proper_installation',
        'inverter_ventilation_ok',
        'inverter_settings_correct',
        'inverter_notes',

        'battery_present',
        'battery_brand_approved',
        'battery_model_matches_project',
        'battery_serial_correct',
        'battery_cables_correct',
        'battery_bms_ok',
        'battery_ventilation_ok',
        'battery_notes',

        'grounding_implemented',
        'grounding_resistance_ok',
        'spd_installed',
        'fuses_appropriate',
        'protection_switches_appropriate',
        'grounding_notes',

        'electrical_panel_standard',
        'proper_wiring',
        'labeling_done',
        'electrical_panel_notes',

        'inverter_no_error',
        'production_normal',
        'monitoring_active',
        'performance_test_passed',
        'performance_notes',

        'warning_signs_installed',
        'safety_equipment_ok',
        'safe_access',
        'moisture_protection',
        'safety_notes',
    ];

    protected $casts = [
        'visit_date'                             => 'date',
        'project_info_matches_system'            => 'boolean',
        'plant_capacity_correct'                 => 'boolean',
        'installation_location_correct'          => 'boolean',
        'panel_brand_union_approved'             => 'boolean',
        'panel_brand_matches_project'            => 'boolean',
        'panel_model_approved'                   => 'boolean',
        'panel_serial_correct'                   => 'boolean',
        'panel_quantity_correct'                 => 'boolean',
        'panel_intact'                           => 'boolean',
        'panel_orientation_correct'              => 'boolean',
        'panel_angle_correct'                    => 'boolean',
        'structure_standard'                     => 'boolean',
        'bolts_tightened'                        => 'boolean',
        'no_corrosion'                           => 'boolean',
        'proper_ground_clearance'                => 'boolean',
        'cable_standard'                         => 'boolean',
        'proper_cross_section'                   => 'boolean',
        'proper_cabling'                         => 'boolean',
        'mc4_connectors_standard'                => 'boolean',
        'inverter_info_matches_project'          => 'boolean',
        'inverter_brand_approved'                => 'boolean',
        'inverter_model_approved'                => 'boolean',
        'inverter_serial_correct'                => 'boolean',
        'inverter_proper_installation'           => 'boolean',
        'inverter_ventilation_ok'                => 'boolean',
        'inverter_settings_correct'              => 'boolean',
        'battery_present'                        => 'boolean',
        'battery_brand_approved'                 => 'boolean',
        'battery_model_matches_project'          => 'boolean',
        'battery_serial_correct'                 => 'boolean',
        'battery_cables_correct'                 => 'boolean',
        'battery_bms_ok'                         => 'boolean',
        'battery_ventilation_ok'                 => 'boolean',
        'grounding_implemented'                  => 'boolean',
        'grounding_resistance_ok'                => 'boolean',
        'spd_installed'                          => 'boolean',
        'fuses_appropriate'                      => 'boolean',
        'protection_switches_appropriate'        => 'boolean',
        'electrical_panel_standard'              => 'boolean',
        'proper_wiring'                          => 'boolean',
        'labeling_done'                          => 'boolean',
        'inverter_no_error'                      => 'boolean',
        'production_normal'                      => 'boolean',
        'monitoring_active'                      => 'boolean',
        'performance_test_passed'                => 'boolean',
        'warning_signs_installed'                => 'boolean',
        'safety_equipment_ok'                    => 'boolean',
        'safe_access'                            => 'boolean',
        'moisture_protection'                    => 'boolean',
    ];

    public const RESULT_APPROVED = 'approved';
    public const RESULT_REJECTED = 'rejected';

    public static function getResults(): array
    {
        return [
            self::RESULT_APPROVED => 'تایید شده',
            self::RESULT_REJECTED => 'عدم تایید',
        ];
    }

    public function getResultLabelAttribute(): string
    {
        return match ($this->result) {
            self::RESULT_APPROVED => '<span class="badge badge-success">تایید شده</span>',
            self::RESULT_REJECTED => '<span class="badge badge-danger">عدم تایید</span>',
            default               => '<span class="badge badge-secondary">نامشخص</span>',
        };
    }

    public function getVisitDateJalaliAttribute(): string
    {
        if (!$this->visit_date) {
            return '';
        }
        return \Morilog\Jalali\Jalalian::fromDateTime($this->visit_date)->format('Y/m/d');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(SolarProject::class, 'project_id');
    }
}
