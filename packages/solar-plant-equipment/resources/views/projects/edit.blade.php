@extends('behin-layouts.app')

@section('title', 'ویرایش پروژه #' . $project->id)

@section('style')
<style>
    .section-card { border-right: 4px solid #1976d2; }
    .section-title { color: #1976d2; font-weight: 700; font-size: 1rem; margin-bottom: 1rem; }
    .select2-container--default .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1976d2;
        border-color: #1565c0;
        color: #fff;
        border-radius: 3px;
        padding: 0 8px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-left: 4px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card card-warning card-outline mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fa fa-edit text-warning ml-2"></i>
                    ویرایش پروژه <span class="badge badge-secondary">#{{ $project->id }}</span>
                </h3>
                <a href="{{ route('solar-plant-equipment.projects.index') }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-right ml-1"></i> بازگشت
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5><i class="icon fa fa-ban"></i> خطا در ویرایش اطلاعات</h5>
                <ul class="mb-0 pr-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('solar-plant-equipment.projects.update', $project) }}"
              id="projectForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    {{-- درخواست --}}
                    <div class="card section-card mb-3">
                        <div class="card-body">
                            <div class="section-title">
                                <i class="fa fa-file-text-o ml-1"></i> درخواست مرتبط
                            </div>
                            <div class="form-group mb-0">
                                <label for="request_id">انتخاب درخواست ثبت‌شده</label>
                                <select name="request_id" id="request_id"
                                        class="form-control select2 @error('request_id') is-invalid @enderror">
                                    <option value="">— بدون درخواست —</option>
                                    @foreach ($requests as $req)
                                        <option value="{{ $req->id }}"
                                            {{ old('request_id', $project->request_id) == $req->id ? 'selected' : '' }}>
                                            {{ $req->unique_code }}
                                            —
                                            @if ($req->applicant_type->value === 'company')
                                                {{ $req->company_name }}
                                            @else
                                                {{ $req->first_name }} {{ $req->last_name }}
                                            @endif
                                            ({{ $req->province }} / {{ $req->city }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('request_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- پیمانکار --}}
                    <div class="card section-card mb-3">
                        <div class="card-body">
                            <div class="section-title">
                                <i class="fa fa-building ml-1"></i> پیمانکار
                            </div>
                            <div class="form-group mb-0">
                                <label for="contractor_id">انتخاب پیمانکار</label>
                                <select name="contractor_id" id="contractor_id"
                                        class="form-control select2 @error('contractor_id') is-invalid @enderror">
                                    <option value="">— بدون پیمانکار —</option>
                                    @foreach ($contractors as $contractor)
                                        <option value="{{ $contractor->id }}"
                                            {{ old('contractor_id', $project->contractor_id) == $contractor->id ? 'selected' : '' }}>
                                            {{ $contractor->company_name }}
                                            @if ($contractor->license_number)
                                                (lic: {{ $contractor->license_number }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('contractor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- بازرس --}}
                    <div class="card section-card mb-3">
                        <div class="card-body">
                            <div class="section-title">
                                <i class="fa fa-search ml-1"></i> بازرس
                            </div>
                            <div class="form-group mb-0">
                                <label for="inspector_id">انتخاب بازرس</label>
                                <select name="inspector_id" id="inspector_id"
                                        class="form-control select2 @error('inspector_id') is-invalid @enderror">
                                    <option value="">— بدون بازرس —</option>
                                    @foreach ($inspectors as $inspector)
                                        <option value="{{ $inspector->id }}"
                                            {{ old('inspector_id', $project->inspector_id) == $inspector->id ? 'selected' : '' }}>
                                            {{ $inspector->name }}
                                            @if ($inspector->phone)
                                                — {{ $inspector->phone }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('inspector_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">
                                    فقط کاربرانی با نقش بازرس نمایش داده می‌شوند.
                                </small>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card bg-light mb-3">
                        <div class="card-body py-3">
                            <h6 class="font-weight-bold text-secondary mb-3">
                                <i class="fa fa-info-circle ml-1"></i> خلاصه تجهیزات
                            </h6>
                            <div class="d-flex flex-wrap" style="gap:.5rem;">
                                <span class="badge badge-primary" style="font-size:.8rem;padding:5px 10px;">
                                    پنل: <span id="panelCountNum">{{ count($project->installed_panel_ids ?? []) }}</span> مدل
                                </span>
                                <span class="badge badge-warning" style="font-size:.8rem;padding:5px 10px;">
                                    اینورتر: <span id="inverterCountNum">{{ count($project->installed_inverter_ids ?? []) }}</span> مدل
                                </span>
                                <span class="badge badge-success" style="font-size:.8rem;padding:5px 10px;">
                                    باتری: <span id="batteryCountNum">{{ count($project->installed_battery_ids ?? []) }}</span> مدل
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- پنل‌ها --}}
            <div class="card section-card mb-3">
                <div class="card-header">
                    <div class="section-title mb-0">
                        <i class="fa fa-sun-o ml-1"></i> مدل‌های پنل نصب‌شده
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label>انتخاب مدل‌های پنل</label>
                        <select name="installed_panel_ids[]"
                                id="installed_panel_ids"
                                class="form-control select2-multi @error('installed_panel_ids') is-invalid @enderror"
                                multiple="multiple">
                            @foreach ($panels as $panel)
                                <option value="{{ $panel->id }}"
                                    {{ in_array($panel->id, old('installed_panel_ids', $project->installed_panel_ids ?? [])) ? 'selected' : '' }}>
                                    {{ $panel->brand }} — {{ $panel->model }}
                                    ({{ $panel->rated_power_wp }} Wp | {{ $panel->panel_type }})
                                </option>
                            @endforeach
                        </select>
                        @error('installed_panel_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- اینورترها --}}
            <div class="card section-card mb-3">
                <div class="card-header">
                    <div class="section-title mb-0">
                        <i class="fa fa-bolt ml-1"></i> مدل‌های اینورتر نصب‌شده
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label>انتخاب مدل‌های اینورتر</label>
                        <select name="installed_inverter_ids[]"
                                id="installed_inverter_ids"
                                class="form-control select2-multi @error('installed_inverter_ids') is-invalid @enderror"
                                multiple="multiple">
                            @foreach ($inverters as $inverter)
                                <option value="{{ $inverter->id }}"
                                    {{ in_array($inverter->id, old('installed_inverter_ids', $project->installed_inverter_ids ?? [])) ? 'selected' : '' }}>
                                    {{ $inverter->brand }} — {{ $inverter->model_name }}
                                    ({{ $inverter->rated_power_kw }} kW | {{ $inverter->inverter_type }})
                                </option>
                            @endforeach
                        </select>
                        @error('installed_inverter_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- باتری‌ها --}}
            <div class="card section-card mb-3">
                <div class="card-header">
                    <div class="section-title mb-0">
                        <i class="fa fa-battery-full ml-1"></i> مدل‌های باتری نصب‌شده
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label>انتخاب مدل‌های باتری</label>
                        <select name="installed_battery_ids[]"
                                id="installed_battery_ids"
                                class="form-control select2-multi @error('installed_battery_ids') is-invalid @enderror"
                                multiple="multiple">
                            @foreach ($batteries as $battery)
                                <option value="{{ $battery->id }}"
                                    {{ in_array($battery->id, old('installed_battery_ids', $project->installed_battery_ids ?? [])) ? 'selected' : '' }}>
                                    {{ $battery->brand }} — {{ $battery->model_name }}
                                    ({{ $battery->energy_capacity_kwh }} kWh | {{ $battery->battery_type }})
                                </option>
                            @endforeach
                        </select>
                        @error('installed_battery_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-warning btn-lg px-5">
                        <i class="fa fa-save ml-2"></i> ذخیره تغییرات
                    </button>
                    <a href="{{ route('solar-plant-equipment.projects.show', $project) }}"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-times ml-1"></i> انصراف
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#request_id, #contractor_id, #inspector_id').select2({
        placeholder: 'جستجو کنید...',
        allowClear: true,
        width: '100%',
        language: { noResults: function () { return 'نتیجه‌ای یافت نشد'; } }
    });

    $('.select2-multi').select2({
        placeholder: 'انتخاب کنید...',
        allowClear: true,
        width: '100%',
        language: { noResults: function () { return 'نتیجه‌ای یافت نشد'; } }
    });

    function updateCounts() {
        var p = $('#installed_panel_ids').val()    ? $('#installed_panel_ids').val().length    : 0;
        var i = $('#installed_inverter_ids').val() ? $('#installed_inverter_ids').val().length : 0;
        var b = $('#installed_battery_ids').val()  ? $('#installed_battery_ids').val().length  : 0;
        $('#panelCountNum').text(p);
        $('#inverterCountNum').text(i);
        $('#batteryCountNum').text(b);
    }
    $('#installed_panel_ids, #installed_inverter_ids, #installed_battery_ids').on('change', updateCounts);
    updateCounts();
});
</script>
@endsection
