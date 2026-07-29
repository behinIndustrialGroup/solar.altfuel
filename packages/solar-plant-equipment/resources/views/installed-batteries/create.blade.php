@extends('behin-layouts.app')

@section('title', 'افزودن باتری به پروژه #' . $project->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Header --}}
        <div class="card card-success card-outline mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fa fa-battery-full text-success ml-2"></i>
                    افزودن باتری نصب‌شده
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
              action="{{ route('solar-plant-equipment.projects.batteries.store', $project) }}">
            @csrf

            {{-- مدل باتری --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">مدل باتری</h6></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="battery_model_id">انتخاب مدل باتری <span class="text-danger">*</span></label>
                        <select name="battery_model_id" id="battery_model_id"
                                class="form-control select2 @error('battery_model_id') is-invalid @enderror">
                            <option value="">— انتخاب کنید —</option>
                            @foreach ($batteries as $bat)
                                <option value="{{ $bat->id }}"
                                    {{ old('battery_model_id') == $bat->id ? 'selected' : '' }}>
                                    {{ $bat->brand }} — {{ $bat->model_name }}
                                    ({{ $bat->energy_capacity_kwh }} kWh | {{ $bat->battery_type }})
                                </option>
                            @endforeach
                        </select>
                        @error('battery_model_id')
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
                                       placeholder="مثال: BAT_01"
                                       dir="ltr">
                                @error('equipment_tag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">فرمت پیشنهادی: BAT_01، BAT_02، ...</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serial_number">شماره سریال <span class="text-danger">*</span></label>
                                <input type="text" name="serial_number" id="serial_number"
                                       value="{{ old('serial_number') }}"
                                       class="form-control @error('serial_number') is-invalid @enderror"
                                       placeholder="مثال: PYLONTECH-2024-A1B2"
                                       dir="ltr">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">روی پلاک دستگاه — منحصر به فرد</small>
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
                                    <option value="battery_rack"      {{ old('installation_location') == 'battery_rack'      ? 'selected':'' }}>رک باتری</option>
                                    <option value="battery_cabinet"   {{ old('installation_location') == 'battery_cabinet'   ? 'selected':'' }}>کابینت باتری</option>
                                    <option value="battery_room"      {{ old('installation_location') == 'battery_room'      ? 'selected':'' }}>اتاق باتری</option>
                                    <option value="storage_container" {{ old('installation_location') == 'storage_container' ? 'selected':'' }}>کانتینر ذخیره‌ساز</option>
                                    <option value="other"             {{ old('installation_location') == 'other'             ? 'selected':'' }}>سایر</option>
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
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fa fa-save ml-1"></i> ثبت باتری
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
    $('#battery_model_id').select2({
        placeholder: 'جستجو در مدل‌های باتری...',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
