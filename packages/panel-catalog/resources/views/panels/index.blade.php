@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">جدول پنل‌ها</h5>
                <a href="{{ route('panel-catalog.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i> افزودن پنل جدید
                </a>
            </div>
            <div class="card-body">
                @if($panels->isEmpty())
                    <div class="alert alert-info">هیچ پنلی یافت نشد.</div>
                @else
                    <div class="table-responsive">
                        <table id="panelsTable" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>برند</th>
                                    <th>سازنده</th>
                                    <th>کشور</th>
                                    <th>مدل</th>
                                    <th>کد مدل</th>
                                    <th>تکنولوژی</th>
                                    <th>نوع</th>
                                    <th>توان (Wp)</th>
                                    <th>راندمان (%)</th>
                                    <th>تعداد سلول</th>
                                    <th>نوع سلول</th>
                                    <th>Voc</th>
                                    <th>Isc</th>
                                    <th>Vmp</th>
                                    <th>Imp</th>
                                    <th>حداکثر ولتاژ سیستم</th>
                                    <th>ضریب دمایی</th>
                                    <th>تلرانس توان</th>
                                    <th>گارانتی محصول</th>
                                    <th>گارانتی عملکرد</th>
                                    <th>IEC 61215</th>
                                    <th>IEC 61730</th>
                                    <th>نوع کانکتور</th>
                                    <th>ابعاد</th>
                                    <th>وزن</th>
                                    <th>نسخه دیتاشیت</th>
                                    <th>وضعیت اتحادیه</th>
                                    <th>تاریخ تولید</th>
                                    <th>تاریخ توقف تولید</th>
                                    <th>تاییدیه آزمایشگاه</th>
                                    <th>نام آزمایشگاه</th>
                                    <th>تاریخ ثبت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($panels as $panel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $panel->brand }}</td>
                                        <td>{{ $panel->manufacture }}</td>
                                        <td>{{ $panel->country_of_manufacture }}</td>
                                        <td>{{ $panel->model }}</td>
                                        <td>{{ $panel->model_code }}</td>
                                        <td>{{ $panel->technology }}</td>
                                        <td>{{ $panel->panel_type }}</td>
                                        <td>{{ $panel->rated_power_wp }}</td>
                                        <td>{{ $panel->module_efficiency }}</td>
                                        <td>{{ $panel->number_of_cells }}</td>
                                        <td>{{ $panel->cell_type }}</td>
                                        <td>{{ $panel->voc }}</td>
                                        <td>{{ $panel->isc }}</td>
                                        <td>{{ $panel->vmp }}</td>
                                        <td>{{ $panel->imp }}</td>
                                        <td>{{ $panel->max_system_voltage }}</td>
                                        <td>{{ $panel->temperature_coefficient }}</td>
                                        <td>{{ $panel->power_tolerance }}</td>
                                        <td>{{ $panel->product_warranty }}</td>
                                        <td>{{ $panel->performance_warranty }}</td>
                                        <td>
                                            @if($panel->iec_61215)
                                                <span class="badge badge-success">دارد</span>
                                            @else
                                                <span class="badge badge-danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($panel->iec_61730)
                                                <span class="badge badge-success">دارد</span>
                                            @else
                                                <span class="badge badge-danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td>{{ $panel->connector_type }}</td>
                                        <td>{{ $panel->dimensions }}</td>
                                        <td>{{ $panel->weight }}</td>
                                        <td>{{ $panel->datasheet_version }}</td>
                                        <td>
                                            @if($panel->union_approval_status === 'union-approved')
                                                <span class="badge badge-success">تایید شده</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $panel->union_approval_status ?? '-' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $panel->production_date ? toJalaliFormatted($panel->production_date, 'Y/m/d') : '' }}</td>
                                        <td>{{ $panel->discontinuation_date ? toJalaliFormatted($panel->discontinuation_date, 'Y/m/d') : '' }}</td>
                                        <td>
                                            @if($panel->lab_certified)
                                                <span class="badge badge-success">دارد</span>
                                            @else
                                                <span class="badge badge-danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td>{{ $panel->lab_name }}</td>
                                        <td>{{ jdate($panel->created_at)->format('Y/m/d H:i') }}</td>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#panelsTable').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                language: {
                    search: "جستجو:",
                    lengthMenu: "نمایش _MENU_ رکورد",
                    info: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                    paginate: {
                        first: "اول",
                        last: "آخر",
                        next: "بعدی",
                        previous: "قبلی"
                    },
                    emptyTable: "هیچ داده‌ای موجود نیست"
                }
            });
        });
    </script>
@endsection
