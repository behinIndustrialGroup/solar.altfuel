@extends('behin-layouts.app')

@section('title', 'افزودن پنل به پروژه #' . $project->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Header --}}
        <div class="card card-primary card-outline mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fa fa-sun-o text-primary ml-2"></i>
                    افزودن پنل نصب‌شده
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
              action="{{ route('solar-plant-equipment.projects.panels.store', $project) }}">
            @csrf

            {{-- مدل پنل --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">مدل پنل</h6></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="panel_model_id">انتخاب مدل پنل <span class="text-danger">*</span></label>
                        <select name="panel_model_id" id="panel_model_id"
                                class="form-control select2 @error('panel_model_id') is-invalid @enderror">
                            <option value="">— انتخاب کنید —</option>
                            @foreach ($panels as $panel)
                                <option value="{{ $panel->id }}"
                                    {{ old('panel_model_id') == $panel->id ? 'selected' : '' }}>
                                    {{ $panel->brand }} — {{ $panel->model }}
                                    ({{ $panel->rated_power_wp }} Wp)
                                </option>
                            @endforeach
                        </select>
                        @error('panel_model_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- شماره سریال --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">شناسه فیزیکی</h6></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="serial_number">شماره سریال <span class="text-danger">*</span></label>
                        <input type="text" name="serial_number" id="serial_number"
                               value="{{ old('serial_number') }}"
                               class="form-control @error('serial_number') is-invalid @enderror"
                               placeholder="مثال: TRI-2024-A1B2C3"
                               dir="ltr">
                        @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">ترکیب عدد، حرف و خط‌تیره — منحصر به فرد برای هر پنل</small>
                    </div>
                </div>
            </div>

            {{-- موقعیت فیزیکی --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">موقعیت در نیروگاه</h6></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="section_number">شماره بخش (Section) <span class="text-danger">*</span></label>
                                <input type="number" name="section_number" id="section_number"
                                       value="{{ old('section_number', 1) }}" min="1"
                                       class="form-control @error('section_number') is-invalid @enderror">
                                @error('section_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="string_number">شماره استرینگ (String) <span class="text-danger">*</span></label>
                                <input type="number" name="string_number" id="string_number"
                                       value="{{ old('string_number', 1) }}" min="1"
                                       class="form-control @error('string_number') is-invalid @enderror">
                                @error('string_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="panel_number">شماره پنل در استرینگ <span class="text-danger">*</span></label>
                                <input type="number" name="panel_number" id="panel_number"
                                       value="{{ old('panel_number', 1) }}" min="1"
                                       class="form-control @error('panel_number') is-invalid @enderror">
                                @error('panel_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-light border py-2 mb-0">
                        <small class="text-muted">
                            <i class="fa fa-info-circle ml-1"></i>
                            موقعیت پنل:
                            بخش <strong id="preview_section">1</strong> /
                            استرینگ <strong id="preview_string">1</strong> /
                            پنل <strong id="preview_panel">1</strong>
                        </small>
                    </div>
                </div>
            </div>

            {{-- وضعیت و توضیحات --}}
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">وضعیت</h6></div>
                <div class="card-body">
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
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fa fa-save ml-1"></i> ثبت پنل
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
    $('#panel_model_id').select2({
        placeholder: 'جستجو در مدل‌های پنل...',
        allowClear: true,
        width: '100%'
    });

    // live position preview
    function updatePreview() {
        $('#preview_section').text($('#section_number').val() || '—');
        $('#preview_string').text($('#string_number').val()  || '—');
        $('#preview_panel').text($('#panel_number').val()    || '—');
    }
    $('#section_number, #string_number, #panel_number').on('input', updatePreview);
    updatePreview();
});
</script>
@endsection
