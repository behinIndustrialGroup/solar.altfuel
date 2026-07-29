@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">جزئیات پیمانکار</h5>
                <div>
                    <a href="{{ route('contractor-catalog.edit', $contractor) }}" class="btn btn-warning">
                        <i class="fa fa-edit ms-1"></i> ویرایش
                    </a>
                    <a href="{{ route('contractor-catalog.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-right ms-1"></i> بازگشت
                    </a>
                </div>
            </div>
            <div class="card-body">

                {{-- اطلاعات شرکت --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات شرکت</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>نام شرکت:</strong> {{ $contractor->company_name }}</div>
                        <div class="col-md-4"><strong>شناسه ملی:</strong> {{ $contractor->national_id }}</div>
                        <div class="col-md-4"><strong>تلفن شرکت:</strong> {{ $contractor->company_phone ?? '-' }}</div>
                    </div>
                </fieldset>

                {{-- اطلاعات مدیر عامل --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات مدیر عامل</legend>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>نام مدیر عامل:</strong> {{ $contractor->ceo_name }}</div>
                        <div class="col-md-4"><strong>کد ملی:</strong> {{ $contractor->ceo_national_code }}</div>
                        <div class="col-md-4"><strong>تلفن همراه:</strong> {{ $contractor->ceo_mobile }}</div>
                    </div>
                </fieldset>

                {{-- شخص رابط --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">شخص رابط</legend>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>نام:</strong> {{ $contractor->contact_person_name }}</div>
                        <div class="col-md-6"><strong>شماره همراه:</strong> {{ $contractor->contact_person_mobile }}</div>
                    </div>
                </fieldset>

                {{-- آدرس --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">آدرس</legend>
                    <div class="row g-3">
                        <div class="col-md-3"><strong>استان:</strong> {{ $contractor->province }}</div>
                        <div class="col-md-3"><strong>شهر:</strong> {{ $contractor->city }}</div>
                        <div class="col-md-12"><strong>آدرس کامل:</strong> {{ $contractor->address }}</div>
                    </div>
                </fieldset>

                {{-- پروانه کسب --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">پروانه کسب</legend>
                    <div class="row g-3">
                        <div class="col-md-3"><strong>شماره پروانه:</strong> {{ $contractor->license_number }}</div>
                        <div class="col-md-3"><strong>تاریخ صدور:</strong> {{ $contractor->license_issue_date ? toJalaliFormatted($contractor->license_issue_date, 'Y/m/d') : '-' }}</div>
                        <div class="col-md-3"><strong>تاریخ انقضا:</strong> {{ $contractor->license_expiry_date ? toJalaliFormatted($contractor->license_expiry_date, 'Y/m/d') : '-' }}</div>
                        <div class="col-md-3">
                            <strong>وضعیت:</strong>
                            @if($contractor->is_license_valid)
                                <span class="badge badge-success">معتبر</span>
                            @else
                                <span class="badge badge-danger">منقضی</span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                {{-- آمار --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">آمار پروژه‌ها</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>تعداد پروژه‌های ثبت شده:</strong>
                            <span class="badge badge-info">{{ $contractor->registered_projects_count }}</span>
                        </div>
                    </div>
                </fieldset>

                {{-- اطلاعات سیستم --}}
                <fieldset class="mb-4">
                    <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات سیستم</legend>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>تاریخ ثبت:</strong> {{ jdate($contractor->created_at)->format('Y/m/d H:i') }}</div>
                        <div class="col-md-6"><strong>آخرین ویرایش:</strong> {{ jdate($contractor->updated_at)->format('Y/m/d H:i') }}</div>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>
@endsection
