@extends('behin-layouts.app')

@section('title', 'جزئیات پروژه #' . $project->id)

@section('style')
<style>
    body {
        direction: rtl;
        text-align: right;
    }

    .solar-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(255, 152, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .solar-card-header {
        background: linear-gradient(90deg, #FFB74D 0%, #FF9800 100%);
        color: #fff;
        padding: 1rem 1.25rem;
        border: none;
    }

    .solar-card-header h3,
    .solar-card-header h6 {
        margin: 0;
        font-weight: 700;
        color: #fff;
    }

    .solar-card-header i {
        margin-left: 0.5rem;
    }

    .solar-card-body {
        padding: 1.5rem;
        background: #fff;
    }

    .info-card-header {
        background: linear-gradient(90deg, #FFCC80 0%, #FFB74D 100%);
        color: #fff;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    .info-card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .info-card-header i {
        margin-left: 0.5rem;
    }

    .blue-card-header {
        background: #E3F2FD;
        border-bottom: 3px solid #2196F3;
        padding: 0.85rem 1.25rem;
    }

    .blue-card-header h6 {
        margin: 0;
        font-weight: 700;
        color: #1565C0;
        font-size: 0.95rem;
    }

    .blue-card-header i {
        margin-left: 0.5rem;
        color: #2196F3;
    }

    .green-card-header {
        background: #E8F5E9;
        border-bottom: 3px solid #43A047;
        padding: 0.85rem 1.25rem;
    }

    .green-card-header h6 {
        margin: 0;
        font-weight: 700;
        color: #2E7D32;
        font-size: 0.95rem;
    }

    .green-card-header i {
        margin-left: 0.5rem;
        color: #43A047;
    }

    .teal-card-header {
        background: linear-gradient(90deg, #4DB6AC 0%, #26A69A 100%);
        color: #fff;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    .teal-card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
        color: #fff;
    }

    .teal-card-header i {
        margin-left: 0.5rem;
    }

    .panel-card-header {
        background: linear-gradient(90deg, #42A5F5 0%, #2196F3 100%);
        color: #fff;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    .panel-card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
        color: #fff;
    }

    .panel-card-header i {
        margin-left: 0.5rem;
    }

    .inverter-card-header {
        background: linear-gradient(90deg, #FFD54F 0%, #FFC107 100%);
        color: #fff;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    .inverter-card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
        color: #fff;
    }

    .inverter-card-header i {
        margin-left: 0.5rem;
    }

    .battery-card-header {
        background: linear-gradient(90deg, #81C784 0%, #66BB6A 100%);
        color: #fff;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    .battery-card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
        color: #fff;
    }

    .battery-card-header i {
        margin-left: 0.5rem;
    }

    .header-btn {
        background: #fff;
        border: 2px solid #fff;
        border-radius: 8px;
        padding: 0.45rem 0.9rem;
        font-weight: 600;
        font-size: 0.82rem;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .header-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .header-btn-orange {
        color: #FF9800;
    }

    .header-btn-orange:hover {
        background: #FFF3E0;
        border-color: #FFF3E0;
        color: #E65100;
    }

    .header-btn-green {
        color: #43A047;
    }

    .header-btn-green:hover {
        background: #E8F5E9;
        border-color: #E8F5E9;
        color: #2E7D32;
    }

    .header-btn-gray {
        color: #616161;
    }

    .header-btn-gray:hover {
        background: #F5F5F5;
        border-color: #F5F5F5;
        color: #424242;
    }

    .info-table {
        margin: 0;
    }

    .info-table tr th {
        width: 45%;
        padding: 0.7rem 1rem;
        color: #757575;
        font-weight: 600;
        background: #FAFAFA;
        border-bottom: 1px solid #F0F0F0;
        font-size: 0.88rem;
    }

    .info-table tr td {
        padding: 0.7rem 1rem;
        color: #374151;
        font-weight: 500;
        border-bottom: 1px solid #F0F0F0;
        font-size: 0.88rem;
    }

    .info-table tr:last-child th,
    .info-table tr:last-child td {
        border-bottom: none;
    }

    .solar-small-box {
        border-radius: 12px;
        color: #fff;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        min-height: 130px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .solar-small-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.14);
    }

    .solar-small-box.bg-gradient-blue {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    }

    .solar-small-box.bg-gradient-yellow {
        background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%);
    }

    .solar-small-box.bg-gradient-green {
        background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%);
    }

    .solar-small-box .inner h3 {
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0;
        color: #fff;
    }

    .solar-small-box .inner p {
        margin: 0.4rem 0 0;
        font-size: 0.9rem;
        font-weight: 600;
        opacity: 0.95;
    }

    .solar-small-box .solar-icon {
        position: absolute;
        top: 1rem;
        left: 1rem;
        font-size: 3rem;
        opacity: 0.3;
    }

    .solar-small-box-footer {
        display: block;
        margin-top: 0.8rem;
        padding: 0.5rem 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
        text-align: center;
        font-size: 0.82rem;
        font-weight: 600;
        transition: background 0.2s ease;
        text-decoration: none;
    }

    .solar-small-box-footer:hover {
        background: rgba(255, 255, 255, 0.3);
        color: #fff;
        text-decoration: none;
    }

    .solar-small-box-footer i {
        margin-left: 0.35rem;
    }

    .badge-count-light {
        background: rgba(255, 255, 255, 0.22);
        color: #fff;
        border-radius: 20px;
        padding: 0.15rem 0.65rem;
        font-size: 0.78rem;
        font-weight: 700;
        margin-right: 0.4rem;
    }

    .data-table thead th {
        background: #FAFAFA;
        color: #616161;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 0.75rem 0.85rem;
        border-bottom: 2px solid #E0E0E0;
    }

    .data-table tbody td {
        padding: 0.7rem 0.85rem;
        vertical-align: middle;
        font-size: 0.85rem;
        border-bottom: 1px solid #F0F0F0;
        color: #374151;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: #FFF8E1;
    }

    .empty-state {
        padding: 2.5rem 1rem;
        text-align: center;
        color: #9E9E9E;
        font-size: 0.9rem;
    }

    .empty-state i {
        display: block;
        font-size: 3rem;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }

    .btn-add-card {
        background: #fff;
        color: #fff;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .panel-card-header .btn-add-card {
        color: #1976D2;
    }

    .panel-card-header .btn-add-card:hover {
        background: #BBDEFB;
        color: #0D47A1;
    }

    .inverter-card-header .btn-add-card {
        color: #FF9800;
    }

    .inverter-card-header .btn-add-card:hover {
        background: #FFE0B2;
        color: #E65100;
    }

    .battery-card-header .btn-add-card {
        color: #2E7D32;
    }

    .battery-card-header .btn-add-card:hover {
        background: #C8E6C9;
        color: #1B5E20;
    }

    .teal-card-header .btn-add-card {
        background: #fff;
        color: #26A69A;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .teal-card-header .btn-add-card:hover {
        background: #B2DFDB;
        color: #00695C;
    }

    .solar-alert-success {
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
        color: #2E7D32;
        box-shadow: 0 2px 10px rgba(76, 175, 80, 0.12);
        margin-bottom: 1.5rem;
    }

    .solar-alert-success .close {
        color: #2E7D32;
        opacity: 0.8;
    }

    .solar-alert-success i {
        font-size: 1.1rem;
        margin-left: 0.5rem;
    }

    .row-gap > [class*="col-"] {
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">

        {{-- ── Header Card ── --}}
        <div class="solar-card">
            <div class="solar-card-header d-flex align-items-center justify-content-between flex-wrap" style="gap: 0.75rem;">
                <div class="d-flex align-items-center">
                    <i class="fa fa-sun-o" style="font-size: 1.5rem;"></i>
                    <h3 style="font-size: 1.1rem;">
                        جزئیات پروژه نیروگاه خورشیدی
                        <span class="badge-count-light">#{{ $project->id }}</span>
                    </h3>
                </div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    @if ($project->status === \SolarPlantEquipment\Models\SolarProject::STATUS_APPROVED)
                        <a href="{{ route('solar-plant-equipment.projects.health-certificate', $project) }}"
                           class="header-btn header-btn-green" target="_blank">
                            <i class="fa fa-certificate ml-1"></i> گواهی سلامت (PDF)
                        </a>
                    @endif
                    <a href="{{ route('solar-plant-equipment.projects.edit', $project) }}"
                       class="header-btn header-btn-orange">
                        <i class="fa fa-edit ml-1"></i> ویرایش پروژه
                    </a>
                    <a href="{{ route('solar-plant-equipment.projects.index') }}"
                       class="header-btn header-btn-gray">
                        <i class="fa fa-arrow-right ml-1"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="alert alert-success solar-alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fa fa-check-circle"></i>
                <span style="font-weight: 600;">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ── Info + Stats Row ── --}}
        <div class="row row-gap">

            {{-- ستون راست ۵/۱۲: اطلاعات پایه --}}
            <div class="col-md-5">
                <div class="solar-card h-100 mb-0">
                    <div class="info-card-header">
                        <h6><i class="fa fa-info-circle"></i> اطلاعات پایه پروژه</h6>
                    </div>
                    <div class="p-0">
                        <table class="table info-table">
                            <tr>
                                <th>شناسه پروژه</th>
                                <td><span class="badge badge-secondary" style="background:#FF9800;border:none;">#{{ $project->id }}</span></td>
                            </tr>
                            <tr>
                                <th>کد درخواست</th>
                                <td>
                                    @if ($project->request)
                                        <span class="badge" style="background:#FFF3E0;color:#E65100;border:1px solid #FFE0B2;">{{ $project->request->unique_code }}</span>
                                        <small class="text-muted mr-2">
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
                                <th>پیمانکار</th>
                                <td>{{ $project->contractor?->company_name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>بازرس</th>
                                <td>
                                    @if ($project->inspector)
                                        <i class="fa fa-user-circle ml-1" style="color:#43A047;"></i>
                                        {{ $project->inspector->name }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>وضعیت پروژه</th>
                                <td>{!! $project->status_label !!}</td>
                            </tr>
                            <tr>
                                <th>تاریخ ثبت</th>
                                <td>
                                    <i class="fa fa-calendar-alt ml-1" style="color:#FFB74D;"></i>
                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($project->created_at)->format('Y/m/d') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ستون چپ ۷/۱۲: سه کارت آماری --}}
            <div class="col-md-7">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="solar-small-box bg-gradient-blue">
                            <i class="fa fa-sun-o solar-icon"></i>
                            <div class="inner">
                                <h3>{{ $project->installedPanels->count() }}</h3>
                                <p>پنل نصب‌شده</p>
                            </div>
                            <a href="{{ route('solar-plant-equipment.projects.panels.create', $project) }}"
                               class="solar-small-box-footer">
                                <i class="fa fa-plus"></i> افزودن پنل
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="solar-small-box bg-gradient-yellow">
                            <i class="fa fa-bolt solar-icon"></i>
                            <div class="inner">
                                <h3>{{ $project->installedInverters->count() }}</h3>
                                <p>اینورتر نصب‌شده</p>
                            </div>
                            <a href="{{ route('solar-plant-equipment.projects.inverters.create', $project) }}"
                               class="solar-small-box-footer">
                                <i class="fa fa-plus"></i> افزودن اینورتر
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="solar-small-box bg-gradient-green">
                            <i class="fa fa-battery-full solar-icon"></i>
                            <div class="inner">
                                <h3>{{ $project->installedBatteries->count() }}</h3>
                                <p>باتری نصب‌شده</p>
                            </div>
                            <a href="{{ route('solar-plant-equipment.projects.batteries.create', $project) }}"
                               class="solar-small-box-footer">
                                <i class="fa fa-plus"></i> افزودن باتری
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── ردیف دوم: دو کارت کنار هم ── --}}
        <div class="row row-gap">
            <div class="col-md-6">
                <div class="solar-card h-100 mb-0">
                    <div class="blue-card-header d-flex align-items-center">
                        <h6><i class="fa fa-calendar-check-o"></i> تاریخ‌ها و قرارداد</h6>
                    </div>
                    <div class="p-0">
                        <table class="table info-table">
                            <tr>
                                <th>تاریخ شروع نصب</th>
                                <td>
                                    @if ($project->installation_start_date)
                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($project->installation_start_date)->format('Y/m/d') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>تاریخ پایان نصب</th>
                                <td>
                                    @if ($project->installation_end_date)
                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($project->installation_end_date)->format('Y/m/d') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>تاریخ بهره برداری</th>
                                <td>
                                    @if ($project->commissioning_date)
                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($project->commissioning_date)->format('Y/m/d') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>شماره قرارداد ساتبا</th>
                                <td>{{ $project->satba_contract_number ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>مختصات جغرافیایی</th>
                                <td>
                                    @if ($project->latitude && $project->longitude)
                                        <span dir="ltr">
                                            <i class="fa fa-map-marker ml-1" style="color:#E53935;"></i>
                                            {{ number_format((float)$project->latitude, 6) }}, {{ number_format((float)$project->longitude, 6) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="solar-card h-100 mb-0">
                    <div class="green-card-header d-flex align-items-center">
                        <h6><i class="fa fa-id-card-o"></i> گواهی سلامت و توضیحات</h6>
                    </div>
                    <div class="p-0">
                        <table class="table info-table">
                            <tr>
                                <th>شماره گواهی سلامت</th>
                                <td>{{ $project->health_card_no ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>تاریخ صدور گواهی</th>
                                <td>
                                    @if ($project->health_card_issue_date)
                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($project->health_card_issue_date)->format('Y/m/d') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>تاریخ انقضای گواهی</th>
                                <td>
                                    @if ($project->health_card_expiry_date)
                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($project->health_card_expiry_date)->format('Y/m/d') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align:top;">توضیحات</th>
                                <td style="white-space:pre-line;">{{ $project->description ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── بازرسی‌های ثبت‌شده ── --}}
        @if (class_exists(\ProjectInspection\Models\ProjectInspection::class))
            <div class="solar-card">
                <div class="teal-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap: 0.5rem;">
                    <h6>
                        <i class="fa fa-clipboard-check"></i>
                        بازرسی‌های ثبت‌شده
                        <span class="badge-count-light">{{ $project->inspections->count() }}</span>
                    </h6>
                    @auth
                        @if (auth()->id() == $project->inspector_id)
                            <a href="{{ route('project-inspection.inspections.create', ['project_id' => $project->id]) }}"
                               class="btn btn-add-card">
                                <i class="fa fa-plus ml-1"></i> ثبت بازرسی جدید
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="p-0">
                    @if ($project->inspections->isEmpty())
                        <div class="empty-state">
                            <i class="fa fa-clipboard-list"></i>
                            هنوز بازرسی‌ای برای این پروژه ثبت نشده است.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table data-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:50px">#</th>
                                        <th>تاریخ بازدید</th>
                                        <th>بازرس</th>
                                        <th>نتیجه</th>
                                        <th>علت عدم تایید</th>
                                        <th style="width:80px">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->inspections as $insp)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $insp->visit_date_jalali }}</td>
                                        <td>{{ optional($insp->inspector)->name ?? '—' }}</td>
                                        <td>{!! $insp->result_label !!}</td>
                                        <td>{{ $insp->rejection_reason ?? '—' }}</td>
                                        <td>
                                            <a href="{{ route('project-inspection.inspections.show', $insp) }}"
                                               class="btn btn-xs" title="مشاهده گزارش"
                                               style="background:#E0F2F1;color:#00695C;border-radius:6px;padding:3px 9px;font-weight:600;">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- ── پنل‌های نصب‌شده ── --}}
        <div class="solar-card">
            <div class="panel-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap: 0.5rem;">
                <h6>
                    <i class="fa fa-sun-o"></i>
                    پنل‌های نصب‌شده
                    <span class="badge-count-light">{{ $project->installedPanels->count() }}</span>
                </h6>
                <a href="{{ route('solar-plant-equipment.projects.panels.create', $project) }}"
                   class="btn btn-add-card">
                    <i class="fa fa-plus ml-1"></i> افزودن پنل
                </a>
            </div>
            <div class="p-0">
                @if ($project->installedPanels->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-solar-panel"></i>
                        پنلی ثبت نشده است.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:50px">#</th>
                                    <th>مدل</th>
                                    <th>شماره سریال</th>
                                    <th>بخش</th>
                                    <th>استرینگ</th>
                                    <th>پنل</th>
                                    <th>وضعیت</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sc = ['installed'=>'secondary','active'=>'success','faulty'=>'danger','replaced'=>'warning','removed'=>'dark'];
                                    $sl = \SolarPlantEquipment\Models\InstalledPanel::STATUSES;
                                @endphp
                                @foreach ($project->installedPanels as $p)
                                <tr>
                                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                                    <td><span class="badge badge-light border">#{{ $p->panel_model_id }}</span></td>
                                    <td><code dir="ltr">{{ $p->serial_number }}</code></td>
                                    <td>{{ $p->section_number }}</td>
                                    <td>{{ $p->string_number }}</td>
                                    <td>{{ $p->panel_number }}</td>
                                    <td><span class="badge badge-{{ $sc[$p->status] ?? 'secondary' }}" style="border-radius:6px;">{{ $sl[$p->status] ?? $p->status }}</span></td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('solar-plant-equipment.projects.panels.destroy', [$project, $p]) }}"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs"
                                                    style="background:#FFEBEE;color:#C62828;border-radius:6px;padding:3px 9px;font-weight:600;">
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

        {{-- ── اینورترهای نصب‌شده ── --}}
        <div class="solar-card">
            <div class="inverter-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap: 0.5rem;">
                <h6>
                    <i class="fa fa-bolt"></i>
                    اینورترهای نصب‌شده
                    <span class="badge-count-light">{{ $project->installedInverters->count() }}</span>
                </h6>
                <a href="{{ route('solar-plant-equipment.projects.inverters.create', $project) }}"
                   class="btn btn-add-card">
                    <i class="fa fa-plus ml-1"></i> افزودن اینورتر
                </a>
            </div>
            <div class="p-0">
                @if ($project->installedInverters->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-bolt"></i>
                        اینورتری ثبت نشده است.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:50px">#</th>
                                    <th>Tag</th>
                                    <th>مدل</th>
                                    <th>شماره سریال</th>
                                    <th>محل نصب</th>
                                    <th>وضعیت</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $il = \SolarPlantEquipment\Models\InstalledInverter::INSTALLATION_LOCATIONS;
                                    $is = \SolarPlantEquipment\Models\InstalledInverter::STATUSES;
                                @endphp
                                @foreach ($project->installedInverters as $inv)
                                <tr>
                                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                                    <td><strong dir="ltr">{{ $inv->equipment_tag }}</strong></td>
                                    <td><span class="badge badge-light border">#{{ $inv->inverter_model_id }}</span></td>
                                    <td><code dir="ltr">{{ $inv->serial_number }}</code></td>
                                    <td>{{ $il[$inv->installation_location] ?? $inv->installation_location }}</td>
                                    <td><span class="badge badge-{{ $sc[$inv->status] ?? 'secondary' }}" style="border-radius:6px;">{{ $is[$inv->status] ?? $inv->status }}</span></td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('solar-plant-equipment.projects.inverters.destroy', [$project, $inv]) }}"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs"
                                                    style="background:#FFEBEE;color:#C62828;border-radius:6px;padding:3px 9px;font-weight:600;">
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

        {{-- ── باتری‌های نصب‌شده ── --}}
        <div class="solar-card mb-4">
            <div class="battery-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap: 0.5rem;">
                <h6>
                    <i class="fa fa-battery-full"></i>
                    باتری‌های نصب‌شده
                    <span class="badge-count-light">{{ $project->installedBatteries->count() }}</span>
                </h6>
                <a href="{{ route('solar-plant-equipment.projects.batteries.create', $project) }}"
                   class="btn btn-add-card">
                    <i class="fa fa-plus ml-1"></i> افزودن باتری
                </a>
            </div>
            <div class="p-0">
                @if ($project->installedBatteries->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-battery-full"></i>
                        باتری‌ای ثبت نشده است.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:50px">#</th>
                                    <th>Tag</th>
                                    <th>مدل</th>
                                    <th>شماره سریال</th>
                                    <th>محل نصب</th>
                                    <th>وضعیت</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bl = \SolarPlantEquipment\Models\InstalledBattery::INSTALLATION_LOCATIONS;
                                    $bs = \SolarPlantEquipment\Models\InstalledBattery::STATUSES;
                                @endphp
                                @foreach ($project->installedBatteries as $bat)
                                <tr>
                                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                                    <td><strong dir="ltr">{{ $bat->equipment_tag }}</strong></td>
                                    <td><span class="badge badge-light border">#{{ $bat->battery_model_id }}</span></td>
                                    <td><code dir="ltr">{{ $bat->serial_number }}</code></td>
                                    <td>{{ $bl[$bat->installation_location] ?? $bat->installation_location }}</td>
                                    <td><span class="badge badge-{{ $sc[$bat->status] ?? 'secondary' }}" style="border-radius:6px;">{{ $bs[$bat->status] ?? $bat->status }}</span></td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('solar-plant-equipment.projects.batteries.destroy', [$project, $bat]) }}"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs"
                                                    style="background:#FFEBEE;color:#C62828;border-radius:6px;padding:3px 9px;font-weight:600;">
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
