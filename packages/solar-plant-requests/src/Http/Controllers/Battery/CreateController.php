<?php

namespace SolarPlantRequests\Http\Controllers\Battery;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use SolarPlantRequests\Enums\BatteryStatus;
use SolarPlantRequests\Models\Battery;
use SolarPlantRequests\Models\SolarPlantRequest;

class CreateController
{
    public function create(): View
    {
        return view('solar-plant-requests::batteries.create');
    }

    /**
     * Display a listing of the user's batteries.
     *
     * @return \Illuminate\View\View
     */
    public function myBatteries(): View
    {
        $batteries = \SolarPlantRequests\Models\Battery::query()
            ->with('request')
            ->where('manufacturer_user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('solar-plant-requests::batteries.my-batteries', compact('batteries'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_batteries,serial'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
        ]);

        Battery::query()->create([
            ...$validated,
            'status' => BatteryStatus::APPROVED,
            'manufacturer_user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('solar-plant-requests.battery.my-batteries')
            ->with('success', 'باتری جدید با موفقیت ثبت شد.');
    }

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
