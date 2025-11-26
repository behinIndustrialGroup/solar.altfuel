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
                                    <th class="text-end">اقدامات</th>
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
                                        @if($requestItem->status == SolarPlantRequestStatus::UNDER_REVIEW)
                                            <form method="POST"
                                                action="{{ route('solar-plant-requests.all-requests.assign-contractor', $requestItem) }}"
                                                class="d-flex gap-2 flex-wrap justify-content-end">
                                                @csrf
                                                <select name="contractor_id" class="form-select form-select-sm select2">
                                                    @foreach ($contractors as $contractor)
                                                        <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary btn-sm" type="submit">تخصیص پیمانکار</button>
                                            </form>
                                        @endif
                                        @if($requestItem->status == SolarPlantRequestStatus::INSPECTION)

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
