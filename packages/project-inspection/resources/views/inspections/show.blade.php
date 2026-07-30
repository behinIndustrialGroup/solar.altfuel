@extends('behin-layouts.app')

@section('title', 'مشاهده بازرسی پروژه #' . $inspection->project_id)

@section('style')
<style>
    .teal-gradient-header {
        background: linear-gradient(135deg, #4DB6AC 0%, #26A69A 100%);
        color: #fff;
        border-radius: 12px;
        padding: 1.25rem 1.75rem;
        box-shadow: 0 6px 20px rgba(38, 166, 154, 0.28);
    }
    .btn-white-teal {
        background: #fff;
        color: #00695C;
        border: none;
        font-weight: 700;
        padding: .5rem 1.1rem;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,.1);
        transition: all .2s;
    }
    .btn-white-teal:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(0,0,0,.15);
        color: #004D40;
    }
    .btn-outline-new-inspect {
        background: #fff;
        color: #2E7D32;
        border: 2px solid #66BB6A;
        font-weight: 700;
        padding: .5rem 1.1rem;
        border-radius: 10px;
        transition: all .2s;
    }
    .btn-outline-new-inspect:hover {
        background: linear-gradient(135deg, #66BB6A, #43A047);
        color: #fff;
        border-color: #43A047;
        transform: translateY(-1px);
    }
    .section-card {
        border-right: 5px solid #26A69A;
        margin-bottom: 1.25rem;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.05);
        border-top: 1px solid #f0f2f4;
        border-left: 1px solid #f0f2f4;
        border-bottom: 1px solid #f0f2f4;
        background: #fff;
        overflow: hidden;
    }
    .section-card .card-body { padding: 1.1rem 1.1rem; }
    .section-card.section-info     { border-right-color: #0288D1; }
    .section-card.section-panel    { border-right-color: #FFA000; }
    .section-card.section-structure{ border-right-color: #7B1FA2; }
    .section-card.section-cable    { border-right-color: #F57C00; }
    .section-card.section-inverter { border-right-color: #1565C0; }
    .section-card.section-battery  { border-right-color: #388E3C; }
    .section-card.section-grounding{ border-right-color: #C62828; }
    .section-card.section-panelbox { border-right-color: #546E7A; }
    .section-card.section-perf     { border-right-color: #00897B; }
    .section-card.section-safety   { border-right-color: #263238; }

    .section-title {
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.55rem;
        border-bottom: 2px dashed #ECEFF1;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .section-info     .section-title { color: #0277BD; }
    .section-panel    .section-title { color: #E65100; }
    .section-structure .section-title { color: #6A1B9A; }
    .section-cable    .section-title { color: #E65100; }
    .section-inverter .section-title { color: #0D47A1; }
    .section-battery  .section-title { color: #2E7D32; }
    .section-grounding .section-title { color: #B71C1C; }
    .section-panelbox .section-title { color: #37474F; }
    .section-perf     .section-title { color: #00695C; }
    .section-safety   .section-title { color: #263238; }

    .check-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-bottom: 1px solid #F0F4F3;
        transition: background .15s;
        border-radius: 0;
    }
    .check-row:last-child { border-bottom: none; }
    .check-row:hover { background: #FAFCFD; }
    .check-row .label {
        flex: 1;
        color: #37474F;
        font-weight: 500;
        font-size: .93rem;
    }
    .status-yes {
        color: #2E7D32;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #E8F5E9;
        padding: 4px 11px;
        border-radius: 14px;
        font-size: .85rem;
    }
    .status-no {
        color: #C62828;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #FFEBEE;
        padding: 4px 11px;
        border-radius: 14px;
        font-size: .85rem;
    }
    .notes-box {
        background: linear-gradient(135deg, #F5F7FA, #ECEFF1);
        border-radius: 10px;
        padding: 12px 16px;
        margin-top: 12px;
        font-size: .88rem;
        color: #455A64;
        border-right: 3px solid #90A4AE;
    }
    .notes-box i { color: #607D8B; }
    .header-box {
        background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
        border-radius: 12px;
        padding: 1.4rem 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(67, 160, 71, 0.15);
        box-shadow: 0 3px 12px rgba(67, 160, 71, 0.08);
    }
    .header-field-label {
        font-size: .8rem;
        color: #2E7D32;
        font-weight: 700;
        margin-bottom: 4px;
        opacity: .85;
    }
    .header-field-value {
        font-size: 1.02rem;
        color: #1B5E20;
        font-weight: 800;
    }
    .header-field-value a {
        color: #0277BD;
    }
    .rejection-box {
        background: linear-gradient(135deg, #FFF5F5, #FFEBEE);
        border: 1px solid #FFCDD2;
        border-right: 5px solid #E53935;
        border-radius: 12px;
        padding: 16px 18px;
        margin-top: 1.2rem;
        box-shadow: 0 3px 10px rgba(229, 57, 53, 0.08);
    }
    .rejection-title {
        color: #B71C1C;
        font-weight: 800;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .rejection-text {
        color: #880E4F;
        font-size: .95rem;
        line-height: 1.7;
    }
    .result-badge-big {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        border-radius: 16px;
        font-weight: 800;
        font-size: 1rem;
    }
    .result-approved {
        background: linear-gradient(135deg, #81C784, #388E3C);
        color: #fff;
        box-shadow: 0 3px 10px rgba(56, 142, 60, .3);
    }
    .result-rejected {
        background: linear-gradient(135deg, #EF5350, #C62828);
        color: #fff;
        box-shadow: 0 3px 10px rgba(198, 40, 40, .3);
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
    .battery-absent-note {
        background: #F5F7FA;
        border-radius: 10px;
        padding: 12px 16px;
        color: #607D8B;
        font-size: .9rem;
        border-right: 3px solid #B0BEC5;
    }
    .unauthorized-box {
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        border: 2px dashed #FF9800;
        border-radius: 14px;
        padding: 2.5rem 1rem;
        text-align: center;
        color: #E65100;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">

        @php
            $isInspector = auth()->check() && $inspection->inspector && auth()->id() == $inspection->inspector_id;
        @endphp

        @if (!$isInspector)
            <div class="unauthorized-box mb-4">
                <i class="fa fa-lock fa-4x mb-3 d-block" style="color:#FF9800;"></i>
                <h5 class="font-weight-bold mb-2">دسترسی محدود</h5>
                <p class="mb-0 small">شما به این گزارش دسترسی ندارید. این گزارش فقط برای بازرس ثبت‌کننده قابل مشاهده است.</p>
            </div>
        @endif

        <div class="mb-4" style="border-radius:12px; overflow:hidden;">
            <div class="teal-gradient-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h3 class="card-title mb-0" style="color:#fff; font-weight:800; font-size:1.35rem;">
                        <i class="fa fa-file-text ml-2" style="text-shadow:0 0 12px rgba(255,255,255,.45);"></i>
                        گزارش بازرسی پروژه #{{ $inspection->project_id }}
                    </h3>
                    <small style="color:rgba(255,255,255,.88);" class="mr-4 d-inline-block mt-2">
                        <i class="fa fa-clipboard-check ml-1"></i> جزئیات کامل بازرسی پروژه نیروگاه خورشیدی
                    </small>
                </div>
                <div class="d-flex gap-2 flex-wrap" style="gap:.5rem;">
                    <a href="{{ route('project-inspection.inspections.create', ['project_id' => $inspection->project_id]) }}"
                       class="btn-outline-new-inspect btn-sm">
                        <i class="fa fa-plus-circle ml-1"></i> ثبت بازرسی جدید
                    </a>
                    <a href="{{ route('project-inspection.inspections.index') }}"
                       class="btn btn-white-teal btn-sm">
                        <i class="fa fa-list ml-1"></i> بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-4 flash-success-gradient">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-check-circle ml-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="header-box">
            <div class="row">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="header-field-label">
                        <i class="fa fa-folder-open ml-1"></i> شناسه پروژه
                    </div>
                    <div class="header-field-value">
                        <a href="{{ route('solar-plant-equipment.projects.show', $inspection->project_id) }}">
                            #{{ $inspection->project_id }}
                        </a>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="header-field-label">
                        <i class="fa fa-calendar ml-1"></i> تاریخ بازدید
                    </div>
                    <div class="header-field-value">{{ $inspection->visit_date_jalali }}</div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="header-field-label">
                        <i class="fa fa-user-circle ml-1"></i> بازرس
                    </div>
                    <div class="header-field-value">{{ $inspection->inspector->name ?? '—' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="header-field-label">
                        <i class="fa fa-flag-checkered ml-1"></i> نتیجه بازرسی
                    </div>
                    <div>
                        @if ($inspection->result === 'approved')
                            <span class="result-badge-big result-approved">
                                <i class="fa fa-check-circle"></i> تایید شده
                            </span>
                        @else
                            <span class="result-badge-big result-rejected">
                                <i class="fa fa-times-circle"></i> رد شده
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if ($inspection->project->request || $inspection->project->contractor)
                <div class="row mt-3 pt-3" style="border-top:1px dashed rgba(67,160,71,.25);">
                    @if ($inspection->project->request)
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="header-field-label">
                                <i class="fa fa-file-text-o ml-1"></i> کد درخواست
                            </div>
                            <div class="header-field-value" style="font-size:.95rem;">
                                {{ $inspection->project->request->unique_code ?? '#' . $inspection->project->request_id }}
                            </div>
                        </div>
                    @endif
                    @if ($inspection->project->contractor)
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="header-field-label">
                                <i class="fa fa-building ml-1"></i> پیمانکار
                            </div>
                            <div class="header-field-value" style="font-size:.95rem;">
                                {{ $inspection->project->contractor->company_name ?? '—' }}
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4">
                        <div class="header-field-label">
                            <i class="fa fa-calendar-plus-o ml-1"></i> تاریخ ثبت پروژه
                        </div>
                        <div class="header-field-value" style="font-size:.95rem;">
                            {{ \Morilog\Jalali\Jalalian::fromDateTime($inspection->project->created_at)->format('Y/m/d') }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($inspection->result === 'rejected' && $inspection->rejection_reason)
                <div class="rejection-box">
                    <div class="rejection-title">
                        <i class="fa fa-times-circle"></i> علت عدم تایید پروژه:
                    </div>
                    <div class="rejection-text">{{ $inspection->rejection_reason }}</div>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6">

                <div class="card section-card section-info">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-info-circle"></i> ۱. اطلاعات پروژه
                        </div>
                        <div class="check-row"><span class="label">اطلاعات پروژه با سامانه مطابقت دارد؟</span><span class="{{ $inspection->project_info_matches_system ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->project_info_matches_system ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->project_info_matches_system ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">ظرفیت نیروگاه صحیح است؟</span><span class="{{ $inspection->plant_capacity_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->plant_capacity_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->plant_capacity_correct ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">محل نصب مطابق اطلاعات ثبت‌شده است؟</span><span class="{{ $inspection->installation_location_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->installation_location_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->installation_location_correct ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->project_info_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->project_info_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-panel">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-sun-o"></i> ۲. پنل خورشیدی
                        </div>
                        <div class="check-row"><span class="label">برند پنل مورد تأیید اتحادیه است؟</span><span class="{{ $inspection->panel_brand_union_approved ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_brand_union_approved ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_brand_union_approved ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">برند و مدل با اطلاعات پروژه یکسان است؟</span><span class="{{ $inspection->panel_brand_matches_project ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_brand_matches_project ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_brand_matches_project ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">مدل مورد تأیید و با مدل پروژه یکسان؟</span><span class="{{ $inspection->panel_model_approved ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_model_approved ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_model_approved ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">شماره سریال صحیح است؟</span><span class="{{ $inspection->panel_serial_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_serial_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_serial_correct ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">تعداد پنل‌ها صحیح است؟</span><span class="{{ $inspection->panel_quantity_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_quantity_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_quantity_correct ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">پنل سالم و بدون شکستگی است؟</span><span class="{{ $inspection->panel_intact ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_intact ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_intact ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">جهت نصب صحیح است؟</span><span class="{{ $inspection->panel_orientation_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_orientation_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_orientation_correct ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">زاویه نصب مناسب است؟</span><span class="{{ $inspection->panel_angle_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->panel_angle_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->panel_angle_correct ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->panel_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->panel_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-structure">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-cubes"></i> ۳. سازه (استراکچر)
                        </div>
                        <div class="check-row"><span class="label">سازه استاندارد است؟</span><span class="{{ $inspection->structure_standard ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->structure_standard ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->structure_standard ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">پیچ و مهره‌ها محکم بسته شده‌اند؟</span><span class="{{ $inspection->bolts_tightened ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->bolts_tightened ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->bolts_tightened ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">خوردگی مشاهده نشده است؟</span><span class="{{ $inspection->no_corrosion ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->no_corrosion ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->no_corrosion ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">فاصله مناسب از سطح زمین رعایت شده؟</span><span class="{{ $inspection->proper_ground_clearance ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->proper_ground_clearance ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->proper_ground_clearance ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->structure_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->structure_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-cable">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-plug"></i> ۴. کابل‌کشی DC
                        </div>
                        <div class="check-row"><span class="label">کابل‌ها استاندارد هستند؟</span><span class="{{ $inspection->cable_standard ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->cable_standard ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->cable_standard ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">سطح مقطع کابل مناسب است؟</span><span class="{{ $inspection->proper_cross_section ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->proper_cross_section ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->proper_cross_section ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">کابل‌کشی به صورت صحیح انجام شده؟</span><span class="{{ $inspection->proper_cabling ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->proper_cabling ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->proper_cabling ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">کانکتورهای MC4 استاندارد هستند؟</span><span class="{{ $inspection->mc4_connectors_standard ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->mc4_connectors_standard ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->mc4_connectors_standard ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->dc_cabling_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->dc_cabling_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-inverter">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-bolt"></i> ۵. اینورتر
                        </div>
                        <div class="check-row"><span class="label">اطلاعات اینورتر با پروژه مطابقت دارد؟</span><span class="{{ $inspection->inverter_info_matches_project ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_info_matches_project ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_info_matches_project ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">برند مورد تأیید است؟</span><span class="{{ $inspection->inverter_brand_approved ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_brand_approved ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_brand_approved ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">مدل مورد تأیید است؟</span><span class="{{ $inspection->inverter_model_approved ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_model_approved ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_model_approved ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">شماره سریال صحیح است؟</span><span class="{{ $inspection->inverter_serial_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_serial_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_serial_correct ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">نصب صحیح است؟</span><span class="{{ $inspection->inverter_proper_installation ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_proper_installation ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_proper_installation ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">تهویه مناسب است؟</span><span class="{{ $inspection->inverter_ventilation_ok ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_ventilation_ok ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_ventilation_ok ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">تنظیمات صحیح است؟</span><span class="{{ $inspection->inverter_settings_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_settings_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_settings_correct ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->inverter_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->inverter_notes }}</div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="card section-card section-battery">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-battery-full"></i> ۶. باتری
                            @if (!$inspection->battery_present)
                                <span class="badge badge-secondary small" style="margin-right:auto; background:#B0BEC5; border-radius:12px; font-weight:700;">ناموجود در پروژه</span>
                            @endif
                        </div>
                        @if ($inspection->battery_present)
                            <div class="check-row"><span class="label">برند باتری مورد تأیید است؟</span><span class="{{ $inspection->battery_brand_approved ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->battery_brand_approved ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->battery_brand_approved ? 'بله' : 'خیر' }}</span></div>
                            <div class="check-row"><span class="label">مدل مورد تأیید و با پروژه همخوانی دارد؟</span><span class="{{ $inspection->battery_model_matches_project ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->battery_model_matches_project ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->battery_model_matches_project ? 'بله' : 'خیر' }}</span></div>
                            <div class="check-row"><span class="label">شماره سریال صحیح است؟</span><span class="{{ $inspection->battery_serial_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->battery_serial_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->battery_serial_correct ? 'بله' : 'خیر' }}</span></div>
                            <div class="check-row"><span class="label">کابل‌ها صحیح هستند؟</span><span class="{{ $inspection->battery_cables_correct ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->battery_cables_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->battery_cables_correct ? 'بله' : 'خیر' }}</span></div>
                            <div class="check-row"><span class="label">BMS عملکرد صحیح دارد؟</span><span class="{{ $inspection->battery_bms_ok ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->battery_bms_ok ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->battery_bms_ok ? 'بله' : 'خیر' }}</span></div>
                            <div class="check-row"><span class="label">تهویه مناسب است؟</span><span class="{{ $inspection->battery_ventilation_ok ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->battery_ventilation_ok ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->battery_ventilation_ok ? 'بله' : 'خیر' }}</span></div>
                        @else
                            <div class="battery-absent-note">
                                <i class="fa fa-info-circle ml-1"></i> این پروژه شامل سیستم باتری نمی‌باشد.
                            </div>
                        @endif
                        @if ($inspection->battery_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->battery_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-grounding">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-shield"></i> ۷. سیستم ارت و حفاظت
                        </div>
                        <div class="check-row"><span class="label">سیستم ارت اجرا شده است؟</span><span class="{{ $inspection->grounding_implemented ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->grounding_implemented ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->grounding_implemented ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">مقاومت ارت در محدوده مجاز است؟</span><span class="{{ $inspection->grounding_resistance_ok ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->grounding_resistance_ok ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->grounding_resistance_ok ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">SPD نصب شده است؟</span><span class="{{ $inspection->spd_installed ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->spd_installed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->spd_installed ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">فیوزها مناسب و استاندارد هستند؟</span><span class="{{ $inspection->fuses_appropriate ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->fuses_appropriate ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->fuses_appropriate ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">کلیدهای حفاظتی مناسب هستند؟</span><span class="{{ $inspection->protection_switches_appropriate ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->protection_switches_appropriate ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->protection_switches_appropriate ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->grounding_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->grounding_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-panelbox">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-th-large"></i> ۸. تابلو برق
                        </div>
                        <div class="check-row"><span class="label">تابلو برق استاندارد است؟</span><span class="{{ $inspection->electrical_panel_standard ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->electrical_panel_standard ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->electrical_panel_standard ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">سیم‌کشی تابلو مناسب و استاندارد است؟</span><span class="{{ $inspection->proper_wiring ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->proper_wiring ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->proper_wiring ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">برچسب‌گذاری تابلو انجام شده است؟</span><span class="{{ $inspection->labeling_done ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->labeling_done ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->labeling_done ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->electrical_panel_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->electrical_panel_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-perf">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-line-chart"></i> ۹. عملکرد نیروگاه
                        </div>
                        <div class="check-row"><span class="label">اینورتر بدون خطا و هشدار کار می‌کند؟</span><span class="{{ $inspection->inverter_no_error ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->inverter_no_error ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->inverter_no_error ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">تولید برق نیروگاه طبیعی است؟</span><span class="{{ $inspection->production_normal ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->production_normal ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->production_normal ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">سیستم مانیتورینگ فعال است؟</span><span class="{{ $inspection->monitoring_active ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->monitoring_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->monitoring_active ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">تست عملکرد نیروگاه موفق بوده است؟</span><span class="{{ $inspection->performance_test_passed ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->performance_test_passed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->performance_test_passed ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->performance_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->performance_notes }}</div>
                        @endif
                    </div>
                </div>

                <div class="card section-card section-safety">
                    <div class="card-body">
                        <div class="section-title">
                            <i class="fa fa-exclamation-triangle"></i> ۱۰. ایمنی
                        </div>
                        <div class="check-row"><span class="label">علائم هشدار نصب شده‌اند؟</span><span class="{{ $inspection->warning_signs_installed ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->warning_signs_installed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->warning_signs_installed ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">تجهیزات ایمنی رعایت شده‌اند؟</span><span class="{{ $inspection->safety_equipment_ok ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->safety_equipment_ok ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->safety_equipment_ok ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">دسترسی ایمن به تجهیزات فراهم است؟</span><span class="{{ $inspection->safe_access ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->safe_access ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->safe_access ? 'بله' : 'خیر' }}</span></div>
                        <div class="check-row"><span class="label">حفاظت در برابر آب و رطوبت انجام شده؟</span><span class="{{ $inspection->moisture_protection ? 'status-yes' : 'status-no' }}"><i class="fa {{ $inspection->moisture_protection ? 'fa-check-circle' : 'fa-times-circle' }}"></i>{{ $inspection->moisture_protection ? 'بله' : 'خیر' }}</span></div>
                        @if ($inspection->safety_notes)
                            <div class="notes-box"><i class="fa fa-sticky-note-o ml-1"></i> {{ $inspection->safety_notes }}</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
