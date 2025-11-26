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

class ContractorSolarPlantRequestController
{
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        $requests = SolarPlantRequest::query()
            ->where('contractor_id', $user->id)
            ->whereIn('status', [
                SolarPlantRequestStatus::EQUIPMENT_INSTALLATION,
            ])
            ->latest()
            ->get();


        if ($request->wantsJson()) {
            return response()->json(['data' => $requests]);
        }

        return view('solar-plant-requests::requests.contractor-list', [
            'requests' => $requests,
        ]);
    }

    public function show(Request $request, SolarPlantRequest $solarPlantRequest): View|JsonResponse
    {
        return view('solar-plant-requests::requests.contractor-show-request', [
            'solarPlantRequest' => $solarPlantRequest,
            'readOnly' => $solarPlantRequest->status == SolarPlantRequestStatus::EQUIPMENT_INSTALLATION ? false : true,
            'manufacturers' => PanelManufacturerGetController::getAll(),
            'inverterManufacturers' => InverterManufacturerGetController::getAll(),
            'batteryManufacturers' => BatteryManufacturerGetController::getAll(),
        ]);
    }

    public function sendToInspection(Request $request, SolarPlantRequest $solarPlantRequest): RedirectResponse|JsonResponse
    {
        abort_unless(
            $solarPlantRequest->contractor_id === $request->user()->id,
            403,
            'شما به این درخواست دسترسی ندارید.'
        );

        abort_unless(
            $solarPlantRequest->status === SolarPlantRequestStatus::EQUIPMENT_INSTALLATION,
            400,
            'امکان ارسال برای بازرسی در این مرحله وجود ندارد.'
        );

        abort_if(
            $solarPlantRequest->status === SolarPlantRequestStatus::INSPECTION,
            400,
            'این درخواست قبلاً برای بازرسی ارسال شده است.'
        );

        $solarPlantRequest->update(['status' => SolarPlantRequestStatus::INSPECTION]);

        if ($request->wantsJson()) {
            return response()->json(['data' => $solarPlantRequest->fresh()]);
        }

        return back()->with('success', 'درخواست با موفقیت برای بازرسی ارسال شد.');
    }
}
