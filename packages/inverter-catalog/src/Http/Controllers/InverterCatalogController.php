<?php

namespace InverterCatalog\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InverterCatalog\Models\InverterCatalog;

class InverterCatalogController
{
    /**
     * Display a listing of inverters
     */
    public function index(): View
    {
        $inverters = InverterCatalog::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('inverter-catalog::inverters.index', compact('inverters'));
    }

    /**
     * Show the form for creating a new inverter
     */
    public function create(): View
    {
        $standards = InverterCatalog::getAvailableStandards();
        $labs = InverterCatalog::getApprovedLabs();
        $inverterTypes = InverterCatalog::getInverterTypes();
        $coolingTypes = InverterCatalog::getCoolingTypes();
        $communicationProtocols = InverterCatalog::getCommunicationProtocols();

        return view('inverter-catalog::inverters.create', compact(
            'standards',
            'labs',
            'inverterTypes',
            'coolingTypes',
            'communicationProtocols'
        ));
    }

    /**
     * Store a newly created inverter
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Basic Information
            'brand' => ['required', 'string', 'max:255'],
            'manufacture' => ['required', 'string', 'max:255'],
            'country_of_manufacture' => ['required', 'string', 'max:255'],
            'model_name' => ['required', 'string', 'max:255'],
            'model_code' => ['required', 'string', 'max:255'],
            'inverter_type' => ['required', 'in:On-Grid,Off-Grid,Hybrid'],
            
            // Power Specifications
            'rated_power_kw' => ['required', 'numeric', 'min:0'],
            'mppt_count' => ['required', 'integer', 'min:1'],
            'strings_per_mppt' => ['required', 'integer', 'min:1'],
            
            // Electrical Specifications - Input
            'max_dc_input_voltage' => ['required', 'numeric', 'min:0'],
            'max_input_current' => ['required', 'numeric', 'min:0'],
            'mpp_voltage_range' => ['required', 'string', 'max:255'],
            'max_pv_input_power' => ['required', 'numeric', 'min:0'],
            
            // Electrical Specifications - Output
            'max_output_current' => ['required', 'numeric', 'min:0'],
            'output_voltage' => ['required', 'numeric', 'min:0'],
            'output_frequency' => ['required', 'numeric', 'min:0'],
            
            // Performance
            'max_efficiency' => ['required', 'numeric', 'min:0', 'max:100'],
            'thd' => ['nullable', 'numeric', 'min:0'],
            
            // Protection & Features
            'protection_level' => ['required', 'string', 'max:50'],
            'cooling_type' => ['nullable', 'string', 'max:50'],
            'dc_switch' => ['nullable', 'boolean'],
            'ac_switch' => ['nullable', 'boolean'],
            'reverse_polarity_protection' => ['nullable', 'boolean'],
            'display' => ['nullable', 'boolean'],
            'anti_islanding_protection' => ['nullable', 'boolean'],
            'leakage_current_protection' => ['nullable', 'boolean'],
            'spd_type' => ['nullable', 'boolean'],
            
            // Communication
            'communication_protocols' => ['nullable', 'array'],
            'communication_protocols.*' => ['string'],
            
            // Warranty & Standards
            'warranty_period' => ['required', 'string', 'max:255'],
            'standards' => ['nullable', 'array'],
            'standards.*' => ['string'],
            
            // Documentation
            'datasheet_path' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'notes' => ['nullable', 'string'],
            
            // Laboratory Certification
            'lab_certified' => ['nullable', 'boolean'],
            'lab_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Handle file upload
        if ($request->hasFile('datasheet_path')) {
            $validated['datasheet_path'] = $request->file('datasheet_path')
                ->store('inverter-datasheets', 'public');
        }

        // Convert boolean fields
        $booleanFields = [
            'dc_switch',
            'ac_switch',
            'reverse_polarity_protection',
            'display',
            'anti_islanding_protection',
            'leakage_current_protection',
            'spd_type',
            'lab_certified',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->boolean($field);
        }

        // Create inverter record
        InverterCatalog::query()->create($validated);

        return redirect()
            ->route('inverter-catalog.index')
            ->with('success', 'اینورتر جدید با موفقیت ثبت شد.');
    }

    /**
     * Display the specified inverter
     */
    public function show(InverterCatalog $inverter): View
    {
        return view('inverter-catalog::inverters.show', compact('inverter'));
    }

