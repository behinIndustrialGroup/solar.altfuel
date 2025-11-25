<?php

namespace SolarPlantRequests\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SolarPlantRequests\Enums\InverterStatus;

class Inverter extends Model
{
    protected $table = 'solar_plant_inverters';

    protected $fillable = [
        'serial',
        'manufacturer_user_id',
        'production_year',
        'expiration_year',
        'status',
        'solar_plant_request_id',
    ];

    protected $casts = [
        'status' => InverterStatus::class,
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manufacturer_user_id');
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(SolarPlantRequest::class, 'solar_plant_request_id');
    }
}

