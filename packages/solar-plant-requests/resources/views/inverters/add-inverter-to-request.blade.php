<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">افزودن اینورتر جدید</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('solar-plant-requests.inverter.store', $solarPlantRequest) }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">سریال</label>
                    <input type="text" name="serial" class="form-control" value="{{ old('serial') }}" required maxlength="255">
                    @error('serial')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">سازنده / واردکننده</label>
                    <select name="manufacturer_user_id" class="form-select select2" required>
                        <option value="" disabled {{ old('manufacturer_user_id') ? '' : 'selected' }}>انتخاب کنید</option>
                        @foreach($inverterManufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" @selected(old('manufacturer_user_id') == $manufacturer->id)>
                                {{ $manufacturer->name ?? $manufacturer->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('manufacturer_user_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">سال تولید</label>
                    <input type="number" name="production_year" class="form-control" value="{{ old('production_year') }}" required>
                    @error('production_year')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">سال انقضا</label>
                    <input type="number" name="expiration_year" class="form-control" value="{{ old('expiration_year') }}" required>
                    @error('expiration_year')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">ثبت اینورتر</button>
            </div>
        </form>
    </div>
</div>

