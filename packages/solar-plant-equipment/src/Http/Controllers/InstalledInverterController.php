<?php

namespace SolarPlantEquipment\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InverterCatalog\Models\InverterCatalog;
use SolarPlantEquipment\Models\InstalledInverter;
use SolarPlantEquipment\Models\SolarProject;

class InstalledInverterController
{
    public function create(SolarProject $project): View
    {
        $inverters = InverterCatalog::query()->orderBy('brand')->get();

        return view('solar-plant-equipment::installed-inverters.create', compact('project', 'inverters'));
    }

    public function store(Request $request, SolarProject $project): RedirectResponse
    {
        $validated = $request->validate([
            'inverter_model_id'     => ['required', 'integer', 'exists:inverters_catalog,id'],
            'serial_number'         => ['required', 'string', 'max:100', 'unique:installed_inverters,serial_number'],
            'equipment_tag'         => ['required', 'string', 'max:20'],
            'installation_location' => ['required', 'in:electrical_room,control_room,equipment_container,outdoor,wall_mounted,on_structure,other'],
            'status'                => ['required', 'in:installed,active,faulty,replaced,removed'],
            'notes'                 => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['project_id'] = $project->id;
        InstalledInverter::query()->create($validated);

        $ids = $project->installed_inverter_ids ?? [];
        if (! in_array((int) $validated['inverter_model_id'], $ids)) {
            $ids[] = (int) $validated['inverter_model_id'];
            $project->update(['installed_inverter_ids' => $ids]);
        }

        return redirect()
            ->route('solar-plant-equipment.projects.show', $project)
            ->with('success', 'اینورتر با موفقیت ثبت شد.');
    }

    public function destroy(SolarProject $project, InstalledInverter $inverter): RedirectResponse
    {
        $inverter->delete();

        return redirect()
            ->route('solar-plant-equipment.projects.show', $project)
            ->with('success', 'اینورتر حذف شد.');
    }
}
