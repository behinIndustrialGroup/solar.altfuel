@extends('behin-layouts.app')

@section('title')
    جزئیات درخواست
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $case->name }}</div>
                    <div class="card-body">
                        <p>{{ trans('fields.Case Number') }}: {{ $case->number }}</p>
                        <p>{{ trans('fields.Process') }}: {{ $case->process?->name }}</p>
                        <p>{{ trans('fields.Created At') }}: <span dir="ltr">{{ toJalali($case->created_at)->format('Y-m-d H:i') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
