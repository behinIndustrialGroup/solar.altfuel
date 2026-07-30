<?php

namespace ProjectInspection\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use ProjectInspection\Models\ProjectInspection;
use SolarPlantEquipment\Models\SolarProject;

class ProjectInspectionController
{
    private const INSPECTOR_ROLE_ID = 13;

    private function getInspectorProjects()
    {
        $userId = Auth::id();

        return SolarProject::query()
            ->where('inspector_id', $userId)
            ->latest()
            ->with(['request', 'contractor', 'inspector'])
            ->paginate(15);
    }

    public function index(): View
    {
        $userId = Auth::id();
        $projects = $this->getInspectorProjects();

        $inspectionCounts = [];
        foreach ($projects as $project) {
            $inspectionCounts[$project->id] = ProjectInspection::query()
                ->where('project_id', $project->id)
                ->count();
        }

        $recentInspections = ProjectInspection::query()
            ->where('inspector_id', $userId)
            ->latest()
            ->with('project')
            ->take(10)
            ->get();

        return view('project-inspection::inspections.index', compact(
            'projects',
            'inspectionCounts',
            'recentInspections'
        ));
    }

    public function create(Request $request): View
    {
        $userId = Auth::id();

        $projectQuery = SolarProject::query()
            ->where('inspector_id', $userId)
            ->with(['request', 'contractor', 'installedPanels', 'installedInverters', 'installedBatteries']);

        if ($request->filled('project_id')) {
            $project = (clone $projectQuery)
                ->where('id', $request->project_id)
                ->firstOrFail();
        } else {
            $project = $projectQuery->first();
            if (!$project) {
                abort(404, 'هیچ پروژه‌ای برای شما اختصاص داده نشده است.');
            }
        }

        $availableProjects = SolarProject::query()
            ->where('inspector_id', $userId)
            ->latest()
            ->get();

        return view('project-inspection::inspections.create', compact(
            'project',
            'availableProjects'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'project_id' => [
                'required',
                'integer',
                'exists:solar_projects,id',
                function ($attribute, $value, $fail) use ($userId) {
                    $project = SolarProject::query()->find($value);
                    if (!$project || $project->inspector_id !== $userId) {
                        $fail('این پروژه متعلق به شما نیست.');
                    }
                },
            ],
            'visit_date' => ['required', 'date'],
            'result' => ['required', 'in:approved,rejected'],
            'rejection_reason' => ['nullable', 'string'],

            'project_info_matches_system'   => ['nullable', 'boolean'],
            'plant_capacity_correct'        => ['nullable', 'boolean'],
            'installation_location_correct' => ['nullable', 'boolean'],
            'project_info_notes'            => ['nullable', 'string'],

            'panel_brand_union_approved'  => ['nullable', 'boolean'],
            'panel_brand_matches_project' => ['nullable', 'boolean'],
            'panel_model_approved'        => ['nullable', 'boolean'],
            'panel_serial_correct'        => ['nullable', 'boolean'],
            'panel_quantity_correct'      => ['nullable', 'boolean'],
            'panel_intact'                => ['nullable', 'boolean'],
            'panel_orientation_correct'   => ['nullable', 'boolean'],
            'panel_angle_correct'         => ['nullable', 'boolean'],
            'panel_notes'                 => ['nullable', 'string'],

            'structure_standard'      => ['nullable', 'boolean'],
            'bolts_tightened'         => ['nullable', 'boolean'],
            'no_corrosion'            => ['nullable', 'boolean'],
            'proper_ground_clearance' => ['nullable', 'boolean'],
            'structure_notes'         => ['nullable', 'string'],

            'cable_standard'          => ['nullable', 'boolean'],
            'proper_cross_section'    => ['nullable', 'boolean'],
            'proper_cabling'          => ['nullable', 'boolean'],
            'mc4_connectors_standard' => ['nullable', 'boolean'],
            'dc_cabling_notes'        => ['nullable', 'string'],

            'inverter_info_matches_project' => ['nullable', 'boolean'],
            'inverter_brand_approved'       => ['nullable', 'boolean'],
            'inverter_model_approved'       => ['nullable', 'boolean'],
            'inverter_serial_correct'       => ['nullable', 'boolean'],
            'inverter_proper_installation'  => ['nullable', 'boolean'],
            'inverter_ventilation_ok'       => ['nullable', 'boolean'],
            'inverter_settings_correct'     => ['nullable', 'boolean'],
            'inverter_notes'                => ['nullable', 'string'],

            'battery_present'              => ['nullable', 'boolean'],
            'battery_brand_approved'       => ['nullable', 'boolean'],
            'battery_model_matches_project'=> ['nullable', 'boolean'],
            'battery_serial_correct'       => ['nullable', 'boolean'],
            'battery_cables_correct'       => ['nullable', 'boolean'],
            'battery_bms_ok'               => ['nullable', 'boolean'],
            'battery_ventilation_ok'       => ['nullable', 'boolean'],
            'battery_notes'                => ['nullable', 'string'],

            'grounding_implemented'         => ['nullable', 'boolean'],
            'grounding_resistance_ok'       => ['nullable', 'boolean'],
            'spd_installed'                 => ['nullable', 'boolean'],
            'fuses_appropriate'             => ['nullable', 'boolean'],
            'protection_switches_appropriate' => ['nullable', 'boolean'],
            'grounding_notes'               => ['nullable', 'string'],

            'electrical_panel_standard' => ['nullable', 'boolean'],
            'proper_wiring'             => ['nullable', 'boolean'],
            'labeling_done'             => ['nullable', 'boolean'],
            'electrical_panel_notes'    => ['nullable', 'string'],

            'inverter_no_error'        => ['nullable', 'boolean'],
            'production_normal'        => ['nullable', 'boolean'],
            'monitoring_active'        => ['nullable', 'boolean'],
            'performance_test_passed'  => ['nullable', 'boolean'],
            'performance_notes'        => ['nullable', 'string'],

            'warning_signs_installed' => ['nullable', 'boolean'],
            'safety_equipment_ok'     => ['nullable', 'boolean'],
            'safe_access'             => ['nullable', 'boolean'],
            'moisture_protection'     => ['nullable', 'boolean'],
            'safety_notes'            => ['nullable', 'string'],
        ]);

        $validated['inspector_id'] = $userId;

        $booleanFields = [
            'project_info_matches_system',
            'plant_capacity_correct',
            'installation_location_correct',
            'panel_brand_union_approved',
            'panel_brand_matches_project',
            'panel_model_approved',
            'panel_serial_correct',
            'panel_quantity_correct',
            'panel_intact',
            'panel_orientation_correct',
            'panel_angle_correct',
            'structure_standard',
            'bolts_tightened',
            'no_corrosion',
            'proper_ground_clearance',
            'cable_standard',
            'proper_cross_section',
            'proper_cabling',
            'mc4_connectors_standard',
            'inverter_info_matches_project',
            'inverter_brand_approved',
            'inverter_model_approved',
            'inverter_serial_correct',
            'inverter_proper_installation',
            'inverter_ventilation_ok',
            'inverter_settings_correct',
            'battery_present',
            'battery_brand_approved',
            'battery_model_matches_project',
            'battery_serial_correct',
            'battery_cables_correct',
            'battery_bms_ok',
            'battery_ventilation_ok',
            'grounding_implemented',
            'grounding_resistance_ok',
            'spd_installed',
            'fuses_appropriate',
            'protection_switches_appropriate',
            'electrical_panel_standard',
            'proper_wiring',
            'labeling_done',
            'inverter_no_error',
            'production_normal',
            'monitoring_active',
            'performance_test_passed',
            'warning_signs_installed',
            'safety_equipment_ok',
            'safe_access',
            'moisture_protection',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = isset($validated[$field]) && $validated[$field] ? true : false;
        }

        $inspection = ProjectInspection::query()->create($validated);

        $project = SolarProject::query()->find($validated['project_id']);
        $existingIds = $project->inspection_ids ?? [];
        $existingIds[] = $inspection->id;
        $project->inspection_ids = array_values(array_unique($existingIds));
        $project->save();

        return redirect()
            ->route('project-inspection.inspections.show', $inspection)
            ->with('success', 'بازرسی با موفقیت ثبت شد.');
    }

    public function show(ProjectInspection $inspection): View
    {
        $userId = Auth::id();

        if ($inspection->inspector_id !== $userId) {
            abort(403, 'شما مجاز به مشاهده این بازرسی نیستید.');
        }

        $inspection->load(['project', 'project.request', 'project.contractor', 'project.installedPanels', 'project.installedInverters', 'project.installedBatteries', 'inspector']);

        return view('project-inspection::inspections.show', compact('inspection'));
    }
}