    /**
     * Show the form for editing the specified inverter
     */
    public function edit(InverterCatalog $inverter): View
    {
        $standards = InverterCatalog::getAvailableStandards();
        $labs = InverterCatalog::getApprovedLabs();
        $inverterTypes = InverterCatalog::getInverterTypes();
        $coolingTypes = InverterCatalog::getCoolingTypes();
        $communicationProtocols = InverterCatalog::getCommunicationProtocols();

        return view('inverter-catalog::inverters.edit', compact(
            'inverter',
            'standards',
            'labs',
            'inverterTypes',
            'coolingTypes',
            'communicationProtocols'
        ));
    }

    /**
     * Update the specified inverter
     */
    public function update(Request $request, InverterCatalog $inverter): RedirectResponse
    {
        $validated = $request->validate([
            // Basic Information
            'brand' => ['required', 'string', 'max:255'],
            'manufacture' => ['required', 'string', 'max:255'],
            'country_of_manufacture' => ['required', 'string', 'max:255'],
            'model_name' => ['required', 'string', 'max:255'],
            'model_code' => ['required', 'string', 'max:255'],
            'inverter_type' => ['required', 'in:On-Grid,Off-Grid,Hybrid'],
            
            // Power Specifications
            'rated_power_kw' => ['required', 'numeric', 'min:0'],
            'mppt_count' => ['required', 'integer', 'min:1'],
            'strings_per_mppt' => ['required', 'integer', 'min:1'],
            
            // Electrical Specifications - Input
            'max_dc_input_voltage' => ['required', 'numeric', 'min:0'],
            'max_input_current' => ['required', 'numeric', 'min:0'],
            'mpp_voltage_range' => ['required', 'string', 'max:255'],
            'max_pv_input_power' => ['required', 'numeric', 'min:0'],
            
            // Electrical Specifications - Output
            'max_output_current' => ['required', 'numeric', 'min:0'],
            'output_voltage' => ['required', 'numeric', 'min:0'],
            'output_frequency' => ['required', 'numeric', 'min:0'],
            
            // Performance
            'max_efficiency' => ['required', 'numeric', 'min:0', 'max:100'],
            'thd' => ['nullable', 'numeric', 'min:0'],
            
            // Protection & Features
            'protection_level' => ['required', 'string', 'max:50'],
            'cooling_type' => ['nullable', 'string', 'max:50'],
            'dc_switch' => ['nullable', 'boolean'],
            'ac_switch' => ['nullable', 'boolean'],
            'reverse_polarity_protection' => ['nullable', 'boolean'],
            'display' => ['nullable', 'boolean'],
            'anti_islanding_protection' => ['nullable', 'boolean'],
            'leakage_current_protection' => ['nullable', 'boolean'],
            'spd_type' => ['nullable', 'boolean'],
            
            // Communication
            'communication_protocols' => ['nullable', 'array'],
            'communication_protocols.*' => ['string'],
            
            // Warranty & Standards
            'warranty_period' => ['required', 'string', 'max:255'],
            'standards' => ['nullable', 'array'],
            'standards.*' => ['string'],
            
            // Documentation
            'datasheet_path' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'notes' => ['nullable', 'string'],
            
            // Laboratory Certification
            'lab_certified' => ['nullable', 'boolean'],
            'lab_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Handle file upload
        if ($request->hasFile('datasheet_path')) {
            $validated['datasheet_path'] = $request->file('datasheet_path')
                ->store('inverter-datasheets', 'public');
        }

        // Convert boolean fields
        $booleanFields = [
            'dc_switch',
            'ac_switch',
            'reverse_polarity_protection',
            'display',
            'anti_islanding_protection',
            'leakage_current_protection',
            'spd_type',
            'lab_certified',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->boolean($field);
        }

        // Update inverter record
        $inverter->update($validated);

        return redirect()
            ->route('inverter-catalog.index')
            ->with('success', 'اینورتر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified inverter
     */
    public function destroy(InverterCatalog $inverter): RedirectResponse
    {
        $inverter->delete();

        return redirect()
            ->route('inverter-catalog.index')
            ->with('success', 'اینورتر با موفقیت حذف شد.');
    }

    /**
     * Get the last created inverter record
     */
    public function lastRecord(): JsonResponse
    {
        $inverter = InverterCatalog::query()->latest()->first();

        return response()->json($inverter);
    }
}
