@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">جزئیات باتری</h5>
                <div>
                    <a href="{{ route('battery-catalog.edit', $battery) }}" class="btn btn-warning">
                        <i class="fa fa-edit ms-1"></i> ویرایش
                    </a>
                    <a href="{{ route('battery-catalog.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-right ms-1"></i> بازگشت
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- اطلاعات پایه --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات پایه</legend>
                    <div class="row g-3">
                        <div class="col-md-3"><strong>برند:</strong> {{ $battery->brand }}</div>
                        <div class="col-md-3"><strong>سازنده:</strong> {{ $battery->manufacture }}</div>
                        <div class="col-md-3"><strong>کشور:</strong> {{ $battery->country_of_manufacture }}</div>
                        <div class="col-md-3"><strong>نام مدل:</strong> {{ $battery->model_name }}</div>
                        <div class="col-md-3"><strong>کد مدل:</strong> {{ $battery->model_code }}</div>
                        <div class="col-md-3"><strong>نوع:</strong> <span class="badge badge-info">{{ $battery->battery_type }}</span></div>
                    </div>
                </fieldset>

                {{-- ظرفیت و ولتاژ --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">ظرفیت و ولتاژ</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>ظرفیت انرژی:</strong> {{ $battery->energy_capacity_kwh }} kWh</div>
                        <div class="col-md-4"><strong>ظرفیت:</strong> {{ $battery->capacity_ah }} Ah</div>
                        <div class="col-md-4"><strong>ولتاژ نامی:</strong> {{ $battery->nominal_voltage }} V</div>
                    </div>
                </fieldset>

                {{-- شارژ و دشارژ --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">شارژ و دشارژ</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>حداکثر جریان شارژ:</strong> {{ $battery->max_charge_current }} A</div>
                        <div class="col-md-4"><strong>حداکثر جریان دشارژ:</strong> {{ $battery->max_discharge_current }} A</div>
                    </div>
                </fieldset>

                {{-- عملکرد --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">عملکرد</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>سیکل عمر:</strong> {{ number_format($battery->cycle_life) }}</div>
                        <div class="col-md-4"><strong>عمق دشارژ DOD:</strong> {{ $battery->depth_of_discharge }}%</div>
                    </div>
                </fieldset>

                {{-- قابلیت توسعه --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">قابلیت توسعه</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>قابل توسعه:</strong> {!! $battery->expandable ? '<i class="fa fa-check text-success"></i> بله' : '<i class="fa fa-times text-danger"></i> خیر' !!}</div>
                        <div class="col-md-4"><strong>حداکثر تعداد موازی:</strong> {{ $battery->max_parallel_units ?? '-' }}</div>
                    </div>
                </fieldset>

                {{-- حفاظت و ارتباطات --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">حفاظت و ارتباطات</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>درجه حفاظت:</strong> {{ $battery->ip_rating }}</div>
                        <div class="col-md-12">
                            <strong>پروتکل‌های ارتباطی:</strong>
                            @if($battery->communication_protocols)
                                @foreach($battery->communication_protocols as $protocol)
                                    <span class="badge badge-primary me-1">{{ $protocol }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                {{-- مشخصات فیزیکی --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات فیزیکی</legend>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>ابعاد:</strong> {{ $battery->dimensions }}</div>
                        <div class="col-md-6"><strong>وزن:</strong> {{ $battery->weight }} kg</div>
                    </div>
                </fieldset>

                {{-- گارانتی و استانداردها --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">گارانتی و استانداردها</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>مدت گارانتی:</strong> {{ $battery->warranty_years }} سال</div>
                        <div class="col-md-12">
                            <strong>استانداردها:</strong><br>
                            @if($battery->standards)
                                @foreach($battery->standards as $standard)
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
                            @if($battery->datasheet_path)
                                <a href="{{ asset('storage/' . $battery->datasheet_path) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fa fa-file-pdf-o ms-1"></i> دانلود PDF
                                </a>
                            @else
                                <span class="text-muted">ندارد</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <strong>توضیحات:</strong><br>
                            {{ $battery->notes ?? '-' }}
                        </div>
                    </div>
                </fieldset>

                {{-- تاییدیه‌ها --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">تاییدیه‌ها</legend>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <strong>تاییدیه آزمایشگاه:</strong>
                            @if($battery->lab_certified)
                                <span class="badge badge-success">دارد</span>
                            @else
                                <span class="badge badge-danger">ندارد</span>
                            @endif
                        </div>
                        <div class="col-md-3"><strong>نام آزمایشگاه:</strong> {{ $battery->lab_name ?? '-' }}</div>
                        <div class="col-md-3">
                            <strong>تایید اتحادیه:</strong>
                            @if($battery->union_approved)
                                <span class="badge badge-success"><i class="fa fa-check ms-1"></i> تایید شده</span>
                            @else
                                <span class="badge badge-secondary">تایید نشده</span>
                            @endif
                        </div>
                        <div class="col-md-3"><strong>تاریخ تایید:</strong> {{ $battery->union_approval_date ? toJalaliFormatted($battery->union_approval_date, 'Y/m/d') : '-' }}</div>
                    </div>
                </fieldset>

                {{-- اطلاعات سیستم --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات سیستم</legend>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>تاریخ ثبت:</strong> {{ jdate($battery->created_at)->format('Y/m/d H:i') }}</div>
                        <div class="col-md-6"><strong>آخرین ویرایش:</strong> {{ jdate($battery->updated_at)->format('Y/m/d H:i') }}</div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection
