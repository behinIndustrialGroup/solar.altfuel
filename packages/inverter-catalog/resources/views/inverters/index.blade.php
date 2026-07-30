@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card rounded-4 border-0 shadow mb-4 overflow-hidden">
            <div class="card-header py-4 px-4 border-0" style="background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%);">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                            <i class="fa fa-bolt fa-2x text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white fw-bold">کاتالوگ اینورترها</h3>
                            <p class="mb-0 text-white text-opacity-90 small mt-1">مدیریت و مشاهده لیست کامل اینورترهای خورشیدی</p>
                        </div>
                    </div>
                    <a href="{{ route('inverter-catalog.create') }}" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm fw-bold" style="color: #E65100;">
                        <i class="fa fa-plus ms-2"></i> افزودن اینورتر جدید
                    </a>
                </div>
            </div>
        </div>

        @php
            $totalInverters = $inverters->total();
            $unionApproved = \Packages\InverterCatalog\Models\Inverter::where('union_approved', 1)->count();
            $labCertified = \Packages\InverterCatalog\Models\Inverter::where('lab_certified', 1)->count();
            $uniqueBrands = \Packages\InverterCatalog\Models\Inverter::distinct()->count('brand');
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card rounded-4 border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-medium">کل اینورترها</p>
                                <h2 class="mb-0 fw-bold" style="color: #E65100;">{{ $totalInverters }}</h2>
                            </div>
                            <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #FFE0B2 0%, #FFCC80 100%);">
                                <i class="fa fa-solar-panel fa-2x" style="color: #EF6C00;"></i>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-success fw-medium"><i class="fa fa-arrow-up me-1"></i> {{ $inverters->count() }} رکورد در این صفحه</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card rounded-4 border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-medium">تایید اتحادیه</p>
                                <h2 class="mb-0 fw-bold text-success">{{ $unionApproved }}</h2>
                            </div>
                            <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #C8E6C9 0%, #A5D6A7 100%);">
                                <i class="fa fa-shield-check fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            @if($totalInverters > 0)
                                <small class="text-muted fw-medium">درصد: {{ round(($unionApproved / $totalInverters) * 100, 1) }}%</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card rounded-4 border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-medium">تایید آزمایشگاه</p>
                                <h2 class="mb-0 fw-bold" style="color: #1976D2;">{{ $labCertified }}</h2>
                            </div>
                            <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #BBDEFB 0%, #90CAF9 100%);">
                                <i class="fa fa-flask-vial fa-2x" style="color: #1565C0;"></i>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            @if($totalInverters > 0)
                                <small class="text-muted fw-medium">درصد: {{ round(($labCertified / $totalInverters) * 100, 1) }}%</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card rounded-4 border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-medium">برندهای مختلف</p>
                                <h2 class="mb-0 fw-bold" style="color: #7B1FA2;">{{ $uniqueBrands }}</h2>
                            </div>
                            <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #E1BEE7 0%, #CE93D8 100%);">
                                <i class="fa fa-layer-group fa-2x" style="color: #6A1B9A;"></i>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted fw-medium"><i class="fa fa-tags me-1"></i> برند فعال در سیستم</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card rounded-4 border-0 shadow overflow-hidden">
            <div class="card-body p-0">
                @if($inverters->isEmpty())
                    <div class="text-center py-5 px-4">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 120px; height: 120px; background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);">
                                <i class="fa fa-inbox fa-4x" style="color: #FF9800;"></i>
                            </div>
                        </div>
                        <h4 class="mb-2 fw-bold" style="color: #E65100;">هیچ اینورتری یافت نشد</h4>
                        <p class="text-muted mb-4">شما هنوز هیچ اینورتری در کاتالوگ ثبت نکرده‌اید.</p>
                        <a href="{{ route('inverter-catalog.create') }}" class="btn btn-lg rounded-pill px-5 fw-bold" style="background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%); color: white; border: none;">
                            <i class="fa fa-plus ms-2"></i> ثبت اولین اینورتر
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table id="invertersTable" class="table table-bordered table-hover mb-0" style="width:100%">
                            <thead>
                                <tr style="background: #FFF3E0;">
                                    <th class="text-center py-3 px-3 border-0 fw-bold" style="color: #E65100;">#</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">برند</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">سازنده</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">کشور</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">نام مدل</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">کد مدل</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">نوع</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">توان نامی (kW)</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">تعداد MPPT</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">ورودی/MPPT</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حداکثر ولتاژ DC</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حداکثر جریان ورودی</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حداکثر جریان خروجی</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">ولتاژ خروجی AC</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">فرکانس خروجی</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حداکثر راندمان</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">درجه حفاظت</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">خنک سازی</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">کلید DC</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">کلید AC</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حفاظت پلاریته</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">نمایشگر</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">ضد جزیره‌ای</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حفاظت نشتی</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">SPD</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">THD</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">محدوده MPP</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">حداکثر PV</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">مدت گارانتی</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">استانداردها</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">پروتکل‌ها</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">تاییدیه آزمایشگاه</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">نام آزمایشگاه</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">تایید اتحادیه</th>
                                    <th class="py-3 px-3 border-0 fw-bold" style="color: #E65100;">تاریخ ثبت</th>
                                    <th class="text-center py-3 px-3 border-0 fw-bold" style="color: #E65100;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inverters as $inverter)
                                    <tr class="align-middle">
                                        <td class="text-center">{{ $loop->iteration + ($inverters->currentPage() - 1) * $inverters->perPage() }}</td>
                                        <td class="fw-medium">{{ $inverter->brand }}</td>
                                        <td>{{ $inverter->manufacture }}</td>
                                        <td>{{ $inverter->country_of_manufacture }}</td>
                                        <td class="fw-medium">{{ $inverter->model_name }}</td>
                                        <td><code class="bg-light px-2 py-1 rounded">{{ $inverter->model_code }}</code></td>
                                        <td><span class="badge rounded-pill" style="background: #FFF3E0; color: #E65100;">{{ $inverter->inverter_type }}</span></td>
                                        <td class="fw-medium text-center">{{ $inverter->rated_power_kw }}</td>
                                        <td class="text-center">{{ $inverter->mppt_count }}</td>
                                        <td class="text-center">{{ $inverter->strings_per_mppt }}</td>
                                        <td>{{ $inverter->max_dc_input_voltage }} V</td>
                                        <td>{{ $inverter->max_input_current }} A</td>
                                        <td>{{ $inverter->max_output_current }} A</td>
                                        <td>{{ $inverter->output_voltage }} V</td>
                                        <td>{{ $inverter->output_frequency }} Hz</td>
                                        <td class="fw-medium text-success">{{ $inverter->max_efficiency }}%</td>
                                        <td><span class="badge rounded-pill bg-info text-white">{{ $inverter->protection_level }}</span></td>
                                        <td>{{ $inverter->cooling_type ?? '-' }}</td>
                                        <td class="text-center">{!! $inverter->dc_switch ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td class="text-center">{!! $inverter->ac_switch ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td class="text-center">{!! $inverter->reverse_polarity_protection ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td class="text-center">{!! $inverter->display ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td class="text-center">{!! $inverter->anti_islanding_protection ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td class="text-center">{!! $inverter->leakage_current_protection ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td class="text-center">{!! $inverter->spd_type ? '<i class="fa fa-check-circle text-success fa-lg"></i>' : '<i class="fa fa-times-circle text-danger fa-lg"></i>' !!}</td>
                                        <td>{{ $inverter->thd ?? '-' }}</td>
                                        <td>{{ $inverter->mpp_voltage_range }}</td>
                                        <td>{{ $inverter->max_pv_input_power }} kW</td>
                                        <td><span class="badge rounded-pill bg-secondary">{{ $inverter->warranty_period }}</span></td>
                                        <td>
                                            @if($inverter->standards)
                                                @foreach($inverter->standards as $standard)
                                                    <span class="badge rounded-pill bg-light text-dark border me-1 mb-1">{{ $standard }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($inverter->communication_protocols)
                                                @foreach($inverter->communication_protocols as $protocol)
                                                    <span class="badge rounded-pill me-1 mb-1" style="background: #E3F2FD; color: #1565C0;">{{ $protocol }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($inverter->lab_certified)
                                                <span class="badge rounded-pill bg-success">دارد</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td>{{ $inverter->lab_name ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($inverter->union_approved)
                                                <span class="badge rounded-pill bg-success"><i class="fa fa-check me-1"></i>تایید شده</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ jdate($inverter->created_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('inverter-catalog.show', $inverter) }}" class="btn btn-sm rounded-circle shadow-sm" title="مشاهده" style="width: 36px; height: 36px; background: linear-gradient(135deg, #29B6F6 0%, #0288D1 100%); color: white; border: none;" data-bs-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('inverter-catalog.edit', $inverter) }}" class="btn btn-sm rounded-circle shadow-sm" title="ویرایش" style="width: 36px; height: 36px; background: linear-gradient(135deg, #FFD54F 0%, #FFA000 100%); color: white; border: none;" data-bs-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('inverter-catalog.destroy', $inverter) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این اینورتر اطمینان دارید؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm rounded-circle shadow-sm" title="حذف" style="width: 36px; height: 36px; background: linear-gradient(135deg, #EF5350 0%, #D32F2F 100%); color: white; border: none;" data-bs-toggle="tooltip">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-top bg-light bg-opacity-25">
                        {{ $inverters->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <style>
        #invertersTable thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        #invertersTable tbody tr:hover {
            background-color: #FFF8E1 !important;
            transition: all 0.2s ease;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%) !important;
            color: white !important;
            border: none !important;
            border-radius: 8px;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 20px;
            padding: 6px 16px;
            border: 1px solid #FFCC80;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #FF9800;
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.15);
        }
    </style>
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            $('#invertersTable').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
