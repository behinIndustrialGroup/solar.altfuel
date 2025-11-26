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
                <h5 class="mb-0">لیست اینورترهای من</h5>
                <a href="{{ route('solar-plant-requests.inverter.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i>
                    افزودن اینورتر جدید
                </a>
            </div>
            <div class="card-body">
                @if($inverters->isEmpty())
                    <div class="alert alert-info">
                        هیچ اینورتری یافت نشد.
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
                                @foreach($inverters as $inverter)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $inverter->serial }}</td>
                                        <td>{{ $inverter->production_year }}</td>
                                        <td>{{ $inverter->expiration_year }}</td>
                                        <td>
                                            <span class="badge bg-{{ $inverter->status->color() }}">
                                                {{ $inverter->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ jdate($inverter->created_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            @if($inverter->request)
                                                <a href="{{ route('solar-plant-requests.show', $inverter->request) }}" class="text-primary">
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
