<?php

namespace SolarPlantEquipment\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PanelCatalog\Models\PanelCatalog;
use SolarPlantEquipment\Models\InstalledPanel;
use SolarPlantEquipment\Models\SolarProject;

class InstalledPanelController
{
    public function create(SolarProject $project): View
    {
        $panels = PanelCatalog::query()->orderBy('brand')->get();

        return view('solar-plant-equipment::installed-panels.create', compact('project', 'panels'));
    }

    public function store(Request $request, SolarProject $project): RedirectResponse
    {
        $validated = $request->validate([
            'panel_model_id' => ['required', 'integer', 'exists:panels_catalog,id'],
            'serial_number'  => ['required', 'string', 'max:100', 'unique:installed_panels,serial_number'],
            'section_number' => ['required', 'integer', 'min:1'],
            'string_number'  => ['required', 'integer', 'min:1'],
            'panel_number'   => ['required', 'integer', 'min:1'],
            'status'         => ['required', 'in:installed,active,faulty,replaced,removed'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['project_id'] = $project->id;
        InstalledPanel::query()->create($validated);

        // sync model id into project JSON array
        $ids = $project->installed_panel_ids ?? [];
        if (! in_array((int) $validated['panel_model_id'], $ids)) {
            $ids[] = (int) $validated['panel_model_id'];
            $project->update(['installed_panel_ids' => $ids]);
        }

        return redirect()
            ->route('solar-plant-equipment.projects.show', $project)
            ->with('success', 'پنل با موفقیت ثبت شد.');
    }

    public function destroy(SolarProject $project, InstalledPanel $panel): RedirectResponse
    {
        $panel->delete();

        return redirect()
            ->route('solar-plant-equipment.projects.show', $project)
            ->with('success', 'پنل حذف شد.');
    }
}
