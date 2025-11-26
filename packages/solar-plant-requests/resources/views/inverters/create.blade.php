@extends('behin-layouts.app')

@section('content')
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">افزودن اینورتر جدید</h5>
                <a href="{{ route('solar-plant-requests.inverter.my-inverters') }}" class="btn btn-outline-primary">
                    <i class="fa fa-list ms-1"></i>
                    مشاهده اینورترهای من
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('solar-plant-requests.inverter.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">سریال</label>
                            <input type="text" name="serial" class="form-control" value="{{ old('serial') }}" required maxlength="255">
                            @error('serial')
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
    </div>
@endsection
