<?php

namespace BatteryCatalog\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use BatteryCatalog\Models\BatteryCatalog;

class BatteryCatalogController
{
    /**
     * Display a listing of batteries
     */
    public function index(): View
    {
        $batteries = BatteryCatalog::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('battery-catalog::batteries.index', compact('batteries'));
    }

    /**
     * Show the form for creating a new battery
     */
    public function create(): View
    {
        $batteryTypes = BatteryCatalog::getBatteryTypes();
        $standards = BatteryCatalog::getAvailableStandards();
        $labs = BatteryCatalog::getApprovedLabs();
        $communicationProtocols = BatteryCatalog::getCommunicationProtocols();
        $ipRatings = BatteryCatalog::getIpRatings();

        return view('battery-catalog::batteries.create', compact(
            'batteryTypes',
            'standards',
            'labs',
            'communicationProtocols',
            'ipRatings'
        ));
    }

    /**
     * Store a newly created battery
     */
    public function store(Request $request): RedirectResponse
    {
        $dateFields = ['union_approval_date'];
        foreach ($dateFields as $field) {
            if ($request->has($field) && !empty($request->input($field))) {
                $request->merge([$field => toGregorianDate($request->input($field))]);
            }
        }

        $validated = $request->validate([
            // Basic Information
            'brand' => ['required', 'string', 'max:255'],
            'manufacture' => ['required', 'string', 'max:255'],
            'country_of_manufacture' => ['required', 'string', 'max:255'],
            'model_name' => ['required', 'string', 'max:255'],
            'model_code' => ['required', 'string', 'max:255'],
            'battery_type' => ['required', 'string', 'max:100'],
            
            // Capacity & Voltage
            'energy_capacity_kwh' => ['required', 'numeric', 'min:0'],
            'capacity_ah' => ['required', 'numeric', 'min:0'],
            'nominal_voltage' => ['required', 'numeric', 'min:0'],
            
            // Charge & Discharge
            'max_charge_current' => ['required', 'numeric', 'min:0'],
            'max_discharge_current' => ['required', 'numeric', 'min:0'],
            
            // Performance
            'cycle_life' => ['required', 'integer', 'min:0'],
            'depth_of_discharge' => ['required', 'numeric', 'min:0', 'max:100'],
            
            // Expandability
            'expandable' => ['nullable', 'boolean'],
            'max_parallel_units' => ['nullable', 'integer', 'min:1'],
            
            // Protection & Communication
            'ip_rating' => ['required', 'string', 'max:50'],
            'communication_protocols' => ['nullable', 'array'],
            'communication_protocols.*' => ['string'],
            
            // Physical Specifications
            'dimensions' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            
            // Warranty & Standards
            'warranty_years' => ['required', 'integer', 'min:0'],
            'standards' => ['nullable', 'array'],
            'standards.*' => ['string'],
            
            // Documentation
            'datasheet_path' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'notes' => ['nullable', 'string'],
            
            // Union Approval
            'union_approved' => ['nullable', 'boolean'],
            'union_approval_date' => ['nullable', 'date'],
            
            // Laboratory Certification
            'lab_certified' => ['nullable', 'boolean'],
            'lab_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Handle file upload
        if ($request->hasFile('datasheet_path')) {
            $validated['datasheet_path'] = $request->file('datasheet_path')
                ->store('battery-datasheets', 'public');
        }

        // Convert boolean fields
        $validated['expandable'] = $request->boolean('expandable');
        $validated['union_approved'] = $request->boolean('union_approved');
        $validated['lab_certified'] = $request->boolean('lab_certified');

        // Auto-approve if all conditions are met
        if ($validated['lab_certified'] && !empty($validated['lab_name']) && !empty($validated['datasheet_path'])) {
            $validated['union_approved'] = true;
            if (empty($validated['union_approval_date'])) {
                $validated['union_approval_date'] = now();
            }
        }

        BatteryCatalog::query()->create($validated);

        return redirect()
            ->route('battery-catalog.index')
            ->with('success', 'باتری جدید با موفقیت ثبت شد.');
    }

    /**
     * Display the specified battery
     */
    public function show(BatteryCatalog $battery): View
    {
        return view('battery-catalog::batteries.show', compact('battery'));
    }

    /**
     * Show the form for editing the specified battery
     */
    public function edit(BatteryCatalog $battery): View
    {
        $batteryTypes = BatteryCatalog::getBatteryTypes();
        $standards = BatteryCatalog::getAvailableStandards();
        $labs = BatteryCatalog::getApprovedLabs();
        $communicationProtocols = BatteryCatalog::getCommunicationProtocols();
        $ipRatings = BatteryCatalog::getIpRatings();

        return view('battery-catalog::batteries.edit', compact(
            'battery',
            'batteryTypes',
            'standards',
            'labs',
            'communicationProtocols',
            'ipRatings'
        ));
    }

    /**
     * Update the specified battery
     */
    public function update(Request $request, BatteryCatalog $battery): RedirectResponse
    {
        $dateFields = ['union_approval_date'];
        foreach ($dateFields as $field) {
            if ($request->has($field) && !empty($request->input($field))) {
                $request->merge([$field => toGregorianDate($request->input($field))]);
            }
        }

        $validated = $request->validate([
            // Basic Information
            'brand' => ['required', 'string', 'max:255'],
            'manufacture' => ['required', 'string', 'max:255'],
            'country_of_manufacture' => ['required', 'string', 'max:255'],
            'model_name' => ['required', 'string', 'max:255'],
            'model_code' => ['required', 'string', 'max:255'],
            'battery_type' => ['required', 'string', 'max:100'],
            
            // Capacity & Voltage
            'energy_capacity_kwh' => ['required', 'numeric', 'min:0'],
            'capacity_ah' => ['required', 'numeric', 'min:0'],
            'nominal_voltage' => ['required', 'numeric', 'min:0'],
            
            // Charge & Discharge
            'max_charge_current' => ['required', 'numeric', 'min:0'],
            'max_discharge_current' => ['required', 'numeric', 'min:0'],
            
            // Performance
            'cycle_life' => ['required', 'integer', 'min:0'],
            'depth_of_discharge' => ['required', 'numeric', 'min:0', 'max:100'],
            
            // Expandability
            'expandable' => ['nullable', 'boolean'],
            'max_parallel_units' => ['nullable', 'integer', 'min:1'],
            
            // Protection & Communication
            'ip_rating' => ['required', 'string', 'max:50'],
            'communication_protocols' => ['nullable', 'array'],
            'communication_protocols.*' => ['string'],
            
            // Physical Specifications
            'dimensions' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            
            // Warranty & Standards
            'warranty_years' => ['required', 'integer', 'min:0'],
            'standards' => ['nullable', 'array'],
            'standards.*' => ['string'],
            
            // Documentation
            'datasheet_path' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'notes' => ['nullable', 'string'],
            
            // Union Approval
            'union_approved' => ['nullable', 'boolean'],
            'union_approval_date' => ['nullable', 'date'],
            
            // Laboratory Certification
            'lab_certified' => ['nullable', 'boolean'],
            'lab_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Handle file upload
        if ($request->hasFile('datasheet_path')) {
            $validated['datasheet_path'] = $request->file('datasheet_path')
                ->store('battery-datasheets', 'public');
        }

        // Convert boolean fields
        $validated['expandable'] = $request->boolean('expandable');
        $validated['union_approved'] = $request->boolean('union_approved');
        $validated['lab_certified'] = $request->boolean('lab_certified');

        // Auto-approve if all conditions are met
        if ($validated['lab_certified'] && !empty($validated['lab_name']) && isset($validated['datasheet_path'])) {
            $validated['union_approved'] = true;
            if (empty($validated['union_approval_date'])) {
                $validated['union_approval_date'] = now();
            }
        }

        $battery->update($validated);

        return redirect()
            ->route('battery-catalog.index')
            ->with('success', 'باتری با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified battery
     */
    public function destroy(BatteryCatalog $battery): RedirectResponse
    {
        $battery->delete();

        return redirect()
            ->route('battery-catalog.index')
            ->with('success', 'باتری با موفقیت حذف شد.');
    }

    /**
     * Get the last created battery record
     */
    public function lastRecord(): JsonResponse
    {
        $battery = BatteryCatalog::query()->latest()->first();

        if ($battery) {
            $arr = $battery->toArray();
            if (!empty($arr['union_approval_date'])) {
                $arr['union_approval_date'] = toJalaliFormatted($battery->union_approval_date, 'Y/m/d');
            }
            return response()->json($arr);
        }

        return response()->json($battery);
    }
}
