<?php

namespace SolarPlantRequests\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Http\Controllers\Contractor\GetController;
use SolarPlantRequests\Http\Controllers\PanelManufacturer\GetController as PanelManufacturerGetController;
use SolarPlantRequests\Enums\PanelStatus;
use SolarPlantRequests\Models\SolarPlantRequest;

class ContractorSolarPlantRequestController
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

        return view('solar-plant-requests::requests.contractor-list', [
            'requests' => $requests,
        ]);
    }

    public function show(Request $request, SolarPlantRequest $solarPlantRequest): View|JsonResponse
    {
        return view('solar-plant-requests::requests.contractor-show-request', [
            'solarPlantRequest' => $solarPlantRequest,
            'manufacturers' => PanelManufacturerGetController::getAll(),
        ]);
    }
}
