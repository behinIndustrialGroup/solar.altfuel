@extends('behin-layouts.app')

@section('title', 'جزئیات پروژه #' . $project->id)

@section('content')
<div class="row">
    <div class="col-12">

        {{-- ── Header ── --}}
        <div class="card card-info card-outline mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fa fa-eye text-info ml-2"></i>
                    پروژه <span class="badge badge-secondary">#{{ $project->id }}</span>
                </h3>
                <div style="display:flex;gap:.4rem;">
                    <a href="{{ route('solar-plant-equipment.projects.edit', $project) }}"
                       class="btn btn-sm btn-warning">
                        <i class="fa fa-edit ml-1"></i> ویرایش پروژه
                    </a>
                    <a href="{{ route('solar-plant-equipment.projects.index') }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-arrow-right ml-1"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fa fa-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ── Info + Stats ── --}}
        <div class="row mb-3">

            {{-- اطلاعات پایه --}}
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fa fa-info ml-1"></i> اطلاعات پایه</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr>
                                <th class="text-muted" style="width:45%;padding-right:1rem">شناسه پروژه</th>
                                <td><span class="badge badge-secondary">#{{ $project->id }}</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted" style="padding-right:1rem">کد درخواست</th>
                                <td>
                                    @if ($project->request)
                                        <span class="badge badge-light border">{{ $project->request->unique_code }}</span>
                                        <small class="text-muted">
                                            —
                                            @if ($project->request->applicant_type->value === 'company')
                                                {{ $project->request->company_name }}
                                            @else
                                                {{ $project->request->first_name }} {{ $project->request->last_name }}
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">ندارد</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted" style="padding-right:1rem">پیمانکار</th>
                                <td>{{ $project->contractor?->company_name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted" style="padding-right:1rem">بازرس</th>
                                <td>
                                    @if ($project->inspector)
                                        <i class="fa fa-user-circle text-success ml-1"></i>
                                        {{ $project->inspector->name }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted" style="padding-right:1rem">تاریخ ثبت</th>
                                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($project->created_at)->format('Y/m/d') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- آمار --}}
            <div class="col-md-7">
                <div class="row">
                    <div class="col-4">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $project->installedPanels->count() }}</h3>
                                <p>پنل نصب‌شده</p>
                            </div>
                            <div class="icon"><i class="fa fa-sun-o"></i></div>
                            <a href="{{ route('solar-plant-equipment.projects.panels.create', $project) }}"
                               class="small-box-footer">
                                <i class="fa fa-plus ml-1"></i> افزودن پنل
                            </a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $project->installedInverters->count() }}</h3>
                                <p>اینورتر نصب‌شده</p>
                            </div>
                            <div class="icon"><i class="fa fa-bolt"></i></div>
                            <a href="{{ route('solar-plant-equipment.projects.inverters.create', $project) }}"
                               class="small-box-footer">
                                <i class="fa fa-plus ml-1"></i> افزودن اینورتر
                            </a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $project->installedBatteries->count() }}</h3>
                                <p>باتری نصب‌شده</p>
                            </div>
                            <div class="icon"><i class="fa fa-battery-full"></i></div>
                            <a href="{{ route('solar-plant-equipment.projects.batteries.create', $project) }}"
                               class="small-box-footer">
                                <i class="fa fa-plus ml-1"></i> افزودن باتری
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Panels Table ── --}}
        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fa fa-sun-o ml-1"></i>
                    پنل‌های نصب‌شده
                    <span class="badge badge-light text-primary mr-1">{{ $project->installedPanels->count() }}</span>
                </h6>
                <a href="{{ route('solar-plant-equipment.projects.panels.create', $project) }}"
                   class="btn btn-sm btn-light">
                    <i class="fa fa-plus ml-1"></i> افزودن پنل
                </a>
            </div>
            <div class="card-body p-0">
                @if ($project->installedPanels->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">پنلی ثبت نشده است.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>مدل</th>
                                    <th>شماره سریال</th>
                                    <th>بخش</th>
                                    <th>استرینگ</th>
                                    <th>پنل</th>
                                    <th>وضعیت</th>
                                    <th style="width:60px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sc = ['installed'=>'secondary','active'=>'success','faulty'=>'danger','replaced'=>'warning','removed'=>'dark'];
                                    $sl = \SolarPlantEquipment\Models\InstalledPanel::STATUSES;
                                @endphp
                                @foreach ($project->installedPanels as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge badge-light border">#{{ $p->panel_model_id }}</span></td>
                                    <td><code dir="ltr">{{ $p->serial_number }}</code></td>
                                    <td>{{ $p->section_number }}</td>
                                    <td>{{ $p->string_number }}</td>
                                    <td>{{ $p->panel_number }}</td>
                                    <td><span class="badge badge-{{ $sc[$p->status] ?? 'secondary' }}">{{ $sl[$p->status] ?? $p->status }}</span></td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('solar-plant-equipment.projects.panels.destroy', [$project, $p]) }}"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Inverters Table ── --}}
        <div class="card mb-3">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fa fa-bolt ml-1"></i>
                    اینورترهای نصب‌شده
                    <span class="badge badge-light text-dark mr-1">{{ $project->installedInverters->count() }}</span>
                </h6>
                <a href="{{ route('solar-plant-equipment.projects.inverters.create', $project) }}"
                   class="btn btn-sm btn-light">
                    <i class="fa fa-plus ml-1"></i> افزودن اینورتر
                </a>
            </div>
            <div class="card-body p-0">
                @if ($project->installedInverters->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">اینورتری ثبت نشده است.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tag</th>
                                    <th>مدل</th>
                                    <th>شماره سریال</th>
                                    <th>محل نصب</th>
                                    <th>وضعیت</th>
                                    <th style="width:60px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $il = \SolarPlantEquipment\Models\InstalledInverter::INSTALLATION_LOCATIONS;
                                    $is = \SolarPlantEquipment\Models\InstalledInverter::STATUSES;
                                @endphp
                                @foreach ($project->installedInverters as $inv)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong dir="ltr">{{ $inv->equipment_tag }}</strong></td>
                                    <td><span class="badge badge-light border">#{{ $inv->inverter_model_id }}</span></td>
                                    <td><code dir="ltr">{{ $inv->serial_number }}</code></td>
                                    <td>{{ $il[$inv->installation_location] ?? $inv->installation_location }}</td>
                                    <td><span class="badge badge-{{ $sc[$inv->status] ?? 'secondary' }}">{{ $is[$inv->status] ?? $inv->status }}</span></td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('solar-plant-equipment.projects.inverters.destroy', [$project, $inv]) }}"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Batteries Table ── --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fa fa-battery-full ml-1"></i>
                    باتری‌های نصب‌شده
                    <span class="badge badge-light text-success mr-1">{{ $project->installedBatteries->count() }}</span>
                </h6>
                <a href="{{ route('solar-plant-equipment.projects.batteries.create', $project) }}"
                   class="btn btn-sm btn-light">
                    <i class="fa fa-plus ml-1"></i> افزودن باتری
                </a>
            </div>
            <div class="card-body p-0">
                @if ($project->installedBatteries->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">باتری‌ای ثبت نشده است.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tag</th>
                                    <th>مدل</th>
                                    <th>شماره سریال</th>
                                    <th>محل نصب</th>
                                    <th>وضعیت</th>
                                    <th style="width:60px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bl = \SolarPlantEquipment\Models\InstalledBattery::INSTALLATION_LOCATIONS;
                                    $bs = \SolarPlantEquipment\Models\InstalledBattery::STATUSES;
                                @endphp
                                @foreach ($project->installedBatteries as $bat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong dir="ltr">{{ $bat->equipment_tag }}</strong></td>
                                    <td><span class="badge badge-light border">#{{ $bat->battery_model_id }}</span></td>
                                    <td><code dir="ltr">{{ $bat->serial_number }}</code></td>
                                    <td>{{ $bl[$bat->installation_location] ?? $bat->installation_location }}</td>
                                    <td><span class="badge badge-{{ $sc[$bat->status] ?? 'secondary' }}">{{ $bs[$bat->status] ?? $bat->status }}</span></td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('solar-plant-equipment.projects.batteries.destroy', [$project, $bat]) }}"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
