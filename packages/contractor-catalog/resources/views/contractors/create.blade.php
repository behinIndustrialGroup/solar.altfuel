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
                <h5 class="mb-0">افزودن پیمانکار جدید</h5>
                <button type="button" class="btn btn-warning" id="fillLastRecord">
                    <i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد
                </button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('contractor-catalog.store') }}">
                    @csrf

                    {{-- اطلاعات شرکت --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات شرکت</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">نام شرکت <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
                                @error('company_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">شناسه ملی شرکت <span class="text-danger">*</span></label>
                                <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}" required maxlength="11" placeholder="۱۱ رقم">
                                @error('national_id') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تلفن شرکت</label>
                                <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone') }}" maxlength="11" placeholder="مثال: ۰۲۱XXXXXXX">
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
                                <input type="text" name="ceo_name" class="form-control" value="{{ old('ceo_name') }}" required>
                                @error('ceo_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">کد ملی مدیر عامل <span class="text-danger">*</span></label>
                                <input type="text" name="ceo_national_code" class="form-control" value="{{ old('ceo_national_code') }}" required maxlength="10" placeholder="۱۰ رقم">
                                @error('ceo_national_code') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تلفن همراه مدیر عامل <span class="text-danger">*</span></label>
                                <input type="text" name="ceo_mobile" class="form-control" value="{{ old('ceo_mobile') }}" required maxlength="11" placeholder="۰۹XXXXXXXXX">
                                @error('ceo_mobile') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- اطلاعات شخص رابط --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات شخص رابط</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">نام شخص رابط <span class="text-danger">*</span></label>
                                <input type="text" name="contact_person_name" class="form-control" value="{{ old('contact_person_name') }}" required>
                                @error('contact_person_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">شماره همراه شخص رابط <span class="text-danger">*</span></label>
                                <input type="text" name="contact_person_mobile" class="form-control" value="{{ old('contact_person_mobile') }}" required maxlength="11" placeholder="۰۹XXXXXXXXX">
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
                                <select name="province" class="form-control select2" required id="province_select">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province }}" {{ old('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                                    @endforeach
                                </select>
                                @error('province') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">شهر <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                                @error('city') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">آدرس کامل <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
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
                                <input type="text" name="license_number" class="form-control" value="{{ old('license_number') }}" required>
                                @error('license_number') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تاریخ صدور پروانه <span class="text-danger">*</span></label>
                                <input type="text" name="license_issue_date" class="form-control persian-date" value="{{ old('license_issue_date') }}" required placeholder="مثال: 1400/01/01">
                                @error('license_issue_date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تاریخ انقضای پروانه <span class="text-danger">*</span></label>
                                <input type="text" name="license_expiry_date" class="form-control persian-date" value="{{ old('license_expiry_date') }}" required placeholder="مثال: 1405/01/01">
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
                                <input type="number" name="registered_projects_count" class="form-control" value="{{ old('registered_projects_count', 0) }}" min="0">
                                @error('registered_projects_count') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-4 text-end">
                        <a href="{{ route('contractor-catalog.index') }}" class="btn btn-secondary ms-2">بازگشت</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save ms-1"></i> ثبت پیمانکار
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#fillLastRecord').on('click', function() {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> در حال دریافت...');

            $.ajax({
                url: '{{ route("contractor-catalog.last-record") }}',
                method: 'GET',
                success: function(data) {
                    if (data) {
                        var textFields = [
                            'company_name', 'ceo_name', 'contact_person_name',
                            'city', 'address', 'company_phone'
                        ];
                        textFields.forEach(function(field) {
                            if (data[field]) {
                                $('[name="' + field + '"]').val(data[field]);
                            }
                        });

                        if (data.province) {
                            $('select[name="province"]').val(data.province).trigger('change');
                        }

                        if (typeof toastr !== 'undefined') {
                            toastr.success('فیلدها با آخرین رکورد پر شدند');
                        }
                    } else {
                        if (typeof toastr !== 'undefined') toastr.info('رکوردی یافت نشد');
                    }
                },
                error: function() {
                    if (typeof toastr !== 'undefined') toastr.error('خطا در دریافت اطلاعات');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد');
                }
            });
        });
    });
</script>
@endsection
