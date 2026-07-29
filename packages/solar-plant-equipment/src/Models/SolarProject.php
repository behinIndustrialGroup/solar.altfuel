<?php

namespace SolarPlantEquipment\Models;

use App\Models\User;
use ContractorCatalog\Models\Contractor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolarPlantRequests\Models\SolarPlantRequest;

class SolarProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'contractor_id',
        'inspector_id',
        'installed_panel_ids',
        'installed_inverter_ids',
        'installed_battery_ids',
    ];

    protected $casts = [
        'installed_panel_ids'    => 'array',
        'installed_inverter_ids' => 'array',
        'installed_battery_ids'  => 'array',
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
}
