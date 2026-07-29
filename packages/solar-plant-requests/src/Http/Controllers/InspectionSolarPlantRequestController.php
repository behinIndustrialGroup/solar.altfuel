<?php

namespace SolarPlantRequests\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SolarPlantRequests\Enums\BatteryStatus;
use SolarPlantRequests\Enums\InverterStatus;
use SolarPlantRequests\Enums\PanelStatus;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;
use SolarPlantRequests\Http\Controllers\PanelManufacturer\GetController as PanelManufacturerGetController;
use SolarPlantRequests\Http\Controllers\InverterManufacturer\GetController as InverterManufacturerGetController;
use SolarPlantRequests\Http\Controllers\BatteryManufacturer\GetController as BatteryManufacturerGetController;
use SolarPlantRequests\Http\Controllers\Inspector\GetController;
use SolarPlantRequests\Models\SolarPlantRequest;

class InspectionSolarPlantRequestController
{
    public function index(Request $request): View|JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'inspector')
            || SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'شما دسترسی به این صفحه ندارید.'
        );

        $user = $request->user();

        $query = SolarPlantRequest::query()
            ->where('status', SolarPlantRequestStatus::INSPECTION)
            ->latest();

        if (!SolarPlantRequest::userHasRole($user, 'leader')) {
            $query->where(function ($q) use ($user) {
                $q->where('inspector_user_id', $user->id)
                    ->orWhereNull('inspector_user_id');
            });
        }

        $requests = $query->get();

        if ($request->wantsJson()) {
            return response()->json(['data' => $requests]);
        }

        return view('solar-plant-requests::requests.inspection-list', [
            'requests' => $requests,
        ]);
    }

    public function show(Request $request, SolarPlantRequest $solarPlantRequest): View|JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'inspector')
            || SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'شما دسترسی به این صفحه ندارید.'
        );

        abort_unless(
            $solarPlantRequest->status === SolarPlantRequestStatus::INSPECTION,
            400,
            'این درخواست در مرحله بازرسی نیست.'
        );

        return view('solar-plant-requests::requests.inspection-show-request', [
            'solarPlantRequest' => $solarPlantRequest,
            'manufacturers' => PanelManufacturerGetController::getAll(),
            'inverterManufacturers' => InverterManufacturerGetController::getAll(),
            'batteryManufacturers' => BatteryManufacturerGetController::getAll(),
        ]);
    }

    public function approvedResult(Request $request, SolarPlantRequest $solarPlantRequest): RedirectResponse|JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'inspector')
            || SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'شما دسترسی به این عملیات ندارید.'
        );

        abort_unless(
            $solarPlantRequest->status === SolarPlantRequestStatus::INSPECTION,
            400,
            'این درخواست در مرحله بازرسی نیست.'
        );

        $solarPlantRequest->update([
            'inspector_user_id' => $request->user()->id,
            'inspector_name' => GetController::getById($request->user()->id)->name,
            'status' => SolarPlantRequestStatus::CERTIFICATE_ISSUED,
        ]);

        $solarPlantRequest->panels()->update([
            'status' => PanelStatus::USED,
        ]);

        $solarPlantRequest->inverters()->update([
            'status' => InverterStatus::USED,
        ]);

        $solarPlantRequest->batteries()->update([
            'status' => BatteryStatus::USED,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['data' => $solarPlantRequest->fresh()]);
        }

        return back()->with('success', 'درخواست با موفقیت تایید شد و گواهی صادر گردید.');
    }

    public function declinedResult(Request $request, SolarPlantRequest $solarPlantRequest): RedirectResponse|JsonResponse
    {
        abort_unless(
            SolarPlantRequest::userHasRole($request->user(), 'inspector')
            || SolarPlantRequest::userHasRole($request->user(), 'leader'),
            403,
            'شما دسترسی به این عملیات ندارید.'
        );

        abort_unless(
            $solarPlantRequest->status === SolarPlantRequestStatus::INSPECTION,
            400,
            'این درخواست در مرحله بازرسی نیست.'
        );

        $solarPlantRequest->update([
            'inspector_user_id' => $request->user()->id,
            'inspector_name' => GetController::getById($request->user()->id)->name,
            'status' => SolarPlantRequestStatus::EQUIPMENT_INSTALLATION,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['data' => $solarPlantRequest->fresh()]);
        }

        return back()->with('success', 'درخواست بازرسی رد شد و برای اصلاح به پیمانکار بازگردانده شد.');
    }
}
