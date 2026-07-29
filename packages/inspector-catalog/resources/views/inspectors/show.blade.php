@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">جزئیات بازرس: {{ $inspector->full_name }}</h5>
                <div>
                    <a href="{{ route('inspector-catalog.edit', $inspector) }}" class="btn btn-warning">
                        <i class="fa fa-edit ms-1"></i> ویرایش
                    </a>
                    <a href="{{ route('inspector-catalog.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-right ms-1"></i> بازگشت
                    </a>
                </div>
            </div>
            <div class="card-body">

                {{-- اطلاعات حساب کاربری --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات حساب کاربری</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>نام نمایشی:</strong> {{ $inspector->user?->name ?? '-' }}</div>
                        <div class="col-md-4"><strong>ایمیل:</strong> {{ $inspector->user?->email ?? '-' }}</div>
                        <div class="col-md-4"><strong>شماره تلفن کاربری:</strong> {{ $inspector->user?->phone ?? '-' }}</div>
                    </div>
                </fieldset>

                {{-- اطلاعات هویتی --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات هویتی</legend>
                    <div class="row g-3">
                        <div class="col-md-3"><strong>کد بازرس:</strong> {{ $inspector->inspector_code }}</div>
                        <div class="col-md-3"><strong>نام:</strong> {{ $inspector->first_name }}</div>
                        <div class="col-md-3"><strong>نام خانوادگی:</strong> {{ $inspector->last_name }}</div>
                        <div class="col-md-3"><strong>کد ملی:</strong> {{ $inspector->national_id }}</div>
                    </div>
                </fieldset>

                {{-- اطلاعات تماس --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات تماس</legend>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>شماره همراه:</strong> {{ $inspector->mobile }}</div>
                        <div class="col-md-6"><strong>تلفن ثابت:</strong> {{ $inspector->phone ?? '-' }}</div>
                    </div>
                </fieldset>

                {{-- محل فعالیت --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">محل فعالیت</legend>
                    <div class="row g-3">
                        <div class="col-md-3"><strong>استان:</strong> {{ $inspector->province }}</div>
                        <div class="col-md-3"><strong>شهر:</strong> {{ $inspector->city }}</div>
                        <div class="col-md-12"><strong>آدرس:</strong> {{ $inspector->address }}</div>
                    </div>
                </fieldset>

                {{-- گواهی صلاحیت --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">گواهی صلاحیت حرفه‌ای</legend>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>دارای گواهی صلاحیت حرفه‌ای:</strong>
                            @if($inspector->is_certificated)
                                <span class="badge badge-success">بلی</span>
                            @else
                                <span class="badge badge-secondary">خیر</span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                {{-- اطلاعات سیستم --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات سیستم</legend>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>تاریخ ثبت:</strong> {{ jdate($inspector->created_at)->format('Y/m/d H:i') }}</div>
                        <div class="col-md-6"><strong>آخرین ویرایش:</strong> {{ jdate($inspector->updated_at)->format('Y/m/d H:i') }}</div>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>
@endsection
