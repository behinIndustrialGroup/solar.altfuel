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
                <h5 class="mb-0">افزودن پنل جدید</h5>
                <button type="button" class="btn btn-warning" id="fillLastRecord">
                    <i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد
                </button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('panel-catalog.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- اطلاعات پایه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">اطلاعات پایه</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">برند</label>
                                <select name="brand" class="form-control select2" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach(config('panel-catalog.brands') as $brand)
                                        <option value="{{ $brand }}" {{ old('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                                @error('brand') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نام شرکت سازنده</label>
                                <input type="text" name="manufacture" class="form-control" value="{{ old('manufacture') }}" required>
                                @error('manufacture') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">کشور تولید</label>
                                <input type="text" name="country_of_manufacture" class="form-control" value="{{ old('country_of_manufacture') }}" required>
                                @error('country_of_manufacture') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">مدل</label>
                                <input type="text" name="model" class="form-control" value="{{ old('model') }}" required placeholder="مثال: Hi-Mo X10">
                                @error('model') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">کد مدل</label>
                                <input type="text" name="model_code" class="form-control" value="{{ old('model_code') }}" required placeholder="مثال: LR7-72HGD-620M">
                                @error('model_code') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تکنولوژی</label>
                                <select name="technology" class="form-control select2" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach(config('panel-catalog.technologies') as $tech)
                                        <option value="{{ $tech }}" {{ old('technology') == $tech ? 'selected' : '' }}>{{ $tech }}</option>
                                    @endforeach
                                </select>
                                @error('technology') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نوع پنل</label>
                                <select name="panel_type" class="form-control" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="Monofacial" {{ old('panel_type') == 'Monofacial' ? 'selected' : '' }}>Monofacial</option>
                                    <option value="Bifacial" {{ old('panel_type') == 'Bifacial' ? 'selected' : '' }}>Bifacial</option>
                                </select>
                                @error('panel_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات الکتریکی --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات الکتریکی</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">توان نامی (Wp)</label>
                                <input type="number" step="0.01" name="rated_power_wp" class="form-control" value="{{ old('rated_power_wp') }}" required>
                                @error('rated_power_wp') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">راندمان ماژول (%)</label>
                                <input type="number" step="0.01" name="module_efficiency" class="form-control" value="{{ old('module_efficiency') }}" required>
                                @error('module_efficiency') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Voc (ولتاژ مدار باز)</label>
                                <input type="number" step="0.001" name="voc" class="form-control" value="{{ old('voc') }}" required>
                                @error('voc') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Isc (جریان اتصال کوتاه)</label>
                                <input type="number" step="0.001" name="isc" class="form-control" value="{{ old('isc') }}" required>
                                @error('isc') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Vmp (ولتاژ نقطه توان ماکزیمم)</label>
                                <input type="number" step="0.001" name="vmp" class="form-control" value="{{ old('vmp') }}" required>
                                @error('vmp') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Imp (جریان نقطه توان ماکزیمم)</label>
                                <input type="number" step="0.001" name="imp" class="form-control" value="{{ old('imp') }}" required>
                                @error('imp') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">حداکثر ولتاژ سیستم</label>
                                <input type="number" step="0.01" name="max_system_voltage" class="form-control" value="{{ old('max_system_voltage') }}" required>
                                @error('max_system_voltage') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ضریب دمایی توان</label>
                                <input type="number" step="0.0001" name="temperature_coefficient" class="form-control" value="{{ old('temperature_coefficient') }}" required>
                                @error('temperature_coefficient') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تلرانس توان</label>
                                <input type="text" name="power_tolerance" class="form-control" value="{{ old('power_tolerance') }}" required>
                                @error('power_tolerance') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات سلول --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات سلول</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">تعداد سلول</label>
                                <input type="number" name="number_of_cells" class="form-control" value="{{ old('number_of_cells') }}" required>
                                @error('number_of_cells') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نوع سلول</label>
                                <select name="cell_type" class="form-control" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="Half cell" {{ old('cell_type') == 'Half cell' ? 'selected' : '' }}>Half cell</option>
                                    <option value="Full cell" {{ old('cell_type') == 'Full cell' ? 'selected' : '' }}>Full cell</option>
                                </select>
                                @error('cell_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- گارانتی و استانداردها --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">گارانتی و استانداردها</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">گارانتی محصول</label>
                                <input type="text" name="product_warranty" class="form-control" value="{{ old('product_warranty') }}" required placeholder="مثال: 12 سال">
                                @error('product_warranty') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">گارانتی عملکرد</label>
                                <input type="text" name="performance_warranty" class="form-control" value="{{ old('performance_warranty') }}" required placeholder="مثال: 25 سال">
                                @error('performance_warranty') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">IEC 61215</label>
                                <select name="iec_61215" class="form-control">
                                    <option value="0" {{ old('iec_61215') == '0' ? 'selected' : '' }}>ندارد</option>
                                    <option value="1" {{ old('iec_61215') == '1' ? 'selected' : '' }}>دارد</option>
                                </select>
                                @error('iec_61215') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">IEC 61730</label>
                                <select name="iec_61730" class="form-control">
                                    <option value="0" {{ old('iec_61730') == '0' ? 'selected' : '' }}>ندارد</option>
                                    <option value="1" {{ old('iec_61730') == '1' ? 'selected' : '' }}>دارد</option>
                                </select>
                                @error('iec_61730') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- مشخصات فیزیکی --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">مشخصات فیزیکی</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">نوع کانکتور</label>
                                <input type="text" name="connector_type" class="form-control" value="{{ old('connector_type') }}" required>
                                @error('connector_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ابعاد</label>
                                <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions') }}" required placeholder="مثال: 2278x1134x30 mm">
                                @error('dimensions') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">وزن (کیلوگرم)</label>
                                <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}" required>
                                @error('weight') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- دیتاشیت --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">دیتاشیت</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">فایل دیتاشیت (PDF)</label>
                                <input type="file" name="datasheet_path" class="form-control" accept=".pdf">
                                @error('datasheet_path') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">نسخه دیتاشیت</label>
                                <input type="text" name="datasheet_version" class="form-control" value="{{ old('datasheet_version') }}">
                                @error('datasheet_version') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- وضعیت تولید و تاییدیه --}}
                    <fieldset class="mb-4">
                        <legend class="font-weight-bold text-primary" style="font-size:1rem; border-bottom: 2px solid #1976d2; padding-bottom:5px;">وضعیت تولید و تاییدیه</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">تاریخ تولید</label>
                                <input type="text" name="production_date" class="form-control persian-date" value="{{ old('production_date') }}">
                                @error('production_date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تاریخ توقف تولید</label>
                                <input type="text" name="discontinuation_date" class="form-control persian-date" value="{{ old('discontinuation_date') }}">
                                @error('discontinuation_date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تاییدیه آزمایشگاه</label>
                                <select name="lab_certified" class="form-control">
                                    <option value="0" {{ old('lab_certified') == '0' ? 'selected' : '' }}>ندارد</option>
                                    <option value="1" {{ old('lab_certified') == '1' ? 'selected' : '' }}>دارد</option>
                                </select>
                                @error('lab_certified') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">نام آزمایشگاه</label>
                                <select name="lab_name" class="form-control select2">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach(config('panel-catalog.labs') as $lab)
                                        <option value="{{ $lab }}" {{ old('lab_name') == $lab ? 'selected' : '' }}>{{ $lab }}</option>
                                    @endforeach
                                </select>
                                @error('lab_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">وضعیت اتحادیه</label>
                                <input type="text" name="union_approval_status" class="form-control" value="{{ old('union_approval_status') }}" readonly placeholder="خودکار محاسبه می‌شود">
                                <small class="text-muted">اگر تاییدیه آزمایشگاه + IEC 61215 + IEC 61730 داشته باشد، خودکار "union-approved" می‌شود</small>
                                @error('union_approval_status') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-4 text-end">
                        <a href="{{ route('panel-catalog.index') }}" class="btn btn-secondary ms-2">بازگشت</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save ms-1"></i> ثبت پنل
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
            // دکمه پر کردن با آخرین رکورد
            $('#fillLastRecord').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> در حال دریافت...');

                $.ajax({
                    url: '{{ route("panel-catalog.last-record") }}',
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            // فیلدهای متنی
                            var textFields = [
                                'brand', 'manufacture', 'country_of_manufacture', 'model', 'model_code',
                                'technology', 'power_tolerance', 'product_warranty', 'performance_warranty',
                                'connector_type', 'dimensions', 'datasheet_version', 'union_approval_status'
                            ];
                            textFields.forEach(function(field) {
                                if (data[field]) {
                                    var $el = $('input[name="' + field + '"], select[name="' + field + '"]');
                                    $el.val(data[field]).trigger('change');
                                }
                            });

                            // فیلدهای عددی
                            var numFields = [
                                'rated_power_wp', 'module_efficiency', 'number_of_cells',
                                'voc', 'isc', 'vmp', 'imp', 'max_system_voltage',
                                'temperature_coefficient', 'weight'
                            ];
                            numFields.forEach(function(field) {
                                if (data[field] !== null && data[field] !== undefined) {
                                    $('input[name="' + field + '"]').val(data[field]);
                                }
                            });

                            // select fields
                            if (data.panel_type) {
                                $('select[name="panel_type"]').val(data.panel_type);
                            }
                            if (data.cell_type) {
                                $('select[name="cell_type"]').val(data.cell_type);
                            }
                            if (data.lab_name) {
                                $('select[name="lab_name"]').val(data.lab_name).trigger('change');
                            }

                            // checkbox-like selects
                            if (data.iec_61215 !== undefined) {
                                $('select[name="iec_61215"]').val(data.iec_61215 ? '1' : '0');
                            }
                            if (data.iec_61730 !== undefined) {
                                $('select[name="iec_61730"]').val(data.iec_61730 ? '1' : '0');
                            }
                            if (data.lab_certified !== undefined) {
                                $('select[name="lab_certified"]').val(data.lab_certified ? '1' : '0');
                            }

                            // تاریخ‌ها
                            if (data.production_date) {
                                $('input[name="production_date"]').val(data.production_date);
                            }
                            if (data.discontinuation_date) {
                                $('input[name="discontinuation_date"]').val(data.discontinuation_date);
                            }

                            toastr.success('فیلدها با آخرین رکورد پر شدند');
                        } else {
                            toastr.info('رکوردی یافت نشد');
                        }
                    },
                    error: function() {
                        toastr.error('خطا در دریافت اطلاعات');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-copy ms-1"></i> پر کردن با آخرین رکورد');
                    }
                });
            });

            // محاسبه خودکار وضعیت اتحادیه
            function checkUnionApproval() {
                var labCertified = $('select[name="lab_certified"]').val() === '1';
                var labName = $('select[name="lab_name"]').val();
                var iec61215 = $('select[name="iec_61215"]').val() === '1';
                var iec61730 = $('select[name="iec_61730"]').val() === '1';

                if (labCertified && labName && iec61215 && iec61730) {
                    $('input[name="union_approval_status"]').val('union-approved');
                } else {
                    $('input[name="union_approval_status"]').val('');
                }
            }

            $('select[name="lab_certified"], select[name="lab_name"], select[name="iec_61215"], select[name="iec_61730"]').on('change', checkUnionApproval);
            checkUnionApproval();
        });
    </script>
@endsection
