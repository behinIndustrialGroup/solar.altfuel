@extends('behin-layouts.app')
@php
    use SolarPlantRequests\Enums\SolarPlantRequestStatus;
@endphp

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">ثبت درخواست نیروگاه خورشیدی</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solar-plant-requests.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">نام</label>
                                    <input type="text" name="first_name" class="form-control" required maxlength="255">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">نام خانوادگی</label>
                                    <input type="text" name="last_name" class="form-control" required maxlength="255">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">شماره همراه</label>
                                    <input type="text" name="mobile" class="form-control" required maxlength="20">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">کد ملی</label>
                                    <input type="text" name="national_code" class="form-control" required maxlength="20">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">کد پستی</label>
                                    <input type="text" name="postal_code" class="form-control" required maxlength="20">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">شناسه قبض</label>
                                    <input type="text" name="bill_identifier" class="form-control" maxlength="255">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">متراژ (متر مربع)</label>
                                    <input type="number" name="area" class="form-control" min="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">آدرس</label>
                                    <textarea name="address" rows="3" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-success" type="submit">ثبت درخواست</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">لیست درخواست‌ها</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>درخواست دهنده</th>
                                    <th>شماره همراه</th>
                                    <th>وضعیت</th>
                                    <th>پیمانکار</th>
                                    <th>آدرس</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $requestItem)
                                    <tr>
                                        <td>{{ $requestItem->id }}</td>
                                        <td>{{ $requestItem->first_name }} {{ $requestItem->last_name }}</td>
                                        <td>{{ $requestItem->mobile }}</td>
                                        <td>{{ $requestItem->status_label }}</td>
                                        <td>{{ $requestItem->contractor_name ?? '---' }}</td>
                                        <td>{{ $requestItem->address }}</td>
                                        <td>
                                            @if ($requestItem->status == SolarPlantRequestStatus::CERTIFICATE_ISSUED)
                                                <a href="{{ route('solar-plant-requests.show', $requestItem) }}"
                                                    class="btn btn-primary">
                                                    مشاهده گواهی سلامت
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">درخواستی ثبت نشده است.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
