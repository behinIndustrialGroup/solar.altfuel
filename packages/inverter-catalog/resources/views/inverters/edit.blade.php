@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card rounded-4 border-0 shadow mb-4 overflow-hidden">
            <div class="card-header py-4 px-4 border-0" style="background: linear-gradient(135deg, #FFD54F 0%, #FFC107 100%);">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                            <i class="fa fa-edit fa-2x text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white fw-bold">ویرایش اینورتر</h3>
                            <p class="mb-0 text-white text-opacity-90 small mt-1">
                                <i class="fa fa-cube me-1"></i>
                                مدل: <strong>{{ $inverter->brand }} {{ $inverter->model_name }}</strong>
                                <span class="mx-2">|</span>
                                کد: <code class="bg-white bg-opacity-25 px-2 py-1 rounded text-white">{{ $inverter->model_code }}</code>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        @if(Route::has('inverter-catalog.last-record'))
                            <button type="button" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm fw-bold" id="fillLastRecord" style="color: #F57F17;">
                                <i class="fa fa-copy ms-2"></i> پر کردن با آخرین رکورد
                            </button>
                        @endif
                        <a href="{{ route('inverter-catalog.show', $inverter) }}" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold border-2">
                            <i class="fa fa-eye ms-2"></i> مشاهده جزئیات
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card rounded-4 border-0 shadow overflow-hidden">
            <div class="card-body p-5">
                <form method="POST" action="{{ route('inverter-catalog.update', $inverter) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <fieldset class="mb-5">
                        <legend class="fw-bold px-3 py-2 mb-4 rounded-2 d-inline-block" style="color: #E65100; background: #FFF3E0;">
                        <i class="fa fa-info-circle me-2"></i>اطلاعات پایه
                    </legend>
                        <div class="border-top border-secondary border-opacity-25 mb-4" style="border-bottom-style: dashed !important;"></div>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">برند <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-tag" style="color: #FF9800;"></i></span>
                                    <input type="text" name="brand" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('brand', $inverter->brand) }}" required>
                                </div>
                                @error('brand') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">نام شرکت سازنده <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-building" style="color: #FF9800;"></i></span>
                                    <input type="text" name="manufacture" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('manufacture', $inverter->manufacture) }}" required>
                                </div>
                                @error('manufacture') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">کشور تولید <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-flag" style="color: #FF9800;"></i></span>
                                    <input type="text" name="country_of_manufacture" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('country_of_manufacture', $inverter->country_of_manufacture) }}" required>
                                </div>
                                @error('country_of_manufacture') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">نام مدل <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-cube" style="color: #FF9800;"></i></span>
                                    <input type="text" name="model_name" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('model_name', $inverter->model_name) }}" required>
                                </div>
                                @error('model_name') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">کد مدل <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-barcode" style="color: #FF9800;"></i></span>
                                    <input type="text" name="model_code" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('model_code', $inverter->model_code) }}" required>
                                </div>
                                @error('model_code') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">نوع اینورتر <span class="text-danger">*</span></label>
                                <select name="inverter_type" class="form-select" style="border-radius: 12px;" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($inverterTypes as $type)
                                        <option value="{{ $type }}" {{ old('inverter_type', $inverter->inverter_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('inverter_type') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend class="fw-bold px-3 py-2 mb-4 rounded-2 d-inline-block" style="color: #1565C0; background: #E3F2FD;">
                        <i class="fa fa-bolt me-2"></i>مشخصات الکتریکی
                    </legend>
                        <div class="border-top border-secondary border-opacity-25 mb-4" style="border-bottom-style: dashed !important;"></div>

                        <h6 class="fw-bold text-muted mb-3"><i class="fa fa-arrow-right me-2" style="color: #FF9800;"></i>مشخصات توان</h6>
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">توان نامی (kW) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="rated_power_kw" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('rated_power_kw', $inverter->rated_power_kw) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">kW</span>
                                </div>
                                @error('rated_power_kw') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">تعداد MPPT <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="mppt_count" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('mppt_count', $inverter->mppt_count) }}" required min="1">
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">عدد</span>
                                </div>
                                @error('mppt_count') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">تعداد ورودی هر MPPT <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="strings_per_mppt" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('strings_per_mppt', $inverter->strings_per_mppt) }}" required min="1">
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">عدد</span>
                                </div>
                                @error('strings_per_mppt') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h6 class="fw-bold text-muted mb-3"><i class="fa fa-arrow-right me-2" style="color: #FF9800;"></i>ورودی DC</h6>
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حداکثر ولتاژ ورودی DC (V) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="max_dc_input_voltage" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('max_dc_input_voltage', $inverter->max_dc_input_voltage) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">V</span>
                                </div>
                                @error('max_dc_input_voltage') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حداکثر جریان ورودی (A) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="max_input_current" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('max_input_current', $inverter->max_input_current) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">A</span>
                                </div>
                                @error('max_input_current') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">محدوده ولتاژ MPP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-random" style="color: #1565C0;"></i></span>
                                    <input type="text" name="mpp_voltage_range" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('mpp_voltage_range', $inverter->mpp_voltage_range) }}" required>
                                </div>
                                @error('mpp_voltage_range') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حداکثر توان ورودی PV (kW) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="max_pv_input_power" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('max_pv_input_power', $inverter->max_pv_input_power) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">kW</span>
                                </div>
                                @error('max_pv_input_power') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h6 class="fw-bold text-muted mb-3"><i class="fa fa-arrow-right me-2" style="color: #FF9800;"></i>خروجی AC</h6>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حداکثر جریان خروجی (A) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="max_output_current" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('max_output_current', $inverter->max_output_current) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">A</span>
                                </div>
                                @error('max_output_current') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">ولتاژ خروجی AC (V) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="output_voltage" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('output_voltage', $inverter->output_voltage) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">V</span>
                                </div>
                                @error('output_voltage') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">فرکانس خروجی (Hz) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="output_frequency" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('output_frequency', $inverter->output_frequency) }}" required>
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #1565C0;">Hz</span>
                                </div>
                                @error('output_frequency') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend class="fw-bold px-3 py-2 mb-4 rounded-2 d-inline-block" style="color: #2E7D32; background: #E8F5E9;">
                        <i class="fa fa-chart-line me-2"></i>ویژگی‌های پیشرفته
                    </legend>
                        <div class="border-top border-secondary border-opacity-25 mb-4" style="border-bottom-style: dashed !important;"></div>

                        <h6 class="fw-bold text-muted mb-3"><i class="fa fa-arrow-right me-2" style="color: #FF9800;"></i>عملکرد و راندمان</h6>
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حداکثر راندمان (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="max_efficiency" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('max_efficiency', $inverter->max_efficiency) }}" required min="0" max="100">
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #2E7D32;">%</span>
                                </div>
                                @error('max_efficiency') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">THD (Total Harmonic Distortion)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="thd" class="form-control border-end-0" style="border-radius: 12px 0 0 12px;" value="{{ old('thd', $inverter->thd) }}">
                                    <span class="input-group-text bg-light border-start-0 fw-bold" style="border-radius: 0 12px 12px 0; color: #2E7D32;">%</span>
                                </div>
                                @error('thd') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h6 class="fw-bold text-muted mb-3"><i class="fa fa-arrow-right me-2" style="color: #FF9800;"></i>حفاظت و ویژگی‌ها</h6>
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">درجه حفاظت <span class="text-danger">*</span></label>
                                <select name="protection_level" class="form-select" style="border-radius: 12px;" required>
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="IP65" {{ old('protection_level', $inverter->protection_level) == 'IP65' ? 'selected' : '' }}>IP65</option>
                                    <option value="IP66" {{ old('protection_level', $inverter->protection_level) == 'IP66' ? 'selected' : '' }}>IP66</option>
                                </select>
                                @error('protection_level') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">روش خنک سازی</label>
                                <select name="cooling_type" class="form-select" style="border-radius: 12px;">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($coolingTypes as $cooling)
                                        <option value="{{ $cooling }}" {{ old('cooling_type', $inverter->cooling_type) == $cooling ? 'selected' : '' }}>{{ $cooling }}</option>
                                    @endforeach
                                </select>
                                @error('cooling_type') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-medium">کلید DC</label>
                                <select name="dc_switch" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('dc_switch', $inverter->dc_switch ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('dc_switch', $inverter->dc_switch ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('dc_switch') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-medium">کلید AC</label>
                                <select name="ac_switch" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('ac_switch', $inverter->ac_switch ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('ac_switch', $inverter->ac_switch ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('ac_switch') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-medium">صفحه نمایشگر</label>
                                <select name="display" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('display', $inverter->display ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('display', $inverter->display ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('display') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حفاظت پلاریته معکوس</label>
                                <select name="reverse_polarity_protection" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('reverse_polarity_protection', $inverter->reverse_polarity_protection ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('reverse_polarity_protection', $inverter->reverse_polarity_protection ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('reverse_polarity_protection') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حفاظت ضد جزیره‌ای</label>
                                <select name="anti_islanding_protection" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('anti_islanding_protection', $inverter->anti_islanding_protection ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('anti_islanding_protection', $inverter->anti_islanding_protection ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('anti_islanding_protection') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">حفاظت جریان نشتی</label>
                                <select name="leakage_current_protection" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('leakage_current_protection', $inverter->leakage_current_protection ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('leakage_current_protection', $inverter->leakage_current_protection ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('leakage_current_protection') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-medium">نوع SPD</label>
                                <select name="spd_type" class="form-select" style="border-radius: 12px;">
                                    <option value="0" {{ old('spd_type', $inverter->spd_type ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('spd_type', $inverter->spd_type ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('spd_type') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend class="fw-bold px-3 py-2 mb-4 rounded-2 d-inline-block" style="color: #6A1B9A; background: #F3E5F5;">
                        <i class="fa fa-wifi me-2"></i>ارتباطات و کنترل
                    </legend>
                        <div class="border-top border-secondary border-opacity-25 mb-4" style="border-bottom-style: dashed !important;"></div>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-medium">پروتکل‌های ارتباطی (چند انتخابی)</label>
                                <select name="communication_protocols[]" class="form-control select2" multiple style="border-radius: 12px; min-height: 44px;">
                                    @foreach($communicationProtocols as $protocol)
                                        <option value="{{ $protocol }}" {{ in_array($protocol, old('communication_protocols', $inverter->communication_protocols ?? [])) ? 'selected' : '' }}>{{ $protocol }}</option>
                                    @endforeach
                                </select>
                                @error('communication_protocols') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend class="fw-bold px-3 py-2 mb-4 rounded-2 d-inline-block" style="color: #E65100; background: #FFF3E0;">
                        <i class="fa fa-shield-halved me-2"></i>گارانتی و استاندارد
                    </legend>
                        <div class="border-top border-secondary border-opacity-25 mb-4" style="border-bottom-style: dashed !important;"></div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-medium">مدت گارانتی <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0 12px 12px 0;"><i class="fa fa-calendar-check" style="color: #E65100;"></i></span>
                                    <input type="text" name="warranty_period" class="form-control border-start-0" style="border-radius: 12px 0 0 12px;" value="{{ old('warranty_period', $inverter->warranty_period) }}" required>
                                </div>
                                @error('warranty_period') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-medium">استانداردها (چند انتخابی)</label>
                                <div class="card rounded-3 border bg-light bg-opacity-50 p-4">
                                    <div class="row">
                                        @foreach($standards as $standard)
                                            <div class="col-md-3 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="standards[]" value="{{ $standard }}" id="standard_{{ $loop->index }}" {{ in_array($standard, old('standards', $inverter->standards ?? [])) ? 'checked' : '' }} style="border-radius: 4px;">
                                                    <label class="form-check-label fw-medium" for="standard_{{ $loop->index }}">
                                                        {{ $standard }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('standards') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">فایل دیتاشیت (PDF)</label>
                                <div class="card rounded-3 border-2 border-dashed p-4 text-center" style="border-style: dashed; background: #FFF8E1;">
                                    @if($inverter->datasheet_path)
                                        <div class="mb-3">
                                            <a href="{{ asset('storage/' . $inverter->datasheet_path) }}" target="_blank" class="btn btn-sm rounded-pill shadow-sm px-4" style="background: linear-gradient(135deg, #EF5350 0%, #E53935 100%); color: white;">
                                                <i class="fa fa-file-pdf-o ms-2"></i> مشاهده فایل فعلی
                                            </a>
                                        </div>
                                    @endif
                                    <i class="fa fa-file-pdf-o fa-3x mb-2" style="color: #E53935;"></i>
                                    <input type="file" name="datasheet_path" class="form-control" style="border-radius: 12px; max-width: 300px; margin: 0 auto;" accept=".pdf">
                                    <small class="text-muted d-block mt-2"><i class="fa fa-info-circle me-1"></i>در صورت عدم انتخاب، فایل قبلی حفظ می‌شود</small>
                                </div>
                                @error('datasheet_path') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">توضیحات</label>
                                <textarea name="notes" class="form-control" rows="6" style="border-radius: 12px;">{{ old('notes', $inverter->notes) }}</textarea>
                                @error('notes') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend class="fw-bold px-3 py-2 mb-4 rounded-2 d-inline-block" style="color: #00695C; background: #E0F2F1;">
                        <i class="fa fa-stamp me-2"></i>تاییدیه اتحادیه و آزمایشگاه
                    </legend>
                        <div class="border-top border-secondary border-opacity-25 mb-4" style="border-bottom-style: dashed !important;"></div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label fw-medium">تاییدیه آزمایشگاه دارد؟</label>
                                <select name="lab_certified" class="form-select" id="lab_certified" style="border-radius: 12px;">
                                    <option value="0" {{ old('lab_certified', $inverter->lab_certified ? '1' : '0') == '0' ? 'selected' : '' }}>خیر</option>
                                    <option value="1" {{ old('lab_certified', $inverter->lab_certified ? '1' : '0') == '1' ? 'selected' : '' }}>بله</option>
                                </select>
                                @error('lab_certified') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4" id="lab_name_container">
                                <label class="form-label fw-medium">نام آزمایشگاه</label>
                                <select name="lab_name" class="form-control select2" id="lab_name" style="border-radius: 12px;">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab }}" {{ old('lab_name', $inverter->lab_name) == $lab ? 'selected' : '' }}>{{ $lab }}</option>
                                    @endforeach
                                </select>
                                @error('lab_name') <div class="text-danger small mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="alert rounded-3 border-0" style="background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); color: #E65100;">
                                    <div class="d-flex align-items-start">
                                        <i class="fa fa-info-circle fa-lg me-3 mt-1"></i>
                                        <div>
                                            <strong class="d-block mb-1">توجه مهم</strong>
                                            <small>در صورتی که اینورتر تاییدیه آزمایشگاه داشته باشد و دیتاشیت نیز بارگذاری شود، به صورت خودکار وضعیت «تایید اتحادیه» فعال می‌شود.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top flex-wrap gap-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('inverter-catalog.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-5 fw-bold">
                                <i class="fa fa-list ms-2"></i> بازگشت به لیست
                            </a>
                            <a href="{{ route('inverter-catalog.show', $inverter) }}" class="btn btn-outline-info btn-lg rounded-pill px-5 fw-bold">
                                <i class="fa fa-eye ms-2"></i> مشاهده جزئیات
                            </a>
                        </div>
                        <button type="submit" class="btn btn-lg rounded-pill px-5 fw-bold shadow-sm" style="background: linear-gradient(135deg, #FFD54F 0%, #FFC107 100%); color: #5D4037; border: none;">
                            <i class="fa fa-save ms-2"></i> ذخیره تغییرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <style>
        .form-control, .form-select {
            border: 1px solid #E0E0E0;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #FFC107;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
        }
        fieldset legend {
            font-size: 1.05rem;
            border: none;
            width: auto;
            padding-right: 1rem;
            padding-left: 1rem;
            margin-bottom: 0;
        }
        .border-secondary.border-opacity-25 {
            border-color: rgba(108, 117, 125, 0.25) !important;
            border-width: 2px !important;
            border-style: dashed !important;
        }
    </style>
    <script>
        $(document).ready(function() {
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

            @if(Route::has('inverter-catalog.last-record'))
            $('#fillLastRecord').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-2"></i> در حال دریافت...');

                $.ajax({
                    url: '{{ route("inverter-catalog.last-record") }}',
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            var textFields = [
                                'brand', 'manufacture', 'country_of_manufacture', 'model_name', 'model_code',
                                'mpp_voltage_range', 'warranty_period', 'notes'
                            ];
                            textFields.forEach(function(field) {
                                if (data[field]) {
                                    $('input[name="' + field + '"], textarea[name="' + field + '"]').val(data[field]);
                                }
                            });

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

                            if (data.inverter_type) {
                                $('select[name="inverter_type"]').val(data.inverter_type);
                            }
                            if (data.protection_level) {
                                $('select[name="protection_level"]').val(data.protection_level);
                            }
                            if (data.cooling_type) {
                                $('select[name="cooling_type"]').val(data.cooling_type);
                            }

                            var boolFields = [
                                'dc_switch', 'ac_switch', 'reverse_polarity_protection', 'display',
                                'anti_islanding_protection', 'leakage_current_protection', 'spd_type', 'lab_certified'
                            ];
                            boolFields.forEach(function(field) {
                                if (data[field] !== undefined) {
                                    $('select[name="' + field + '"]').val(data[field] ? '1' : '0');
                                }
                            });

                            if (data.lab_name) {
                                $('select[name="lab_name"]').val(data.lab_name).trigger('change');
                            }

                            if (data.communication_protocols && Array.isArray(data.communication_protocols)) {
                                $('select[name="communication_protocols[]"]').val(data.communication_protocols).trigger('change');
                            }

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
                        btn.prop('disabled', false).html('<i class="fa fa-copy ms-2"></i> پر کردن با آخرین رکورد');
                    }
                });
            });
            @endif
        });
    </script>
@endsection
