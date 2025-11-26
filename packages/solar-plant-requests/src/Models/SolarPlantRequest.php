<?php

namespace SolarPlantRequests\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Models\Panel;
use SolarPlantRequests\Models\Inverter;
use SolarPlantRequests\Models\Battery;

class SolarPlantRequest extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'mobile',
        'national_code',
        'postal_code',
        'address',
        'bill_identifier',
        'area',
        'contractor_id',
        'contractor_name',
        'inspector_user_id',
        'inspector_name',
        'status',
    ];

    protected $casts = [
        'status' => SolarPlantRequestStatus::class,
    ];

    protected $appends = ['status_label'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_user_id');
    }

    public function panels(): HasMany
    {
        return $this->hasMany(Panel::class, 'solar_plant_request_id');
    }

    public function inverters(): HasMany
    {
        return $this->hasMany(Inverter::class, 'solar_plant_request_id');
    }

    public function batteries(): HasMany
    {
        return $this->hasMany(Battery::class, 'solar_plant_request_id');
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if (self::userHasRole($user, 'leader')) {
            return $query;
        }

        if (self::userHasRole($user, 'contractor')) {
            return $query
                ->where('contractor_id', $user->id)
                ->where('status', SolarPlantRequestStatus::EQUIPMENT_INSTALLATION);
        }

        if (self::userHasRole($user, 'inspector')) {
            return $query->where('inspector_user_id', $user->id);
        }

        return $query->where('user_id', $user->id);
    }

    public static function userHasRole(User $user, string $roleKey): bool
    {
        $roleIds = collect(config("solar-plant-requests.roles.{$roleKey}", []))
            ->map(fn ($id) => (string) $id)
            ->all();

        return in_array((string) $user->role_id, $roleIds, true);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status?->label() ?? '';
    }
}
