@extends('behin-layouts.app')

@section('title')
    درخواست‌های من
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">درخواست‌های من</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>شماره پرونده</th>
                                        <th>فرایند</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cases as $case)
                                        <tr>
                                            <td>{{ $case->number }}</td>
                                            <td>{{ $case->process?->name }}</td>
                                            <td dir="ltr">{{ toJalali($case->created_at)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="{{ route('simpleWorkflowReport.my-request.show', ['my_request' => $case->id]) }}" class="btn btn-primary btn-sm">مشاهده</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
