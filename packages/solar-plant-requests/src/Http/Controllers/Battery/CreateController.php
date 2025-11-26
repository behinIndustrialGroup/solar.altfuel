<?php

namespace SolarPlantRequests\Http\Controllers\Battery;

use Illuminate\Http\Request;
use SolarPlantRequests\Enums\BatteryStatus;
use SolarPlantRequests\Models\Battery;
use SolarPlantRequests\Models\SolarPlantRequest;

class CreateController
{
    public function addBatteryToRequest(Request $request, SolarPlantRequest $solarPlantRequest)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_batteries,serial'],
            'manufacturer_user_id' => ['required', 'exists:users,id'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
        ]);

        Battery::query()->create([
            ...$validated,
            'status' => BatteryStatus::RESERVED,
            'solar_plant_request_id' => $solarPlantRequest->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'باتری جدید با موفقیت ثبت شد.');
    }
}
