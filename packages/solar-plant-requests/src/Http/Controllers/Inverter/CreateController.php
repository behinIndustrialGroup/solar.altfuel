<?php

namespace SolarPlantRequests\Http\Controllers\Inverter;

use Illuminate\Http\Request;
use SolarPlantRequests\Enums\InverterStatus;
use SolarPlantRequests\Models\Inverter;
use SolarPlantRequests\Models\SolarPlantRequest;

class CreateController
{
    public function addInverterToRequest(Request $request, SolarPlantRequest $solarPlantRequest)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_inverters,serial'],
            'manufacturer_user_id' => ['required', 'exists:users,id'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
        ]);

        Inverter::query()->create([
            ...$validated,
            'status' => InverterStatus::RESERVED,
            'solar_plant_request_id' => $solarPlantRequest->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'اینورتر جدید با موفقیت ثبت شد.');
    }
}

