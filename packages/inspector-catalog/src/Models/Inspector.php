<?php

namespace InspectorCatalog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Inspector extends Model
{
    protected $table = 'inspectors';

    protected $fillable = [
        'user_id',
        'inspector_code',
        'first_name',
        'last_name',
        'national_id',
        'mobile',
        'phone',
        'province',
        'city',
        'address',
        'is_certificated',
    ];

    protected $casts = [
        'is_certificated' => 'boolean',
    ];

    /**
     * رابطه با کاربر
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * نام کامل بازرس
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * لیست استان‌ها
     */
    public static function getProvinces(): array
    {
        return config('inspector-catalog.provinces', []);
    }
}
