<?php

namespace SolarPlantRequests\Http\Controllers\Panel;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SolarPlantRequests\Enums\PanelStatus;
use SolarPlantRequests\Http\Controllers\PanelManufacturer\GetController as PanelManufacturerGetController;
use SolarPlantRequests\Models\Panel;
use SolarPlantRequests\Models\SolarPlantRequest;

class CreateController
{
    public function create(): View
    {
        return view('solar-plant-requests::panels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_panels,serial'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
        ]);

        Panel::query()->create([
            ...$validated,
            'status' => PanelStatus::APPROVED,
            'manufacturer_user_id' => $request->user()->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'پنل جدید با موفقیت ثبت شد.');
    }

    public function addPanelToRequest(Request $request, SolarPlantRequest $solarPlantRequest)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_panels,serial'],
            'manufacturer_user_id' => ['required', 'exists:users,id'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
        ]);

        Panel::query()->create([
            ...$validated,
            'status' => PanelStatus::RESERVED,
            'solar_plant_request_id' => $solarPlantRequest->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'پنل جدید با موفقیت ثبت شد.');
    }



}
