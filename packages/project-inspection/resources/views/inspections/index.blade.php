@extends('behin-layouts.app')

@section('title', 'بازرسی پروژه‌ها')

@section('style')
<style>
    .solar-gradient-header {
        background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%);
        color: #fff;
        border-radius: 12px;
        padding: 1.5rem 1.75rem;
        box-shadow: 0 6px 20px rgba(255, 152, 0, 0.28);
    }
    .teal-gradient-header {
        background: linear-gradient(135deg, #4DB6AC 0%, #26A69A 100%);
        color: #fff;
        border-radius: 12px 12px 0 0;
        padding: 1rem 1.25rem;
        box-shadow: 0 3px 12px rgba(38, 166, 154, 0.2);
    }
    .stats-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 14px rgba(0,0,0,.06);
        background: #fff;
        transition: transform .25s ease, box-shadow .25s ease;
        overflow: hidden;
    }
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0,0,0,.1);
    }
    .stats-card .stats-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        flex-shrink: 0;
    }
    .stats-icon-orange { background: linear-gradient(135deg, #FFB74D, #FF9800); }
    .stats-icon-blue   { background: linear-gradient(135deg, #64B5F6, #1E88E5); }
    .stats-icon-green  { background: linear-gradient(135deg, #81C784, #43A047); }
    .stats-icon-red    { background: linear-gradient(135deg, #EF5350, #E53935); }
    .stats-card .stats-number {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1;
        color: #2c3e50;
    }
    .stats-card .stats-label {
        font-size: .82rem;
        color: #7f8c8d;
        margin-top: 4px;
        font-weight: 600;
    }
    .project-card {
        border-right: 4px solid #FF9800;
        border-radius: 12px;
        transition: transform .25s ease, box-shadow .25s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
        background: #fff;
        border-top: 1px solid #f5f5f5;
        border-left: 1px solid #f5f5f5;
        border-bottom: 1px solid #f5f5f5;
    }
    .project-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(255, 152, 0, 0.16);
    }
    .eq-badge {
        font-size: .76rem;
        padding: 5px 11px;
        border-radius: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .eq-badge-panel    { background: #FFF3E0; color: #E65100; }
    .eq-badge-inverter { background: #E3F2FD; color: #1565C0; }
    .eq-badge-battery  { background: #E8F5E9; color: #2E7D32; }
    .inspection-list-item {
        border-bottom: 1px solid #f0f4f3;
        padding: 13px 18px;
        transition: background .2s;
    }
    .inspection-list-item:hover {
        background: #f7fbfb;
    }
    .inspection-list-item:last-child {
        border-bottom: none;
    }
    .help-card {
        border-radius: 12px;
        border: 1px solid #e8e8e8;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .help-card .card-header {
        background: linear-gradient(135deg, #FFF8E1, #FFECB3);
        border-bottom: 1px solid #FFE082;
        border-radius: 0 !important;
        padding: .85rem 1.25rem;
    }
    .help-card .card-header h3 {
        color: #E65100;
    }
    .btn-white-orange {
        background: #fff;
        color: #E65100;
        border: none;
        font-weight: 700;
        padding: .5rem 1.1rem;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,.1);
        transition: all .2s;
    }
    .btn-white-orange:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(0,0,0,.15);
        color: #BF360C;
    }
    .btn-outline-green-inspect {
        background: linear-gradient(135deg, #66BB6A, #43A047);
        color: #fff;
        border: none;
        font-weight: 700;
        padding: .4rem .9rem;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(67, 160, 71, .3);
        transition: all .2s;
        font-size: .88rem;
    }
    .btn-outline-green-inspect:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(67, 160, 71, .42);
    }
    .count-badge {
        font-size: .76rem;
        padding: 5px 12px;
        border-radius: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .count-badge-green { background: #E8F5E9; color: #2E7D32; }
    .count-badge-yellow{ background: #FFF8E1; color: #F57C00; }
    .empty-state-projects {
        background: linear-gradient(135deg, #FFF8E1, #FFECB3);
        border-radius: 14px;
        padding: 3rem 1rem;
        border: 2px dashed #FFB74D;
    }
    .empty-state-recent {
        background: linear-gradient(135deg, #E0F2F1, #B2DFDB);
        border-radius: 0;
        padding: 2.5rem 1rem;
        border: none;
    }
    .flash-success-gradient {
        background: linear-gradient(135deg, #66BB6A, #43A047);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 14px rgba(67,160,71,.3);
    }
    .flash-success-gradient .close { color: #fff; opacity: .85; }
    .card-main-wrapper {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
        border: none;
        background: #fff;
    }
    .recent-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
        border: none;
        background: #fff;
    }
    .project-meta-line {
        font-size: .84rem;
        color: #607D8B;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 7px;
    }
    .project-meta-line i { color: #FF9800; width: 16px; text-align: center; }
    .project-number {
        font-size: 1.05rem;
        font-weight: 800;
        color: #263238;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .project-number i { color: #FF9800; }
    .divider-dashed {
        border-top: 1px dashed #ECEFF1;
        margin: .9rem 0;
    }
    .footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .date-label {
        font-size: .78rem;
        color: #90A4AE;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .help-list li {
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
        gap: 7px;
        line-height: 1.8;
    }
    .help-list li i {
        color: #43A047;
        margin-top: 4px;
        flex-shrink: 0;
    }
    .recent-project-link {
        font-weight: 700;
        color: #00695C;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 5px;
    }
    .recent-project-link:hover { color: #004D40; }
    .recent-project-link i { color: #26A69A; }
    .recent-date {
        font-size: .8rem;
        color: #78909C;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .recent-date i { color: #80CBC4; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-4 flash-success-gradient">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-check-circle ml-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="solar-gradient-header d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="card-title mb-0" style="color:#fff; font-weight:800; font-size:1.4rem;">
                    <i class="fa fa-clipboard-check ml-2" style="text-shadow:0 0 12px rgba(255,255,255,.5);"></i>
                    بازرسی پروژه‌ها
                </h3>
                <small style="color:rgba(255,255,255,.88);" class="mr-4 d-inline-block mt-2">
                    <i class="fa fa-sun-o ml-1"></i> پنل مدیریت بازرسی‌های نیروگاه‌های خورشیدی
                </small>
            </div>
            <a href="{{ route('project-inspection.inspections.create') }}"
               class="btn btn-white-orange btn-sm">
                <i class="fa fa-plus ml-1"></i> ثبت بازرسی جدید
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stats-icon-wrap stats-icon-orange"><i class="fa fa-folder-open"></i></div>
                <div>
                    <div class="stats-number">{{ $projects->total() }}</div>
                    <div class="stats-label">پروژه‌های اختصاص‌یافته</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stats-icon-wrap stats-icon-blue"><i class="fa fa-clipboard-list"></i></div>
                <div>
                    <div class="stats-number">{{ $inspectionCounts ? array_sum($inspectionCounts) : 0 }}</div>
                    <div class="stats-label">بازرسی‌های ثبت‌شده</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stats-icon-wrap stats-icon-green"><i class="fa fa-check-circle"></i></div>
                <div>
                    <div class="stats-number">{{ $recentInspections->where('result', 'approved')->count() }}</div>
                    <div class="stats-label">تایید شده</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stats-icon-wrap stats-icon-red"><i class="fa fa-times-circle"></i></div>
                <div>
                    <div class="stats-number">{{ $recentInspections->where('result', 'rejected')->count() }}</div>
                    <div class="stats-label">رد شده</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">

        <div class="card card-main-wrapper mb-4">
            <div class="card-body p-4">
                <h5 class="font-weight-bold mb-4" style="color:#37474F;">
                    <i class="fa fa-folder-open ml-2" style="color:#FF9800;"></i>
                    پروژه‌های من
                </h5>

                @if ($projects->isEmpty())
                    <div class="empty-state-projects text-center text-muted">
                        <i class="fa fa-folder-open-o fa-4x mb-3 d-block" style="color:#FFB74D;"></i>
                        <h6 class="font-weight-bold mb-2" style="color:#E65100;">هنوز پروژه‌ای وجود ندارد</h6>
                        <p class="mb-0 small">هیچ پروژه‌ای برای شما اختصاص داده نشده است.</p>
                    </div>
                @else
                    <div class="row">
                        @foreach ($projects as $project)
                            <div class="col-md-6 mb-3">
                                <div class="card project-card h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="project-number">
                                                <i class="fa fa-cube"></i>
                                                پروژه #{{ $project->id }}
                                            </div>
                                            @if (!empty($inspectionCounts[$project->id]))
                                                <span class="count-badge count-badge-green">
                                                    <i class="fa fa-list-alt"></i>
                                                    {{ $inspectionCounts[$project->id] }} بازرسی
                                                </span>
                                            @else
                                                <span class="count-badge count-badge-yellow">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                    بدون بازرسی
                                                </span>
                                            @endif
                                        </div>

                                        @if ($project->request)
                                            <div class="project-meta-line">
                                                <i class="fa fa-file-text-o"></i>
                                                <span>درخواست: {{ $project->request->unique_code ?? '#' . $project->request_id }}</span>
                                            </div>
                                        @endif

                                        @if ($project->contractor)
                                            <div class="project-meta-line">
                                                <i class="fa fa-building-o"></i>
                                                <span>پیمانکار: {{ $project->contractor->company_name ?? '—' }}</span>
                                            </div>
                                        @endif

                                        <div class="d-flex flex-wrap gap-2 my-3">
                                            <span class="eq-badge eq-badge-panel">
                                                <i class="fa fa-sun-o"></i>
                                                {{ count($project->installed_panel_ids ?? []) }} پنل
                                            </span>
                                            <span class="eq-badge eq-badge-inverter">
                                                <i class="fa fa-bolt"></i>
                                                {{ count($project->installed_inverter_ids ?? []) }} اینورتر
                                            </span>
                                            <span class="eq-badge eq-badge-battery">
                                                <i class="fa fa-battery-full"></i>
                                                {{ count($project->installed_battery_ids ?? []) }} باتری
                                            </span>
                                        </div>

                                        <div class="divider-dashed"></div>

                                        <div class="footer-row">
                                            <div class="date-label">
                                                <i class="fa fa-calendar"></i>
                                                ثبت: {{ \Morilog\Jalali\Jalalian::fromDateTime($project->created_at)->format('Y/m/d') }}
                                            </div>
                                            <a href="{{ route('project-inspection.inspections.create', ['project_id' => $project->id]) }}"
                                               class="btn-outline-green-inspect">
                                                <i class="fa fa-plus-circle ml-1"></i> ثبت بازرسی
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-md-4">

        <div class="card recent-card mb-4">
            <div class="teal-gradient-header">
                <h3 class="card-title mb-0" style="color:#fff; font-weight:800; font-size:1rem;">
                    <i class="fa fa-history ml-2"></i> بازرسی‌های اخیر من
                </h3>
            </div>
            <div class="card-body p-0">
                @if ($recentInspections->isEmpty())
                    <div class="empty-state-recent text-center text-muted">
                        <i class="fa fa-clipboard-list fa-3x mb-3 d-block" style="color:#4DB6AC;"></i>
                        <h6 class="font-weight-bold mb-2" style="color:#00695C;">هنوز بازرسی‌ای ثبت نشده</h6>
                        <p class="mb-0 small">شما هنوز هیچ بازرسی‌ای ثبت نکرده‌اید.</p>
                    </div>
                @else
                    @foreach ($recentInspections as $inspection)
                        <div class="inspection-list-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="{{ route('project-inspection.inspections.show', $inspection) }}"
                                       class="recent-project-link">
                                        <i class="fa fa-folder-open"></i>
                                        پروژه #{{ $inspection->project_id }}
                                    </a>
                                    <div class="recent-date">
                                        <i class="fa fa-calendar"></i>
                                        {{ $inspection->visit_date_jalali }}
                                    </div>
                                </div>
                                <div style="margin-right:8px;">
                                    {!! $inspection->result_label !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="card help-card card-outline card-secondary">
            <div class="card-header d-flex align-items-center">
                <h3 class="card-title mb-0" style="font-size:1rem; font-weight:800;">
                    <i class="fa fa-info-circle ml-2"></i> راهنما
                </h3>
            </div>
            <div class="card-body" style="background:#fff;">
                <ul class="pr-2 mb-0 small text-muted help-list list-unstyled">
                    <li>
                        <i class="fa fa-check-circle"></i>
                        لیست بالا، پروژه‌هایی را نمایش می‌دهد که شما به عنوان بازرس اختصاص داده شده‌اید.
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        برای ثبت بازرسی جدید روی دکمه «ثبت بازرسی جدید» در بالای صفحه کلیک کنید.
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        فرم بازرسی شامل ۱۰ بخش استاندارد می‌باشد که باید تکمیل گردد.
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
