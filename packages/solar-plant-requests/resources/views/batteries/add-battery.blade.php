@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('solar-plant-requests.battery.store') }}" method="POST" class="form-horizontal">
    @csrf
    
    <div class="form-group row mb-3">
        <label for="serial" class="col-sm-3 col-form-label">سریال</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('serial') is-invalid @enderror" 
                   id="serial" name="serial" value="{{ old('serial') }}" required>
            @error('serial')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <input type="hidden" name="manufacturer_user_id" value="{{ auth()->id() }}">

    <div class="form-group row mb-3">
        <label for="production_year" class="col-sm-3 col-form-label">سال تولید</label>
        <div class="col-sm-9">
            <input type="number" class="form-control @error('production_year') is-invalid @enderror" 
                   id="production_year" name="production_year" 
                   value="{{ old('production_year') }}" 
                   min="1300" max="1500" required>
            @error('production_year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="expiration_year" class="col-sm-3 col-form-label">سال انقضا</label>
        <div class="col-sm-9">
            <input type="number" class="form-control @error('expiration_year') is-invalid @enderror" 
                   id="expiration_year" name="expiration_year" 
                   value="{{ old('expiration_year') }}" 
                   min="1300" max="1500" required>
            @error('expiration_year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
    </div>
</form>
