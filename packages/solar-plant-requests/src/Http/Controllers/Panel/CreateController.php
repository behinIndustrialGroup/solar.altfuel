<?php

namespace SolarPlantRequests\Http\Controllers\Panel;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SolarPlantRequests\Enums\PanelStatus;
use SolarPlantRequests\Models\Panel;
use SolarPlantRequests\Models\SolarPlantRequest;

class CreateController
{
    public function addPanelToRequest(Request $request, SolarPlantRequest $solarPlantRequest)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_panels,serial'],
            'manufacturer_user_id' => ['required', 'exists:users,id'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
            'status' => ['required', Rule::in(collect(PanelStatus::cases())->map->value->all())],
        ]);

        Panel::query()->create([
            ...$validated,
            'solar_plant_request_id' => $solarPlantRequest->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'پنل جدید با موفقیت ثبت شد.');
    }

}
