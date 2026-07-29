@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">ویرایش پیمانکار: {{ $contractor->company_name }}</h5>
                <a href="{{ route('contractor-catalog.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-right ms-1"></i> بازگشت
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('contractor-catalog.update', $contractor) }}">
                    @csrf
                    @method('PUT')

                    {{-- اطلاعات شرکت --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات شرکت</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">نام شرکت <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $contractor->company_name) }}" required>
                                @error('company_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">شناسه ملی شرکت <span class="text-danger">*</span></label>
                                <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $contractor->national_id) }}" required maxlength="11">
                                @error('national_id') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تلفن شرکت</label>
                                <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $contractor->company_phone) }}" maxlength="11">
                                @error('company_phone') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- اطلاعات مدیر عامل --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات مدیر عامل</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">نام مدیر عامل <span class="text-danger">*</span></label>
                                <input type="text" name="ceo_name" class="form-control" value="{{ old('ceo_name', $contractor->ceo_name) }}" required>
                                @error('ceo_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">کد ملی مدیر عامل <span class="text-danger">*</span></label>
                                <input type="text" name="ceo_national_code" class="form-control" value="{{ old('ceo_national_code', $contractor->ceo_national_code) }}" required maxlength="10">
                                @error('ceo_national_code') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تلفن همراه مدیر عامل <span class="text-danger">*</span></label>
                                <input type="text" name="ceo_mobile" class="form-control" value="{{ old('ceo_mobile', $contractor->ceo_mobile) }}" required maxlength="11">
                                @error('ceo_mobile') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- شخص رابط --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات شخص رابط</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">نام شخص رابط <span class="text-danger">*</span></label>
                                <input type="text" name="contact_person_name" class="form-control" value="{{ old('contact_person_name', $contractor->contact_person_name) }}" required>
                                @error('contact_person_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">شماره همراه شخص رابط <span class="text-danger">*</span></label>
                                <input type="text" name="contact_person_mobile" class="form-control" value="{{ old('contact_person_mobile', $contractor->contact_person_mobile) }}" required maxlength="11">
                                @error('contact_person_mobile') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- آدرس --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">آدرس</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">استان <span class="text-danger">*</span></label>
                                <select name="province" class="form-control select2" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province }}" {{ old('province', $contractor->province) == $province ? 'selected' : '' }}>{{ $province }}</option>
                                    @endforeach
                                </select>
                                @error('province') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">شهر <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $contractor->city) }}" required>
                                @error('city') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">آدرس کامل <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address', $contractor->address) }}</textarea>
                                @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- پروانه کسب --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">پروانه کسب</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">شماره پروانه کسب <span class="text-danger">*</span></label>
                                <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $contractor->license_number) }}" required>
                                @error('license_number') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تاریخ صدور پروانه <span class="text-danger">*</span></label>
                                <input type="text" name="license_issue_date" class="form-control persian-date" value="{{ old('license_issue_date', $contractor->license_issue_date ? toJalaliFormatted($contractor->license_issue_date) : '') }}" required>
                                @error('license_issue_date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تاریخ انقضای پروانه <span class="text-danger">*</span></label>
                                <input type="text" name="license_expiry_date" class="form-control persian-date" value="{{ old('license_expiry_date', $contractor->license_expiry_date ? toJalaliFormatted($contractor->license_expiry_date) : '') }}" required>
                                @error('license_expiry_date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- آمار --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">آمار پروژه‌ها</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">تعداد پروژه‌های ثبت شده</label>
                                <input type="number" name="registered_projects_count" class="form-control" value="{{ old('registered_projects_count', $contractor->registered_projects_count) }}" min="0">
                                @error('registered_projects_count') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-4 text-end">
                        <a href="{{ route('contractor-catalog.index') }}" class="btn btn-secondary ms-2">بازگشت</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save ms-1"></i> ذخیره تغییرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
