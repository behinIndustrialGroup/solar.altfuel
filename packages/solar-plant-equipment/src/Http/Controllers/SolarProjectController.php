<?php

namespace SolarPlantEquipment\Http\Controllers;

use App\Models\User;
use BatteryCatalog\Models\BatteryCatalog;
use ContractorCatalog\Models\Contractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InverterCatalog\Models\InverterCatalog;
use PanelCatalog\Models\PanelCatalog;
use SolarPlantEquipment\Models\SolarProject;
use SolarPlantRequests\Models\SolarPlantRequest;

class SolarProjectController
{
    /** role_id of inspectors in the users table */
    private const INSPECTOR_ROLE_ID = 13;

    private function getFormData(): array
    {
        return [
            'requests'    => SolarPlantRequest::query()->latest()->get(),
            'contractors' => Contractor::query()->orderBy('company_name')->get(),
            'inspectors'  => User::query()->where('role_id', self::INSPECTOR_ROLE_ID)->orderBy('name')->get(),
            'panels'      => PanelCatalog::query()->orderBy('brand')->get(),
            'inverters'   => InverterCatalog::query()->orderBy('brand')->get(),
            'batteries'   => BatteryCatalog::query()->orderBy('brand')->get(),
        ];
    }

    public function index(): View
    {
        $projects = SolarProject::query()->latest()->paginate(15);

        return view('solar-plant-equipment::projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('solar-plant-equipment::projects.create', $this->getFormData());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'request_id'               => ['nullable', 'integer'],
            'contractor_id'            => ['nullable', 'integer', 'exists:contractors,id'],
            'inspector_id'             => ['nullable', 'integer', 'exists:users,id'],
            'installed_panel_ids'      => ['nullable', 'array'],
            'installed_panel_ids.*'    => ['integer', 'exists:panels_catalog,id'],
            'installed_inverter_ids'   => ['nullable', 'array'],
            'installed_inverter_ids.*' => ['integer', 'exists:inverters_catalog,id'],
            'installed_battery_ids'    => ['nullable', 'array'],
            'installed_battery_ids.*'  => ['integer', 'exists:batteries_catalog,id'],
        ]);

        SolarProject::query()->create($validated);

        return redirect()
            ->route('solar-plant-equipment.projects.index')
            ->with('success', 'پروژه با موفقیت ثبت شد.');
    }

    public function show(SolarProject $project): View
    {
        $project->load(['installedPanels', 'installedInverters', 'installedBatteries', 'request', 'contractor', 'inspector']);

        $panels    = \PanelCatalog\Models\PanelCatalog::query()->orderBy('brand')->get();
        $inverters = \InverterCatalog\Models\InverterCatalog::query()->orderBy('brand')->get();
        $batteries = \BatteryCatalog\Models\BatteryCatalog::query()->orderBy('brand')->get();

        return view('solar-plant-equipment::projects.show', compact('project', 'panels', 'inverters', 'batteries'));
    }

    public function edit(SolarProject $project): View
    {
        return view('solar-plant-equipment::projects.edit', array_merge(
            $this->getFormData(),
            ['project' => $project]
        ));
    }

    public function update(Request $request, SolarProject $project): RedirectResponse
    {
        $validated = $request->validate([
            'request_id'               => ['nullable', 'integer'],
            'contractor_id'            => ['nullable', 'integer', 'exists:contractors,id'],
            'inspector_id'             => ['nullable', 'integer', 'exists:users,id'],
            'installed_panel_ids'      => ['nullable', 'array'],
            'installed_panel_ids.*'    => ['integer', 'exists:panels_catalog,id'],
            'installed_inverter_ids'   => ['nullable', 'array'],
            'installed_inverter_ids.*' => ['integer', 'exists:inverters_catalog,id'],
            'installed_battery_ids'    => ['nullable', 'array'],
            'installed_battery_ids.*'  => ['integer', 'exists:batteries_catalog,id'],
        ]);

        $project->update($validated);

        return redirect()
            ->route('solar-plant-equipment.projects.index')
            ->with('success', 'پروژه با موفقیت ویرایش شد.');
    }
}
