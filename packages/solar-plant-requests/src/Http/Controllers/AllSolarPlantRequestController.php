<?php

namespace SolarPlantRequests\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Http\Controllers\Contractor\GetController;
use SolarPlantRequests\Models\SolarPlantRequest;

class AllSolarPlantRequestController
{
    public function index(Request $request): View|JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'فقط کاربر دارای نقش راهبر می‌تواند به همه درخواست‌ها دسترسی داشته باشد.'
        );

        $user = $request->user();

        $requests = SolarPlantRequest::query()
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

    public function assignContractor(Request $request, SolarPlantRequest $solarPlantRequest): RedirectResponse|JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'فقط کاربر دارای نقش راهبر می‌تواند پیمانکار تخصیص دهد.'
        );

        $validated = $request->validate([
            'contractor_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $contractor = GetController::getById($validated['contractor_id']);

        abort_if(
            !$contractor,
            422,
            'پیمانکار انتخابی معتبر نیست.'
        );

        $solarPlantRequest->fill([
            'contractor_id' => $validated['contractor_id'],
            'contractor_name' => $contractor->name,
            'status' => SolarPlantRequestStatus::EQUIPMENT_INSTALLATION,
        ]);

        $solarPlantRequest->save();

        if ($request->wantsJson()) {
            return response()->json(['data' => $solarPlantRequest->fresh()]);
        }

        return redirect()->route('solar-plant-requests.all-requests.index')->with('success', 'پیمانکار با موفقیت تخصیص شد.');
    }
}
