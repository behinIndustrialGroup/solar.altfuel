@extends('behin-layouts.app')

@section('title', 'ثبت باتری جدید')

@section('toolbar')
    <div class="mb-5 mb-lg-0">
        <div class="row g-2">
            <div class="col-12">
                <a href="{{ route('solar-plant-requests.battery.my-batteries') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-arrow-right"></i>
                    بازگشت به لیست باتری‌ها
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ثبت باتری جدید</h3>
        </div>
        <div class="card-body">
            @include('solar-plant-requests::batteries.add-battery')
        </div>
    </div>
@endsection
