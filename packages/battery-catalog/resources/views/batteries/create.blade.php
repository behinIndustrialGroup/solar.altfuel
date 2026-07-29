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
                <h5 class="mb-0">افزودن باتری جدید</h5>
                <button type="button" class="btn btn-warning" id="fillLastRecord">
                    <i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد
                </button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('battery-catalog.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- اطلاعات پایه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات پایه</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">برند <span class="text-danger">*</span></label>
                                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required>
                                @error('brand') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نام شرکت سازنده <span class="text-danger">*</span></label>
                                <input type="text" name="manufacture" class="form-control" value="{{ old('manufacture') }}" required>
                                @error('manufacture') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">کشور تولید <span class="text-danger">*</span></label>
                                <input type="text" name="country_of_manufacture" class="form-control" value="{{ old('country_of_manufacture') }}" required>
                                @error('country_of_manufacture') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نام مدل <span class="text-danger">*</span></label>
                                <input type="text" name="model_name" class="form-control" value="{{ old('model_name') }}" required>
                                @error('model_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">کد مدل <span class="text-danger">*</span></label>
                                <input type="text" name="model_code" class="form-control" value="{{ old('model_code') }}" required>
                                @error('model_code') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">نوع باتری <span class="text-danger">*</span></label>
                                <select name="battery_type" class="form-control select2" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($batteryTypes as $type)
                                        <option value="{{ $type }}" {{ old('battery_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('battery_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- ظرفیت و ولتاژ --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">ظرفیت و ولتاژ</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">ظرفیت انرژی (kWh) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="energy_capacity_kwh" class="form-control" value="{{ old('energy_capacity_kwh') }}" required>
                                @error('energy_capacity_kwh') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ظرفیت (Ah) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="capacity_ah" class="form-control" value="{{ old('capacity_ah') }}" required>
                                @error('capacity_ah') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ولتاژ نامی (V) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="nominal_voltage" class="form-control" value="{{ old('nominal_voltage') }}" required>
                                @error('nominal_voltage') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- شارژ و دشارژ --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">شارژ و دشارژ</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">حداکثر جریان شارژ (A) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_charge_current" class="form-control" value="{{ old('max_charge_current') }}" required>
                                @error('max_charge_current') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">حداکثر جریان دشارژ (A) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_discharge_current" class="form-control" value="{{ old('max_discharge_current') }}" required>
                                @error('max_discharge_current') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- عملکرد --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">عملکرد</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">تعداد سیکل عمر <span class="text-danger">*</span></label>
                                <input type="number" name="cycle_life" class="form-control" value="{{ old('cycle_life') }}" required min="0">
                                @error('cycle_life') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">عمق دشارژ DOD (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="depth_of_discharge" class="form-control" value="{{ old('depth_of_discharge') }}" required min="0" max="100">
                                @error('depth_of_discharge') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- قابلیت توسعه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">قابلیت توسعه</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">قابلیت توسعه</label>
                                <select name="expandable" class="form-control" id="expandable">
                                    <option value="0" {{ old('expandable') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('expandable') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('expandable') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4" id="max_parallel_container" style="display: none;">
                                <label class="form-label">حداکثر تعداد باتری قابل اتصال</label>
                                <input type="number" name="max_parallel_units" class="form-control" value="{{ old('max_parallel_units') }}" min="1">
                                @error('max_parallel_units') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- حفاظت و ارتباطات --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">حفاظت و ارتباطات</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">درجه حفاظت IP <span class="text-danger">*</span></label>
                                <select name="ip_rating" class="form-control" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($ipRatings as $rating)
                                        <option value="{{ $rating }}" {{ old('ip_rating') == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                                    @endforeach
                                </select>
                                @error('ip_rating') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">پروتکل‌های ارتباطی (چند انتخابی)</label>
                                <select name="communication_protocols[]" class="form-control select2" multiple>
                                    @foreach($communicationProtocols as $protocol)
                                        <option value="{{ $protocol }}" {{ in_array($protocol, old('communication_protocols', [])) ? 'selected' : '' }}>{{ $protocol }}</option>
                                    @endforeach
                                </select>
                                @error('communication_protocols') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات فیزیکی --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات فیزیکی</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">ابعاد <span class="text-danger">*</span></label>
                                <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions') }}" required placeholder="مثال: 600x400x200 mm">
                                @error('dimensions') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">وزن (kg) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}" required>
                                @error('weight') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="text-center my-3">
                        <button type="button" class="btn btn-info btn-lg" onclick="document.getElementById('part2').scrollIntoView({behavior: 'smooth'});">
                            <i class="fa fa-arrow-down ms-1"></i> ادامه فرم (گارانتی و تاییدیه‌ها)
                        </button>
                    </div>

                    <hr id="part2" class="my-4">


                    {{-- گارانتی و استانداردها --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">گارانتی و استانداردها</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">مدت گارانتی (سال) <span class="text-danger">*</span></label>
                                <input type="number" name="warranty_years" class="form-control" value="{{ old('warranty_years') }}" required min="0">
                                @error('warranty_years') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">استانداردها (چند انتخابی)</label>
                                <div class="row">
                                    @foreach($standards as $standard)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="standards[]" value="{{ $standard }}" id="standard_{{ $loop->index }}" {{ in_array($standard, old('standards', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="standard_{{ $loop->index }}">
                                                    {{ $standard }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('standards') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- دیتاشیت و توضیحات --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">دیتاشیت و توضیحات</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">فایل دیتاشیت (PDF) <span class="text-danger">*</span></label>
                                <input type="file" name="datasheet_path" class="form-control" accept=".pdf" required>
                                <small class="text-muted">فایل PDF اجباری است</small>
                                @error('datasheet_path') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">توضیحات</label>
                                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                                @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- تاییدیه آزمایشگاه و اتحادیه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">تاییدیه آزمایشگاه و اتحادیه</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">تاییدیه آزمایشگاه دارد؟</label>
                                <select name="lab_certified" class="form-control" id="lab_certified">
                                    <option value="0" {{ old('lab_certified') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('lab_certified') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('lab_certified') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3" id="lab_name_container" style="display: none;">
                                <label class="form-label">نام آزمایشگاه</label>
                                <select name="lab_name" class="form-control select2" id="lab_name">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab }}" {{ old('lab_name') == $lab ? 'selected' : '' }}>{{ $lab }}</option>
                                    @endforeach
                                </select>
                                @error('lab_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">مورد تایید اتحادیه</label>
                                <select name="union_approved" class="form-control" id="union_approved">
                                    <option value="0" {{ old('union_approved') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('union_approved') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                <small class="text-muted">خودکار محاسبه می‌شود</small>
                                @error('union_approved') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تاریخ تایید اتحادیه</label>
                                <input type="text" name="union_approval_date" class="form-control persian-date" value="{{ old('union_approval_date') }}">
                                @error('union_approval_date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle ms-1"></i>
                                    <strong>توجه:</strong> در صورتی که باتری تاییدیه آزمایشگاه داشته باشد، نام آزمایشگاه مشخص شود و دیتاشیت بارگذاری شود، به صورت خودکار وضعیت "تایید اتحادیه" فعال می‌شود.
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-4 text-end">
                        <a href="{{ route('battery-catalog.index') }}" class="btn btn-secondary ms-2">بازگشت</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save ms-1"></i> ثبت باتری
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
            // نمایش/مخفی کردن فیلد نام آزمایشگاه
            function toggleLabName() {
                if ($('#lab_certified').val() === '1') {
                    $('#lab_name_container').show();
                } else {
                    $('#lab_name_container').hide();
                    $('#lab_name').val('').trigger('change');
                }
            }

            $('#lab_certified').on('change', toggleLabName);
            toggleLabName();

            // نمایش/مخفی کردن حداکثر تعداد باتری قابل اتصال
            function toggleMaxParallel() {
                if ($('#expandable').val() === '1') {
                    $('#max_parallel_container').show();
                } else {
                    $('#max_parallel_container').hide();
                    $('input[name="max_parallel_units"]').val('');
                }
            }

            $('#expandable').on('change', toggleMaxParallel);
            toggleMaxParallel();

            // محاسبه خودکار تایید اتحادیه
            function checkUnionApproval() {
                var labCertified = $('#lab_certified').val() === '1';
                var labName = $('#lab_name').val();
                
                if (labCertified && labName) {
                    $('#union_approved').val('1');
                } else {
                    $('#union_approved').val('0');
                }
            }

            $('#lab_certified, #lab_name').on('change', checkUnionApproval);

            // دکمه پر کردن با آخرین رکورد
            $('#fillLastRecord').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> در حال دریافت...');

                $.ajax({
                    url: '{{ route("battery-catalog.last-record") }}',
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            // فیلدهای متنی
                            var textFields = [
                                'brand', 'manufacture', 'country_of_manufacture', 'model_name', 'model_code',
                                'dimensions', 'notes'
                            ];
                            textFields.forEach(function(field) {
                                if (data[field]) {
                                    $('input[name="' + field + '"], textarea[name="' + field + '"]').val(data[field]);
                                }
                            });

                            // فیلدهای عددی
                            var numFields = [
                                'energy_capacity_kwh', 'capacity_ah', 'nominal_voltage',
                                'max_charge_current', 'max_discharge_current', 'cycle_life',
                                'depth_of_discharge', 'max_parallel_units', 'weight', 'warranty_years'
                            ];
                            numFields.forEach(function(field) {
                                if (data[field] !== null && data[field] !== undefined) {
                                    $('input[name="' + field + '"]').val(data[field]);
                                }
                            });

                            // select fields
                            if (data.battery_type) {
                                $('select[name="battery_type"]').val(data.battery_type).trigger('change');
                            }
                            if (data.ip_rating) {
                                $('select[name="ip_rating"]').val(data.ip_rating);
                            }

                            // Boolean fields
                            if (data.expandable !== undefined) {
                                $('#expandable').val(data.expandable ? '1' : '0');
                            }
                            if (data.lab_certified !== undefined) {
                                $('#lab_certified').val(data.lab_certified ? '1' : '0');
                            }
                            if (data.union_approved !== undefined) {
                                $('#union_approved').val(data.union_approved ? '1' : '0');
                            }

                            // Lab name
                            if (data.lab_name) {
                                $('#lab_name').val(data.lab_name).trigger('change');
                            }

                            // Date
                            if (data.union_approval_date) {
                                $('input[name="union_approval_date"]').val(data.union_approval_date);
                            }

                            // Communication protocols (multi-select)
                            if (data.communication_protocols && Array.isArray(data.communication_protocols)) {
                                $('select[name="communication_protocols[]"]').val(data.communication_protocols).trigger('change');
                            }

                            // Standards (checkboxes)
                            if (data.standards && Array.isArray(data.standards)) {
                                $('input[name="standards[]"]').prop('checked', false);
                                data.standards.forEach(function(standard) {
                                    $('input[name="standards[]"][value="' + standard + '"]').prop('checked', true);
                                });
                            }

                            toggleLabName();
                            toggleMaxParallel();
                            
                            if (typeof toastr !== 'undefined') {
                                toastr.success('فیلدها با آخرین رکورد پر شدند');
                            } else {
                                alert('فیلدها با آخرین رکورد پر شدند');
                            }
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.info('رکوردی یافت نشد');
                            } else {
                                alert('رکوردی یافت نشد');
                            }
                        }
                    },
                    error: function() {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('خطا در دریافت اطلاعات');
                        } else {
                            alert('خطا در دریافت اطلاعات');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد');
                    }
                });
            });
        });
    </script>
@endsection
