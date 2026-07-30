<?php

namespace PanelCatalog\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PanelCatalog\Models\PanelCatalog;

class PanelCatalogController
{
    public function index(): View
    {
        $panels = PanelCatalog::query()->orderBy('created_at', 'desc')->get();

        return view('panel-catalog::panels.index', compact('panels'));
    }

    public function create(): View
    {
        return view('panel-catalog::panels.create');
    }

    public function store(Request $request)
    {
        $dateFields = ['production_date', 'discontinuation_date'];
        foreach ($dateFields as $field) {
            if ($request->has($field) && !empty($request->input($field))) {
                $request->merge([$field => toGregorianDate($request->input($field))]);
            }
        }

        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'manufacture' => ['required', 'string', 'max:255'],
            'country_of_manufacture' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'model_code' => ['required', 'string', 'max:255'],
            'technology' => ['required', 'string', 'max:255'],
            'panel_type' => ['required', 'in:Monofacial,Bifacial'],
            'rated_power_wp' => ['required', 'numeric', 'min:0'],
            'module_efficiency' => ['required', 'numeric', 'min:0', 'max:100'],
            'number_of_cells' => ['required', 'integer', 'min:1'],
            'cell_type' => ['required', 'in:Half cell,Full cell'],
            'voc' => ['required', 'numeric', 'min:0'],
            'isc' => ['required', 'numeric', 'min:0'],
            'vmp' => ['required', 'numeric', 'min:0'],
            'imp' => ['required', 'numeric', 'min:0'],
            'max_system_voltage' => ['required', 'numeric', 'min:0'],
            'temperature_coefficient' => ['required', 'numeric'],
            'power_tolerance' => ['required', 'string', 'max:255'],
            'product_warranty' => ['required', 'string', 'max:255'],
            'performance_warranty' => ['required', 'string', 'max:255'],
            'iec_61215' => ['nullable', 'boolean'],
            'iec_61730' => ['nullable', 'boolean'],
            'connector_type' => ['required', 'string', 'max:255'],
            'dimensions' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            'datasheet_path' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'datasheet_version' => ['nullable', 'string', 'max:255'],
            'union_approval_status' => ['nullable', 'string', 'max:255'],
            'production_date' => ['nullable', 'date'],
            'discontinuation_date' => ['nullable', 'date'],
            'lab_certified' => ['nullable', 'boolean'],
            'lab_name' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('datasheet_path')) {
            $validated['datasheet_path'] = $request->file('datasheet_path')->store('datasheets', 'public');
        }

        $validated['iec_61215'] = $request->boolean('iec_61215');
        $validated['iec_61730'] = $request->boolean('iec_61730');
        $validated['lab_certified'] = $request->boolean('lab_certified');

        if ($validated['lab_certified'] && !empty($validated['lab_name'])
            && $validated['iec_61215'] && $validated['iec_61730']) {
            $validated['union_approval_status'] = 'union-approved';
        }

        PanelCatalog::query()->create($validated);

        return redirect()
            ->route('panel-catalog.index')
            ->with('success', 'پنل جدید با موفقیت ثبت شد.');
    }

    public function destroy(PanelCatalog $panel)
    {
        $panel->delete();

        return redirect()
            ->route('panel-catalog.index')
            ->with('success', 'پنل با موفقیت حذف شد.');
    }

    public function lastRecord(): JsonResponse
    {
        $panel = PanelCatalog::query()->latest()->first();

        if ($panel) {
            $arr = $panel->toArray();
            if (!empty($arr['production_date'])) {
                $arr['production_date'] = toJalaliFormatted($panel->production_date, 'Y/m/d');
            }
            if (!empty($arr['discontinuation_date'])) {
                $arr['discontinuation_date'] = toJalaliFormatted($panel->discontinuation_date, 'Y/m/d');
            }
            return response()->json($arr);
        }

        return response()->json($panel);
    }
}
