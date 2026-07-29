@extends('behin-layouts.app')

@php
    $disableBackBtn = false;
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            @if (auth()->user()->role_id == 1)
                <div class="col-sm-3 ">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('درخواست ها') }}</h6>

                            <p>{{ trans('مراحل تخصیص پیمانکار و ثبت بازرسی') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.all-requests.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h6>{{ trans('کاتالوگ پنل') }}</h6>
                            <p>{{ trans('مدیریت و مشاهده مشخصات فنی پنل‌ها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-solar_power"></i>
                        </div>
                        <a href="{{ route('panel-catalog.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h6>{{ trans('کاتالوگ اینورتر') }}</h6>
                            <p>{{ trans('مدیریت و مشاهده مشخصات فنی اینورترها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-flash"></i>
                        </div>
                        <a href="{{ route('inverter-catalog.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h6>{{ trans('کاتالوگ باتری') }}</h6>
                            <p>{{ trans('مدیریت و مشاهده مشخصات فنی باتری‌ها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-battery-full"></i>
                        </div>
                        <a href="{{ route('battery-catalog.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h6>{{ trans('کاتالوگ پیمانکار') }}</h6>
                            <p>{{ trans('مدیریت و مشاهده اطلاعات پیمانکاران') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                        <a href="{{ route('contractor-catalog.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                                <div class="col-sm-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h6>{{ trans('کاتالوگ بازرسها') }}</h6>
                            <p>{{ trans('مدیریت و مشاهده اطلاعات بازرسها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                        <a href="{{ route('inspector-catalog.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="small-box bg-teal" style="background-color:#00897b!important;">
                        <div class="inner">
                            <h6>{{ trans('پروژه‌های نیروگاه') }}</h6>
                            <p>{{ trans('مدیریت پروژه‌ها، تجهیزات نصب‌شده و تخصیص بازرس') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-sunny"></i>
                        </div>
                        <a href="{{ route('solar-plant-equipment.projects.index') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endauth
            @if (auth()->user()->role_id == 3)
                <!-- <div class="col-sm-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('احداث نیروگاه') }}</h6>
                            <p>{{ trans('ثبت درخواست جدید') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.apply') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div> -->
                <div class="col-sm-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h6>{{ trans('درخواست‌های من') }}</h6>
                            <p>{{ trans('پیگیری وضعیت درخواست‌ها و ثبت درخواست جدید') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
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
                <div class="col-sm-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('پنل') }}</h6>
                            <p>{{ trans('لیست پنل‌ها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.panel.my-panels') }}" class="small-box-footer">
                            {{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            @endauth
            @if (auth()->user()->role_id == 7)
                    <div class="col-sm-3 ">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h6>{{ trans('اینورتر') }}</h6>

                                <p>{{ trans('افزودن اینورتر جدید') }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('solar-plant-requests.inverter.create') }}"
                                class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h6>{{ trans('اینورتر') }}</h6>
                                <p>{{ trans('لیست اینورترها') }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('solar-plant-requests.inverter.my-inverters') }}" class="small-box-footer">
                                {{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
            @endauth
            @if (auth()->user()->role_id == 8)
                <div class="col-sm-3 ">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('باتری') }}</h6>

                            <p>{{ trans('افزودن باتری جدید') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.battery.create') }}"
                            class="small-box-footer">{{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h6>{{ trans('باتری') }}</h6>
                            <p>{{ trans('لیست باتریها') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('solar-plant-requests.battery.my-batteries') }}" class="small-box-footer">
                            {{ trans('مشاهده') }} <i class="fa fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
