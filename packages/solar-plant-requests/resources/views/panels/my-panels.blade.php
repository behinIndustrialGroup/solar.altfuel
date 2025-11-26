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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">لیست پنل‌های من</h5>
                <a href="{{ route('solar-plant-requests.panel.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i>
                    افزودن پنل جدید
                </a>
            </div>
            <div class="card-body">
                @if($panels->isEmpty())
                    <div class="alert alert-info">
                        هیچ پنلی یافت نشد.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>سریال</th>
                                    <th>سال تولید</th>
                                    <th>سال انقضا</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ ثبت</th>
                                    <th>متصل به درخواست</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($panels as $index => $panel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $panel->serial }}</td>
                                        <td>{{ $panel->production_year }}</td>
                                        <td>{{ $panel->expiration_year }}</td>
                                        <td>
                                            <span class="badge">
                                                {{ $panel->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ jdate($panel->created_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            @if($panel->request)
                                                <a href="{{ route('solar-plant-requests.show', $panel->request) }}" class="text-primary">
                                                    مشاهده درخواست
                                                </a>
                                            @else
                                                <span class="text-muted">متصل نشده</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
