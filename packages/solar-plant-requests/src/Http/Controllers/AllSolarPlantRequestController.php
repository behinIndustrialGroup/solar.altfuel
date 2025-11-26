<?php

namespace SolarPlantRequests\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Http\Controllers\Contractor\GetController;
use SolarPlantRequests\Models\SolarPlantRequest;

class AllSolarPlantRequestController
{
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        $requests = SolarPlantRequest::query()
            ->whereIn('status', [
                SolarPlantRequestStatus::UNDER_REVIEW,
                SolarPlantRequestStatus::INSPECTION,
            ])
            ->latest()
            ->get();

        $contractors = GetController::getAll();

        if ($request->wantsJson()) {
            return response()->json(['data' => $requests]);
        }

        return view('solar-plant-requests::requests.all-requests', [
            'requests' => $requests,
            'contractors' => $contractors,
        ]);
    }

    public function assignContractor(Request $request, SolarPlantRequest $solarPlantRequest)
    {
        $validated = $request->validate([
            'contractor_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $solarPlantRequest->fill([
            'contractor_id' => $validated['contractor_id'],
            'contractor_name' => GetController::getById($validated['contractor_id'])->name,
            'status' => SolarPlantRequestStatus::EQUIPMENT_INSTALLATION,
        ]);

        $solarPlantRequest->save();

        return redirect()->route('solar-plant-requests.all-requests.index')->with('success', 'پیمانکار تخصیص شد.');
    }
}
