@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">جزئیات اینورتر</h5>
                <div>
                    <a href="{{ route('inverter-catalog.edit', $inverter) }}" class="btn btn-warning">
                        <i class="fa fa-edit ms-1"></i> ویرایش
                    </a>
                    <a href="{{ route('inverter-catalog.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-right ms-1"></i> بازگشت
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- اطلاعات پایه --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات پایه</legend>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <strong>برند:</strong> {{ $inverter->brand }}
                        </div>
                        <div class="col-md-3">
                            <strong>سازنده:</strong> {{ $inverter->manufacture }}
                        </div>
                        <div class="col-md-3">
                            <strong>کشور:</strong> {{ $inverter->country_of_manufacture }}
                        </div>
                        <div class="col-md-3">
                            <strong>نام مدل:</strong> {{ $inverter->model_name }}
                        </div>
                        <div class="col-md-3">
                            <strong>کد مدل:</strong> {{ $inverter->model_code }}
                        </div>
                        <div class="col-md-3">
                            <strong>نوع:</strong> <span class="badge badge-info">{{ $inverter->inverter_type }}</span>
                        </div>
                    </div>
                </fieldset>

                {{-- مشخصات توان --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات توان</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>توان نامی:</strong> {{ $inverter->rated_power_kw }} kW
                        </div>
                        <div class="col-md-4">
                            <strong>تعداد MPPT:</strong> {{ $inverter->mppt_count }}
                        </div>
                        <div class="col-md-4">
                            <strong>ورودی/MPPT:</strong> {{ $inverter->strings_per_mppt }}
                        </div>
                    </div>
                </fieldset>

                {{-- مشخصات الکتریکی --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات الکتریکی</legend>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <strong>حداکثر ولتاژ DC:</strong> {{ $inverter->max_dc_input_voltage }} V
                        </div>
                        <div class="col-md-3">
                            <strong>حداکثر جریان ورودی:</strong> {{ $inverter->max_input_current }} A
                        </div>
                        <div class="col-md-3">
                            <strong>محدوده MPP:</strong> {{ $inverter->mpp_voltage_range }}
                        </div>
                        <div class="col-md-3">
                            <strong>حداکثر PV:</strong> {{ $inverter->max_pv_input_power }} kW
                        </div>
                        <div class="col-md-3">
                            <strong>حداکثر جریان خروجی:</strong> {{ $inverter->max_output_current }} A
                        </div>
                        <div class="col-md-3">
                            <strong>ولتاژ خروجی:</strong> {{ $inverter->output_voltage }} V
                        </div>
                        <div class="col-md-3">
                            <strong>فرکانس خروجی:</strong> {{ $inverter->output_frequency }} Hz
                        </div>
                    </div>
                </fieldset>

                {{-- عملکرد --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">عملکرد</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>حداکثر راندمان:</strong> {{ $inverter->max_efficiency }}%
                        </div>
                        <div class="col-md-4">
                            <strong>THD:</strong> {{ $inverter->thd ?? '-' }}
                        </div>
                    </div>
                </fieldset>

                {{-- حفاظت و ویژگی‌ها --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">حفاظت و ویژگی‌ها</legend>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <strong>درجه حفاظت:</strong> {{ $inverter->protection_level }}
                        </div>
                        <div class="col-md-3">
                            <strong>خنک سازی:</strong> {{ $inverter->cooling_type ?? '-' }}
                        </div>
                        <div class="col-md-2">
                            <strong>کلید DC:</strong> {!! $inverter->dc_switch ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                        <div class="col-md-2">
                            <strong>کلید AC:</strong> {!! $inverter->ac_switch ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                        <div class="col-md-2">
                            <strong>نمایشگر:</strong> {!! $inverter->display ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                        <div class="col-md-3">
                            <strong>حفاظت پلاریته:</strong> {!! $inverter->reverse_polarity_protection ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                        <div class="col-md-3">
                            <strong>ضد جزیره‌ای:</strong> {!! $inverter->anti_islanding_protection ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                        <div class="col-md-3">
                            <strong>حفاظت نشتی:</strong> {!! $inverter->leakage_current_protection ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                        <div class="col-md-3">
                            <strong>SPD:</strong> {!! $inverter->spd_type ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                        </div>
                    </div>
                </fieldset>

                {{-- ارتباطات --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">پروتکل‌های ارتباطی</legend>
                    <div class="row g-3">
                        <div class="col-md-12">
                            @if($inverter->communication_protocols)
                                @foreach($inverter->communication_protocols as $protocol)
                                    <span class="badge badge-primary me-1">{{ $protocol }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                {{-- گارانتی و استانداردها --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">گارانتی و استانداردها</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>مدت گارانتی:</strong> {{ $inverter->warranty_period }}
                        </div>
                        <div class="col-md-12">
                            <strong>استانداردها:</strong><br>
                            @if($inverter->standards)
                                @foreach($inverter->standards as $standard)
                                    <span class="badge badge-secondary me-1">{{ $standard }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                {{-- دیتاشیت --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">دیتاشیت و توضیحات</legend>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <strong>دیتاشیت:</strong>
                            @if($inverter->datasheet_path)
                                <a href="{{ asset('storage/' . $inverter->datasheet_path) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fa fa-file-pdf-o ms-1"></i> دانلود PDF
                                </a>
                            @else
                                <span class="text-muted">ندارد</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <strong>توضیحات:</strong><br>
                            {{ $inverter->notes ?? '-' }}
                        </div>
                    </div>
                </fieldset>

                {{-- تاییدیه آزمایشگاه --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">تاییدیه‌ها</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>تاییدیه آزمایشگاه:</strong>
                            @if($inverter->lab_certified)
                                <span class="badge badge-success">دارد</span>
                            @else
                                <span class="badge badge-danger">ندارد</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <strong>نام آزمایشگاه:</strong> {{ $inverter->lab_name ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>تایید اتحادیه:</strong>
                            @if($inverter->union_approved)
                                <span class="badge badge-success"><i class="fa fa-check ms-1"></i> تایید شده</span>
                            @else
                                <span class="badge badge-secondary">تایید نشده</span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                {{-- تاریخ ثبت --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات سیستم</legend>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>تاریخ ثبت:</strong> {{ jdate($inverter->created_at)->format('Y/m/d H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>آخرین ویرایش:</strong> {{ jdate($inverter->updated_at)->format('Y/m/d H:i') }}
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection
