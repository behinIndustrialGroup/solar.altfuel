@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card rounded-4 border-0 shadow mb-4 overflow-hidden">
            <div class="card-header py-4 px-4 border-0" style="background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 30%, #FFA726 70%, #FF9800 100%);">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                            <i class="fa fa-file-alt fa-2x text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white fw-bold">جزئیات اینورتر</h3>
                            <p class="mb-0 text-white text-opacity-90 small mt-1">
                                <i class="fa fa-cube me-1"></i>
                                <strong>{{ $inverter->brand }} {{ $inverter->model_name }}</strong>
                                <span class="mx-2">|</span>
                                کد مدل: <code class="bg-white bg-opacity-25 px-2 py-1 rounded text-white">{{ $inverter->model_code }}</code>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('inverter-catalog.edit', $inverter) }}" class="btn btn-warning btn-lg rounded-pill px-4 shadow-sm fw-bold">
                            <i class="fa fa-edit ms-2"></i> ویرایش
                        </a>
                        <a href="{{ route('inverter-catalog.index') }}" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm fw-bold" style="color: #1565C0;">
                            <i class="fa fa-arrow-right ms-2"></i> بازگشت
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-lg-6">
                <div class="card rounded-4 border-0 shadow h-100 overflow-hidden">
                    <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%);">
                        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                            <i class="fa fa-info-circle me-2"></i>اطلاعات پایه
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-medium">برند</div>
                                <div class="col-7 fw-bold" style="color: #E65100;">{{ $inverter->brand }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-medium">سازنده</div>
                                <div class="col-7">{{ $inverter->manufacture }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-medium">کشور تولید</div>
                                <div class="col-7">{{ $inverter->country_of_manufacture }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-medium">نام مدل</div>
                                <div class="col-7 fw-medium">{{ $inverter->model_name }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-medium">کد مدل</div>
                                <div class="col-7"><code class="bg-light px-2 py-1 rounded">{{ $inverter->model_code }}</code></div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-5 text-muted fw-medium">نوع اینورتر</div>
                                <div class="col-7">
                                    <span class="badge rounded-pill py-2 px-3" style="background: #FFF3E0; color: #E65100; font-size: 0.85rem;">
                                        <i class="fa fa-bolt me-1"></i>{{ $inverter->inverter_type }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6">
                <div class="card rounded-4 border-0 shadow h-100 overflow-hidden">
                    <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #42A5F5 0%, #1E88E5 100%);">
                        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                            <i class="fa fa-bolt me-2"></i>مشخصات الکتریکی
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">توان نامی</div>
                                <div class="col-6 fw-bold text-end" style="color: #1565C0;">{{ $inverter->rated_power_kw }} <small>kW</small></div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">تعداد MPPT</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->mppt_count }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">ورودی در هر MPPT</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->strings_per_mppt }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">حداکثر ولتاژ DC</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->max_dc_input_voltage }} <small>V</small></div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">حداکثر جریان ورودی</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->max_input_current }} <small>A</small></div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">محدوده MPP</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->mpp_voltage_range }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">حداکثر PV ورودی</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->max_pv_input_power }} <small>kW</small></div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">حداکثر جریان خروجی</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->max_output_current }} <small>A</small></div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">ولتاژ خروجی AC</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->output_voltage }} <small>V</small></div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-6 text-muted fw-medium">فرکانس خروجی</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->output_frequency }} <small>Hz</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-12">
                <div class="card rounded-4 border-0 shadow h-100 overflow-hidden">
                    <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%);">
                        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                            <i class="fa fa-sliders me-2"></i>ویژگی‌ها و استانداردها
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">حداکثر راندمان</div>
                                <div class="col-6 fw-bold text-end text-success">{{ $inverter->max_efficiency }}%</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">THD</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->thd ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">درجه حفاظت</div>
                                <div class="col-6 text-end">
                                    <span class="badge rounded-pill bg-info text-white py-2 px-3" style="font-size: 0.85rem;">{{ $inverter->protection_level }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">روش خنک سازی</div>
                                <div class="col-6 fw-bold text-end">{{ $inverter->cooling_type ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2">
                                <div class="col-6 text-muted fw-medium">مدت گارانتی</div>
                                <div class="col-6 fw-bold text-end" style="color: #2E7D32;">
                                    <i class="fa fa-calendar-check me-1"></i>{{ $inverter->warranty_period }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="row mb-2 align-items-center">
                                <div class="col-6 text-muted fw-medium">استانداردها</div>
                                <div class="col-6 text-end">
                                    @if($inverter->standards)
                                        @foreach($inverter->standards as $standard)
                                            <span class="badge rounded-pill bg-light text-dark border me-1 mb-1 py-1 px-2">{{ $standard }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-6 text-muted fw-medium">پروتکل‌ها</div>
                                <div class="col-6 text-end">
                                    @if($inverter->communication_protocols)
                                        @foreach($inverter->communication_protocols as $protocol)
                                            <span class="badge rounded-pill py-1 px-2 me-1 mb-1" style="background: #E3F2FD; color: #1565C0;">{{ $protocol }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="card rounded-4 border-0 shadow h-100 overflow-hidden">
                    <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #BA68C8 0%, #9C27B0 100%);">
                        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                            <i class="fa fa-shield-alt me-2"></i>ویژگی‌های حفاظتی
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->dc_switch ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">کلید DC</span>
                                    {!! $inverter->dc_switch ? '<span class="badge rounded-pill bg-success py-2 px-3"><i class="fa fa-check me-1"></i>دارد</span>' : '<span class="badge rounded-pill bg-danger py-2 px-3"><i class="fa fa-times me-1"></i>ندارد</span>' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->ac_switch ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">کلید AC</span>
                                    {!! $inverter->ac_switch ? '<span class="badge rounded-pill bg-success py-2 px-3"><i class="fa fa-check me-1"></i>دارد</span>' : '<span class="badge rounded-pill bg-danger py-2 px-3"><i class="fa fa-times me-1"></i>ندارد</span>' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->reverse_polarity_protection ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">حفاظت پلاریته</span>
                                    {!! $inverter->reverse_polarity_protection ? '<i class="fa fa-check-circle text-success fa-2x"></i>' : '<i class="fa fa-times-circle text-danger fa-2x"></i>' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->display ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">نمایشگر</span>
                                    {!! $inverter->display ? '<i class="fa fa-check-circle text-success fa-2x"></i>' : '<i class="fa fa-times-circle text-danger fa-2x"></i>' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->anti_islanding_protection ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">ضد جزیره‌ای</span>
                                    {!! $inverter->anti_islanding_protection ? '<i class="fa fa-check-circle text-success fa-2x"></i>' : '<i class="fa fa-times-circle text-danger fa-2x"></i>' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->leakage_current_protection ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">حفاظت نشتی</span>
                                    {!! $inverter->leakage_current_protection ? '<i class="fa fa-check-circle text-success fa-2x"></i>' : '<i class="fa fa-times-circle text-danger fa-2x"></i>' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: {{ $inverter->spd_type ? '#E8F5E9' : '#FFEBEE' }};">
                                    <span class="fw-medium">SPD</span>
                                    {!! $inverter->spd_type ? '<i class="fa fa-check-circle text-success fa-2x"></i>' : '<i class="fa fa-times-circle text-danger fa-2x"></i>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card rounded-4 border-0 shadow h-100 overflow-hidden">
                    <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #26A69A 0%, #00897B 100%);">
                        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                            <i class="fa fa-stamp me-2"></i>تاییدیه‌ها و مدارک
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="p-4 rounded-3" style="background: {{ $inverter->lab_certified ? '#E8F5E9' : '#FFF3E0' }};">
                                    <div class="text-muted small mb-1 fw-medium">تاییدیه آزمایشگاه</div>
                                    <div class="mt-2">
                                        @if($inverter->lab_certified)
                                            <span class="badge rounded-pill bg-success py-2 px-4" style="font-size: 0.9rem;"><i class="fa fa-check me-1"></i>دارد</span>
                                        @else
                                            <span class="badge rounded-pill bg-warning text-dark py-2 px-4" style="font-size: 0.9rem;"><i class="fa fa-exclamation me-1"></i>ندارد</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 rounded-3" style="background: {{ $inverter->union_approved ? '#E8F5E9' : '#FFF3E0' }};">
                                    <div class="text-muted small mb-1 fw-medium">تایید اتحادیه</div>
                                    <div class="mt-2">
                                        @if($inverter->union_approved)
                                            <span class="badge rounded-pill bg-success py-2 px-4" style="font-size: 0.9rem;"><i class="fa fa-check-double me-1"></i>تایید شده</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary py-2 px-4" style="font-size: 0.9rem;">تایید نشده</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 p-3 rounded-3 bg-light bg-opacity-50">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-muted fw-medium">نام آزمایشگاه</div>
                                <div class="col-md-8 fw-bold">{{ $inverter->lab_name ?? '<span class="text-muted fw-normal">-</span>' }}</div>
                            </div>
                        </div>
                        <div class="p-4 rounded-3 border-2" style="border-style: dashed; border-color: #FFCC80; background: #FFF8E1;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 p-3 me-3" style="background: #FFE0B2;">
                                        <i class="fa fa-file-pdf-o fa-2x" style="color: #E64A19;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">فایل دیتاشیت</div>
                                        <small class="text-muted">PDF راهنمای محصول</small>
                                    </div>
                                </div>
                                @if($inverter->datasheet_path)
                                    <a href="{{ asset('storage/' . $inverter->datasheet_path) }}" target="_blank" class="btn rounded-pill px-4 fw-bold shadow-sm" style="background: linear-gradient(135deg, #EF5350 0%, #E53935 100%); color: white;">
                                        <i class="fa fa-download ms-2"></i> دانلود PDF
                                    </a>
                                @else
                                    <span class="badge rounded-pill bg-secondary py-2 px-4">فایل موجود نیست</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(method_exists($inverter, 'projects') && $inverter->projects && $inverter->projects->count() > 0)
            <div class="card rounded-4 border-0 shadow mb-4 overflow-hidden">
                <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #FF8A65 0%, #F4511E 100%);">
                    <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                        <i class="fa fa-project-diagram me-2"></i>پروژه‌های استفاده کننده
                        <span class="badge rounded-pill bg-white bg-opacity-25 ms-2 py-1 px-3">{{ $inverter->projects->count() }} پروژه</span>
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover rounded-3 overflow-hidden mb-0">
                            <thead style="background: #FFF3E0;">
                                <tr>
                                    <th class="text-center py-3 px-3 border-0 fw-bold" style="color: #E65100;">#</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">نام پروژه</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">مشتری</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">ظرفیت</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">تاریخ نصب</th>
                                    <th class="text-center py-3 px-3 border-0 fw-bold" style="color: #E65100;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inverter->projects as $project)
                                    <tr class="align-middle">
                                        <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $project->name ?? 'نامشخص' }}</td>
                                        <td>{{ $project->customer ?? '-' }}</td>
                                        <td class="fw-bold" style="color: #1565C0;">{{ $project->capacity ?? '-' }} kW</td>
                                        <td class="text-muted">{{ $project->installation_date ? jdate($project->installation_date)->format('Y/m/d') : '-' }}</td>
                                        <td class="text-center">
                                            @if(isset($project->id) && method_exists($project, 'getShowUrl'))
                                                <a href="{{ $project->getShowUrl() }}" class="btn btn-sm rounded-pill btn-info px-3">
                                                    <i class="fa fa-eye me-1"></i>مشاهده
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-xl-12">
                <div class="card rounded-4 border-0 shadow overflow-hidden">
                    <div class="card-header py-3 px-4 border-0" style="background: linear-gradient(135deg, #90A4AE 0%, #607D8B 100%);">
                        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                            <i class="fa fa-sticky-note me-2"></i>توضیحات و اطلاعات سیستم
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label fw-medium text-muted mb-2"><i class="fa fa-align-right me-2"></i>توضیحات</label>
                                <div class="p-4 rounded-3 bg-light bg-opacity-75 min-h-100">
                                    {{ $inverter->notes ? nl2br(e($inverter->notes)) : '<span class="text-muted fst-italic">توضیحاتی ثبت نشده است.</span>' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="h-100 p-4 rounded-3" style="background: #ECEFF1;">
                                    <div class="mb-4 pb-3 border-bottom">
                                        <div class="text-muted small fw-medium mb-1"><i class="fa fa-calendar-plus me-1"></i>تاریخ ثبت</div>
                                        <div class="fw-bold fs-5" style="color: #455A64;">
                                            {{ jdate($inverter->created_at)->format('Y/m/d') }}
                                            <small class="text-muted fw-normal d-block mt-1">{{ jdate($inverter->created_at)->format('H:i:s') }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-medium mb-1"><i class="fa fa-calendar-edit me-1"></i>آخرین ویرایش</div>
                                        <div class="fw-bold fs-5" style="color: #455A64;">
                                            {{ jdate($inverter->updated_at)->format('Y/m/d') }}
                                            <small class="text-muted fw-normal d-block mt-1">{{ jdate($inverter->updated_at)->format('H:i:s') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
