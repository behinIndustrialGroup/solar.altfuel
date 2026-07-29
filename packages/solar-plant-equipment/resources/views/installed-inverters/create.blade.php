@extends('behin-layouts.app')

@section('title', 'افزودن اینورتر به پروژه #' . $project->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Header --}}
        <div class="card card-warning card-outline mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fa fa-bolt text-warning ml-2"></i>
                    افزودن اینورتر نصب‌شده
                    <small class="text-muted mr-2">پروژه #{{ $project->id }}</small>
                </h3>
                <a href="{{ route('solar-plant-equipment.projects.show', $project) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-right ml-1"></i> بازگشت به پروژه
                </a>
            </div>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul class="mb-0 pr-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('solar-plant-equipment.projects.inverters.store', $project) }}">
            @csrf

            {{-- مدل اینورتر --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">مدل اینورتر</h6></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="inverter_model_id">انتخاب مدل اینورتر <span class="text-danger">*</span></label>
                        <select name="inverter_model_id" id="inverter_model_id"
                                class="form-control select2 @error('inverter_model_id') is-invalid @enderror">
                            <option value="">— انتخاب کنید —</option>
                            @foreach ($inverters as $inv)
                                <option value="{{ $inv->id }}"
                                    {{ old('inverter_model_id') == $inv->id ? 'selected' : '' }}>
                                    {{ $inv->brand }} — {{ $inv->model_name }}
                                    ({{ $inv->rated_power_kw }} kW | {{ $inv->inverter_type }})
                                </option>
                            @endforeach
                        </select>
                        @error('inverter_model_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- شناسه و سریال --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">شناسه و سریال</h6></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="equipment_tag">Equipment Tag <span class="text-danger">*</span></label>
                                <input type="text" name="equipment_tag" id="equipment_tag"
                                       value="{{ old('equipment_tag') }}"
                                       class="form-control @error('equipment_tag') is-invalid @enderror"
                                       placeholder="مثال: INV_01"
                                       dir="ltr">
                                @error('equipment_tag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">فرمت پیشنهادی: INV_01، INV_02، ...</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serial_number">شماره سریال <span class="text-danger">*</span></label>
                                <input type="text" name="serial_number" id="serial_number"
                                       value="{{ old('serial_number') }}"
                                       class="form-control @error('serial_number') is-invalid @enderror"
                                       placeholder="مثال: SMA-2024-X1Y2Z3"
                                       dir="ltr">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">روی پلاک دستگاه درج شده — منحصر به فرد</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- محل نصب و وضعیت --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">محل نصب و وضعیت</h6></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="installation_location">محل نصب <span class="text-danger">*</span></label>
                                <select name="installation_location" id="installation_location"
                                        class="form-control @error('installation_location') is-invalid @enderror">
                                    <option value="">— انتخاب کنید —</option>
                                    <option value="electrical_room"    {{ old('installation_location') == 'electrical_room'    ? 'selected':'' }}>اتاق برق</option>
                                    <option value="control_room"       {{ old('installation_location') == 'control_room'       ? 'selected':'' }}>اتاق کنترل</option>
                                    <option value="equipment_container" {{ old('installation_location') == 'equipment_container'? 'selected':'' }}>کانکس تجهیزات</option>
                                    <option value="outdoor"            {{ old('installation_location') == 'outdoor'            ? 'selected':'' }}>فضای باز</option>
                                    <option value="wall_mounted"       {{ old('installation_location') == 'wall_mounted'       ? 'selected':'' }}>روی دیوار</option>
                                    <option value="on_structure"       {{ old('installation_location') == 'on_structure'       ? 'selected':'' }}>روی استراکچر</option>
                                    <option value="other"              {{ old('installation_location') == 'other'              ? 'selected':'' }}>سایر</option>
                                </select>
                                @error('installation_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت تجهیز <span class="text-danger">*</span></label>
                                <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                    <option value="installed"  {{ old('status','installed') == 'installed'  ? 'selected':'' }}>نصب شده</option>
                                    <option value="active"     {{ old('status') == 'active'     ? 'selected':'' }}>در حال بهره‌برداری</option>
                                    <option value="faulty"     {{ old('status') == 'faulty'     ? 'selected':'' }}>معیوب</option>
                                    <option value="replaced"   {{ old('status') == 'replaced'   ? 'selected':'' }}>تعویض شده</option>
                                    <option value="removed"    {{ old('status') == 'removed'    ? 'selected':'' }}>از مدار خارج شده</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="notes">توضیحات</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="توضیحات اختیاری...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning px-5">
                        <i class="fa fa-save ml-1"></i> ثبت اینورتر
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
    $('#inverter_model_id').select2({
        placeholder: 'جستجو در مدل‌های اینورتر...',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
