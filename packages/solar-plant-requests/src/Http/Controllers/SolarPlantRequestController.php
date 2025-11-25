<?php

namespace SolarPlantRequests\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Models\SolarPlantRequest;

class SolarPlantRequestController
{
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        $requests = SolarPlantRequest::query()
            ->visibleTo($user)
            ->latest()
            ->get();

        if ($request->wantsJson()) {
            return response()->json(['data' => $requests]);
        }

        return view('solar-plant-requests::requests.index', [
            'requests' => $requests,
        ]);
    }

    public function store(Request $request): View|JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'national_code' => ['required', 'string', 'max:20'],
            'postal_code' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'bill_identifier' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'integer', 'min:0'],
        ]);

        $solarPlantRequest = SolarPlantRequest::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'status' => SolarPlantRequestStatus::UNDER_REVIEW,
        ]);

        return $this->index($request);
    }

    public function assignContractor(Request $request, SolarPlantRequest $solarPlantRequest): JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'فقط کاربر دارای نقش راهبر می‌تواند پیمانکار تخصیص دهد.'
        );

        $validated = $request->validate([
            'contractor_id' => ['required', 'integer', 'exists:users,id'],
            'contractor_name' => ['required', 'string', 'max:255'],
        ]);

        $solarPlantRequest->fill([
            'contractor_id' => $validated['contractor_id'],
            'contractor_name' => $validated['contractor_name'],
            'status' => SolarPlantRequestStatus::EQUIPMENT_INSTALLATION,
        ]);

        $solarPlantRequest->save();

        return response()->json($solarPlantRequest->fresh());
    }
}
