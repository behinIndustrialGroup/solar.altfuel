<?php

namespace ContractorCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $table = 'contractors';

    protected $fillable = [
        'company_name',
        'national_id',
        'ceo_name',
        'ceo_national_code',
        'ceo_mobile',
        'contact_person_name',
        'contact_person_mobile',
        'company_phone',
        'province',
        'city',
        'address',
        'license_number',
        'license_issue_date',
        'license_expiry_date',
        'registered_projects_count',
    ];

    protected $casts = [
        'license_issue_date' => 'date',
        'license_expiry_date' => 'date',
        'registered_projects_count' => 'integer',
    ];

    /**
     * Check if the license is still valid
     */
    public function getIsLicenseValidAttribute(): bool
    {
        return $this->license_expiry_date && $this->license_expiry_date->isFuture();
    }

    /**
     * Get available provinces
     */
    public static function getProvinces(): array
    {
        return config('contractor-catalog.provinces', []);
    }
}
