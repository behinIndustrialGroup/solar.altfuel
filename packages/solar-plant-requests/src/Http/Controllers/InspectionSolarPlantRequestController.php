<?php

namespace SolarPlantRequests\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Http\Controllers\PanelManufacturer\GetController as PanelManufacturerGetController;
use SolarPlantRequests\Http\Controllers\InverterManufacturer\GetController as InverterManufacturerGetController;
use SolarPlantRequests\Http\Controllers\BatteryManufacturer\GetController as BatteryManufacturerGetController;
use SolarPlantRequests\Models\SolarPlantRequest;

class InspectionSolarPlantRequestController
{
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        $requests = SolarPlantRequest::query()
            ->where('contractor_id', $user->id)
            ->latest()
            ->get();


        if ($request->wantsJson()) {
            return response()->json(['data' => $requests]);
        }

        return view('solar-plant-requests::requests.inspection-list', [
            'requests' => $requests,
        ]);
    }

    public function show(Request $request, SolarPlantRequest $solarPlantRequest): View|JsonResponse
    {
        return view('solar-plant-requests::requests.inspection-show-request', [
            'solarPlantRequest' => $solarPlantRequest,
            'manufacturers' => PanelManufacturerGetController::getAll(),
            'inverterManufacturers' => InverterManufacturerGetController::getAll(),
            'batteryManufacturers' => BatteryManufacturerGetController::getAll(),
        ]);
    }

    public function approvedResult(Request $request, SolarPlantRequest $solarPlantRequest): RedirectResponse|JsonResponse
    {
        
        $solarPlantRequest->update(['status' => SolarPlantRequestStatus::CERTIFICATE_ISSUED]);

        if ($request->wantsJson()) {
            return response()->json(['data' => $solarPlantRequest->fresh()]);
        }

        return back()->with('success', 'درخواست با موفقیت تایید شد');
    }
}
