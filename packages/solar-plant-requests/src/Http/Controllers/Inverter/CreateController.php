<?php

namespace SolarPlantRequests\Http\Controllers\Inverter;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use SolarPlantRequests\Enums\InverterStatus;
use SolarPlantRequests\Models\Inverter;
use SolarPlantRequests\Models\SolarPlantRequest;

class CreateController
{
    public function create(): View
    {
        return view('solar-plant-requests::inverters.create');
    }

    /**
     * Display a listing of the user's inverters.
     *
     * @return \Illuminate\View\View
     */
    public function myInverters(): View
    {
        $inverters = \SolarPlantRequests\Models\Inverter::query()
            ->with('request')
            ->where('manufacturer_user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('solar-plant-requests::inverters.my-inverters', compact('inverters'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial' => ['required', 'string', 'max:255', 'unique:solar_plant_inverters,serial'],
            'production_year' => ['required', 'integer', 'digits:4', 'min:1300'],
            'expiration_year' => ['required', 'integer', 'digits:4', 'gte:production_year'],
        ]);

        Inverter::query()->create([
            ...$validated,
            'status' => InverterStatus::APPROVED,
            'manufacturer_user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('solar-plant-requests.inverter.my-inverters')
            ->with('success', 'اینورتر جدید با موفقیت ثبت شد.');
    }

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

