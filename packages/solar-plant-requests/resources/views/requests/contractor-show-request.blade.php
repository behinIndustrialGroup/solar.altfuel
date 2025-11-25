@extends('behin-layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
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

                    <div class="card-header">
                        <h5 class="mb-0">جزئیات درخواست</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">نام</label>
                                <input type="text" name="first_name" value="{{ $solarPlantRequest->first_name }}" class="form-control" readonly maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">نام خانوادگی</label>
                                <input type="text" name="last_name" value="{{ $solarPlantRequest->last_name }}" class="form-control" readonly maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">شماره همراه</label>
                                <input type="text" name="mobile" value="{{ $solarPlantRequest->mobile }}" class="form-control" readonly maxlength="20">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">کد ملی</label>
                                <input type="text" name="national_code" value="{{ $solarPlantRequest->national_code }}" class="form-control" readonly maxlength="20">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">کد پستی</label>
                                <input type="text" name="postal_code" value="{{ $solarPlantRequest->postal_code }}" class="form-control" readonly maxlength="20">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">شناسه قبض</label>
                                <input type="text" name="bill_identifier" value="{{ $solarPlantRequest->bill_identifier }}" class="form-control" readonly maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">متراژ (متر مربع)</label>
                                <input type="number" name="area" value="{{ $solarPlantRequest->area }}" class="form-control" readonly min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label">آدرس</label>
                                <textarea name="address" rows="3" class="form-control" readonly>{{ $solarPlantRequest->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                @if ($solarPlantRequest->panels->count())
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">پنل‌های ثبت شده</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>سریال</th>
                                        <th>سازنده / واردکننده</th>
                                        <th>سال تولید</th>
                                        <th>سال انقضا</th>
                                        <th>وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solarPlantRequest->panels as $panel)
                                        <tr>
                                            <td>{{ $panel->serial }}</td>
                                            <td>{{ $panel->manufacturer?->name ?? $panel->manufacturer?->email }}</td>
                                            <td>{{ $panel->production_year }}</td>
                                            <td>{{ $panel->expiration_year }}</td>
                                            <td>{{ $panel->status?->label() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @include('solar-plant-requests::panels.add-panel-to-request')
            </div>
        </div>
    </div>
@endsection
