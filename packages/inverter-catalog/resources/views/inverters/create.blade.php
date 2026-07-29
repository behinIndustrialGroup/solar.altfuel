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
                <h5 class="mb-0">افزودن اینورتر جدید</h5>
                <button type="button" class="btn btn-warning" id="fillLastRecord">
                    <i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد
                </button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('inverter-catalog.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- اطلاعات پایه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات پایه</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">برند <span class="text-danger">*</span></label>
                                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required placeholder="مثال: Longi, Trina">
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
                            <div class="col-md-3">
                                <label class="form-label">کد مدل <span class="text-danger">*</span></label>
                                <input type="text" name="model_code" class="form-control" value="{{ old('model_code') }}" required>
                                @error('model_code') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نوع اینورتر <span class="text-danger">*</span></label>
                                <select name="inverter_type" class="form-control" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($inverterTypes as $type)
                                        <option value="{{ $type }}" {{ old('inverter_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('inverter_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات توان --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات توان</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">توان نامی (kW) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="rated_power_kw" class="form-control" value="{{ old('rated_power_kw') }}" required>
                                @error('rated_power_kw') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تعداد MPPT <span class="text-danger">*</span></label>
                                <input type="number" name="mppt_count" class="form-control" value="{{ old('mppt_count') }}" required min="1">
                                @error('mppt_count') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تعداد ورودی هر MPPT <span class="text-danger">*</span></label>
                                <input type="number" name="strings_per_mppt" class="form-control" value="{{ old('strings_per_mppt') }}" required min="1">
                                @error('strings_per_mppt') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات الکتریکی - ورودی --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات الکتریکی - ورودی DC</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">حداکثر ولتاژ ورودی DC (V) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_dc_input_voltage" class="form-control" value="{{ old('max_dc_input_voltage') }}" required>
                                @error('max_dc_input_voltage') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">حداکثر جریان ورودی (A) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_input_current" class="form-control" value="{{ old('max_input_current') }}" required>
                                @error('max_input_current') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">محدوده ولتاژ MPP <span class="text-danger">*</span></label>
                                <input type="text" name="mpp_voltage_range" class="form-control" value="{{ old('mpp_voltage_range') }}" required placeholder="مثال: 200-850V">
                                @error('mpp_voltage_range') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">حداکثر توان ورودی PV (kW) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_pv_input_power" class="form-control" value="{{ old('max_pv_input_power') }}" required>
                                <small class="text-muted">برای چک کردن توسط بازرس</small>
                                @error('max_pv_input_power') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات الکتریکی - خروجی --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات الکتریکی - خروجی AC</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">حداکثر جریان خروجی (A) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_output_current" class="form-control" value="{{ old('max_output_current') }}" required>
                                @error('max_output_current') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ولتاژ خروجی AC (V) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="output_voltage" class="form-control" value="{{ old('output_voltage') }}" required placeholder="مثال: 220, 380">
                                @error('output_voltage') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">فرکانس خروجی (Hz) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="output_frequency" class="form-control" value="{{ old('output_frequency', 50) }}" required>
                                @error('output_frequency') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- عملکرد و راندمان --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">عملکرد و راندمان</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">حداکثر راندمان (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_efficiency" class="form-control" value="{{ old('max_efficiency') }}" required min="0" max="100">
                                @error('max_efficiency') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">THD (Total Harmonic Distortion)</label>
                                <input type="number" step="0.01" name="thd" class="form-control" value="{{ old('thd') }}">
                                @error('thd') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- حفاظت و ویژگی‌ها --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">حفاظت و ویژگی‌ها</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">درجه حفاظت <span class="text-danger">*</span></label>
                                <select name="protection_level" class="form-control" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="IP65" {{ old('protection_level') == 'IP65' ? 'selected' : '' }}>IP65</option>
                                    <option value="IP66" {{ old('protection_level') == 'IP66' ? 'selected' : '' }}>IP66</option>
                                </select>
                                @error('protection_level') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">روش خنک سازی</label>
                                <select name="cooling_type" class="form-control">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($coolingTypes as $cooling)
                                        <option value="{{ $cooling }}" {{ old('cooling_type') == $cooling ? 'selected' : '' }}>{{ $cooling }}</option>
                                    @endforeach
                                </select>
                                @error('cooling_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">کلید DC</label>
                                <select name="dc_switch" class="form-control">
                                    <option value="0" {{ old('dc_switch') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('dc_switch') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('dc_switch') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">کلید AC</label>
                                <select name="ac_switch" class="form-control">
                                    <option value="0" {{ old('ac_switch') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('ac_switch') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('ac_switch') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">صفحه نمایشگر</label>
                                <select name="display" class="form-control">
                                    <option value="0" {{ old('display') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('display') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('display') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label">حفاظت پلاریته معکوس</label>
                                <select name="reverse_polarity_protection" class="form-control">
                                    <option value="0" {{ old('reverse_polarity_protection') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('reverse_polarity_protection') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('reverse_polarity_protection') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">حفاظت ضد جزیره‌ای</label>
                                <select name="anti_islanding_protection" class="form-control">
                                    <option value="0" {{ old('anti_islanding_protection') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('anti_islanding_protection') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('anti_islanding_protection') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">حفاظت جریان نشتی</label>
                                <select name="leakage_current_protection" class="form-control">
                                    <option value="0" {{ old('leakage_current_protection') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('leakage_current_protection') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('leakage_current_protection') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نوع SPD</label>
                                <select name="spd_type" class="form-control">
                                    <option value="0" {{ old('spd_type') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('spd_type') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('spd_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- ارتباطات --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">پروتکل‌های ارتباطی</legend>
                        <div class="row g-3">
                            <div class="col-md-12">
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

                    <div class="text-center my-3">
                        <button type="button" class="btn btn-info btn-lg" onclick="document.getElementById('part2').scrollIntoView({behavior: 'smooth'});">
                            <i class="fa fa-arrow-down ms-1"></i> ادامه فرم (گارانتی و استانداردها)
                        </button>
                    </div>

                    <hr id="part2" class="my-4">


                    {{-- گارانتی و استانداردها --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">گارانتی و استانداردها</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">مدت گارانتی <span class="text-danger">*</span></label>
                                <input type="text" name="warranty_period" class="form-control" value="{{ old('warranty_period') }}" required placeholder="مثال: 10 سال">
                                @error('warranty_period') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8">
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

                    {{-- تاییدیه آزمایشگاه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">تاییدیه آزمایشگاه</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">تاییدیه آزمایشگاه دارد؟</label>
                                <select name="lab_certified" class="form-control" id="lab_certified">
                                    <option value="0" {{ old('lab_certified') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('lab_certified') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('lab_certified') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4" id="lab_name_container" style="display: none;">
                                <label class="form-label">نام آزمایشگاه</label>
                                <select name="lab_name" class="form-control select2" id="lab_name">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab }}" {{ old('lab_name') == $lab ? 'selected' : '' }}>{{ $lab }}</option>
                                    @endforeach
                                </select>
                                @error('lab_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle ms-1"></i>
                                    <strong>توجه:</strong> در صورتی که اینورتر تاییدیه آزمایشگاه داشته باشد و دیتاشیت نیز بارگذاری شود، به صورت خودکار وضعیت "تایید اتحادیه" فعال می‌شود.
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-4 text-end">
                        <a href="{{ route('inverter-catalog.index') }}" class="btn btn-secondary ms-2">بازگشت</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save ms-1"></i> ثبت اینورتر
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
            toggleLabName(); // اجرای اولیه

            // دکمه پر کردن با آخرین رکورد
            $('#fillLastRecord').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> در حال دریافت...');

                $.ajax({
                    url: '{{ route("inverter-catalog.last-record") }}',
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            // فیلدهای متنی
                            var textFields = [
                                'brand', 'manufacture', 'country_of_manufacture', 'model_name', 'model_code',
                                'mpp_voltage_range', 'warranty_period', 'notes'
                            ];
                            textFields.forEach(function(field) {
                                if (data[field]) {
                                    $('input[name="' + field + '"], textarea[name="' + field + '"]').val(data[field]);
                                }
                            });

                            // فیلدهای عددی
                            var numFields = [
                                'rated_power_kw', 'mppt_count', 'strings_per_mppt',
                                'max_dc_input_voltage', 'max_input_current', 'max_pv_input_power',
                                'max_output_current', 'output_voltage', 'output_frequency',
                                'max_efficiency', 'thd'
                            ];
                            numFields.forEach(function(field) {
                                if (data[field] !== null && data[field] !== undefined) {
                                    $('input[name="' + field + '"]').val(data[field]);
                                }
                            });

                            // select fields
                            if (data.inverter_type) {
                                $('select[name="inverter_type"]').val(data.inverter_type);
                            }
                            if (data.protection_level) {
                                $('select[name="protection_level"]').val(data.protection_level);
                            }
                            if (data.cooling_type) {
                                $('select[name="cooling_type"]').val(data.cooling_type);
                            }

                            // Boolean fields
                            var boolFields = [
                                'dc_switch', 'ac_switch', 'reverse_polarity_protection', 'display',
                                'anti_islanding_protection', 'leakage_current_protection', 'spd_type', 'lab_certified'
                            ];
                            boolFields.forEach(function(field) {
                                if (data[field] !== undefined) {
                                    $('select[name="' + field + '"]').val(data[field] ? '1' : '0');
                                }
                            });

                            // Lab name
                            if (data.lab_name) {
                                $('select[name="lab_name"]').val(data.lab_name).trigger('change');
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
