<?php

namespace SolarPlantEquipment\Models;

use App\Models\User;
use ContractorCatalog\Models\Contractor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ProjectInspection\Models\ProjectInspection;
use SolarPlantRequests\Models\SolarPlantRequest;

class SolarProject extends Model
{
    use HasFactory;

    public const STATUS_IN_PROGRESS          = 'in_progress';
    public const STATUS_READY_FOR_INSPECTION = 'ready_for_inspection';
    public const STATUS_APPROVED             = 'approved';
    public const STATUS_REJECTED             = 'rejected';
    public const STATUS_ACTIVE               = 'active';
    public const STATUS_INACTIVE             = 'inactive';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_IN_PROGRESS          => 'در حال اجرا',
            self::STATUS_READY_FOR_INSPECTION => 'آماده بازرسی',
            self::STATUS_APPROVED             => 'تایید شده',
            self::STATUS_REJECTED             => 'رد شده',
            self::STATUS_ACTIVE               => 'فعال',
            self::STATUS_INACTIVE             => 'غیر فعال',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        if (empty($this->status)) {
            return '<span class="badge badge-light text-muted">—</span>';
        }

        $statusClasses = [
            self::STATUS_IN_PROGRESS          => 'badge badge-primary',
            self::STATUS_READY_FOR_INSPECTION => 'badge badge-warning',
            self::STATUS_APPROVED             => 'badge badge-success',
            self::STATUS_REJECTED             => 'badge badge-danger',
            self::STATUS_ACTIVE               => 'badge badge-info',
            self::STATUS_INACTIVE             => 'badge badge-secondary',
        ];

        $labels = self::getStatuses();
        $class  = $statusClasses[$this->status] ?? 'badge badge-secondary';
        $label  = $labels[$this->status] ?? 'نامشخص';

        return "<span class=\"{$class}\">{$label}</span>";
    }

    protected $fillable = [
        'request_id',
        'contractor_id',
        'inspector_id',
        'installation_start_date',
        'installation_end_date',
        'commissioning_date',
        'latitude',
        'longitude',
        'satba_contract_number',
        'status',
        'health_card_no',
        'health_card_issue_date',
        'health_card_expiry_date',
        'description',
        'installed_panel_ids',
        'installed_inverter_ids',
        'installed_battery_ids',
        'inspection_ids',
    ];

    protected $casts = [
        'installation_start_date'  => 'date',
        'installation_end_date'    => 'date',
        'commissioning_date'       => 'date',
        'latitude'                 => 'decimal:7',
        'longitude'                => 'decimal:7',
        'health_card_issue_date'   => 'date',
        'health_card_expiry_date'  => 'date',
        'installed_panel_ids'      => 'array',
        'installed_inverter_ids'   => 'array',
        'installed_battery_ids'    => 'array',
        'inspection_ids'           => 'array',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    /** درخواست مرتبط از جدول solar_plant_requests */
    public function request(): BelongsTo
    {
        return $this->belongsTo(SolarPlantRequest::class, 'request_id');
    }

    /** پیمانکار از جدول contractors */
    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    /** بازرس از جدول users (role_id = 13) */
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    /** پنل‌های نصب‌شده در این پروژه */
    public function installedPanels(): HasMany
    {
        return $this->hasMany(InstalledPanel::class, 'project_id');
    }

    /** اینورترهای نصب‌شده در این پروژه */
    public function installedInverters(): HasMany
    {
        return $this->hasMany(InstalledInverter::class, 'project_id');
    }

    /** باتری‌های نصب‌شده در این پروژه */
    public function installedBatteries(): HasMany
    {
        return $this->hasMany(InstalledBattery::class, 'project_id');
    }

    /** بازرسی‌های ثبت شده برای این پروژه */
    public function inspections(): HasMany
    {
        return $this->hasMany(ProjectInspection::class, 'project_id');
    }
}
