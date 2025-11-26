@extends('behin-layouts.app')

@php
    $disableBackBtn = false;
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            @if (auth()->user()->role_id == 3)
                <div class="col-sm-3 ">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('احداث نیروگاه') }}</h6>

                            <p>{{ trans('ثبت درخواست جدید') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endauth
            @if (auth()->user()->role_id == 5)
                <div class="col-sm-3 ">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('درخواست ها') }}</h6>

                            <p>{{ trans('در مرحله نصب تجهیزات') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.contractor.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endauth
            @if (auth()->user()->role_id == 6)
                <div class="col-sm-3 ">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('پنل') }}</h6>

                            <p>{{ trans('افزودن پنل جدید') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.panel.create') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endauth
            @if (auth()->user()->role_id == 6)
                <div class="col-sm-3 ">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('پنل') }}</h6>

                            <p>{{ trans('لیست پنل ها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.panel.my-panels') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
