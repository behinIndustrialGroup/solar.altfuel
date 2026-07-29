<?php

namespace SolarPlantEquipment\Http\Controllers;

use BatteryCatalog\Models\BatteryCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SolarPlantEquipment\Models\InstalledBattery;
use SolarPlantEquipment\Models\SolarProject;

class InstalledBatteryController
{
    public function create(SolarProject $project): View
    {
        $batteries = BatteryCatalog::query()->orderBy('brand')->get();

        return view('solar-plant-equipment::installed-batteries.create', compact('project', 'batteries'));
    }

    public function store(Request $request, SolarProject $project): RedirectResponse
    {
        $validated = $request->validate([
            'battery_model_id'      => ['required', 'integer', 'exists:batteries_catalog,id'],
            'serial_number'         => ['required', 'string', 'max:100', 'unique:installed_batteries,serial_number'],
            'equipment_tag'         => ['required', 'string', 'max:20'],
            'installation_location' => ['required', 'in:battery_rack,battery_cabinet,battery_room,storage_container,other'],
            'status'                => ['required', 'in:installed,active,faulty,replaced,removed'],
            'notes'                 => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['project_id'] = $project->id;
        InstalledBattery::query()->create($validated);

        $ids = $project->installed_battery_ids ?? [];
        if (! in_array((int) $validated['battery_model_id'], $ids)) {
            $ids[] = (int) $validated['battery_model_id'];
            $project->update(['installed_battery_ids' => $ids]);
        }

        return redirect()
            ->route('solar-plant-equipment.projects.show', $project)
            ->with('success', 'باتری با موفقیت ثبت شد.');
    }

    public function destroy(SolarProject $project, InstalledBattery $battery): RedirectResponse
    {
        $battery->delete();

        return redirect()
            ->route('solar-plant-equipment.projects.show', $project)
            ->with('success', 'باتری حذف شد.');
    }
}
