@extends('behin-layouts.app')

@section('title', 'لیست باتری‌های من')

@section('toolbar')
    <div class="mb-5 mb-lg-0">
        <div class="row g-2">
            <div class="col-12">
                <a href="{{ route('battery.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i>
                    ثبت باتری جدید
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">لیست باتری‌های ثبت شده</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($batteries->isEmpty())
                <div class="alert alert-info">
                    هیچ باتری‌ای یافت نشد.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>سریال</th>
                                <th>سال تولید</th>
                                <th>سال انقضا</th>
                                <th>وضعیت</th>
                                <th>متقاضی</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batteries as $index => $battery)
                                <tr>
                                    <td>{{ $batteries->firstItem() + $index }}</td>
                                    <td>{{ $battery->serial }}</td>
                                    <td>{{ $battery->production_year }}</td>
                                    <td>{{ $battery->expiration_year }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'RESERVED' => 'bg-info',
                                                'USED' => 'bg-success',
                                                'EXPIRED' => 'bg-danger',
                                                'RETURNED' => 'bg-warning',
                                            ][$battery->status->value] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ $battery->status->getLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($battery->request && $battery->request->user)
                                            {{ $battery->request->user->name }} {{ $battery->request->user->family }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ jdate($battery->created_at)->format('Y/m/d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $batteries->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
