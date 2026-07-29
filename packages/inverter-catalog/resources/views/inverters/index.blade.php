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
                <h5 class="mb-0">جدول اینورترها</h5>
                <a href="{{ route('inverter-catalog.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i> افزودن اینورتر جدید
                </a>
            </div>
            <div class="card-body">
                @if($inverters->isEmpty())
                    <div class="alert alert-info">هیچ اینورتری یافت نشد.</div>
                @else
                    <div class="table-responsive">
                        <table id="invertersTable" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>برند</th>
                                    <th>سازنده</th>
                                    <th>کشور</th>
                                    <th>نام مدل</th>
                                    <th>کد مدل</th>
                                    <th>نوع</th>
                                    <th>توان نامی (kW)</th>
                                    <th>تعداد MPPT</th>
                                    <th>ورودی/MPPT</th>
                                    <th>حداکثر ولتاژ DC</th>
                                    <th>حداکثر جریان ورودی</th>
                                    <th>حداکثر جریان خروجی</th>
                                    <th>ولتاژ خروجی AC</th>
                                    <th>فرکانس خروجی</th>
                                    <th>حداکثر راندمان</th>
                                    <th>درجه حفاظت</th>
                                    <th>خنک سازی</th>
                                    <th>کلید DC</th>
                                    <th>کلید AC</th>
                                    <th>حفاظت پلاریته</th>
                                    <th>نمایشگر</th>
                                    <th>ضد جزیره‌ای</th>
                                    <th>حفاظت نشتی</th>
                                    <th>SPD</th>
                                    <th>THD</th>
                                    <th>محدوده MPP</th>
                                    <th>حداکثر PV</th>
                                    <th>مدت گارانتی</th>
                                    <th>استانداردها</th>
                                    <th>پروتکل‌ها</th>
                                    <th>تاییدیه آزمایشگاه</th>
                                    <th>نام آزمایشگاه</th>
                                    <th>تایید اتحادیه</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inverters as $inverter)
                                    <tr>
                                        <td>{{ $loop->iteration + ($inverters->currentPage() - 1) * $inverters->perPage() }}</td>
                                        <td>{{ $inverter->brand }}</td>
                                        <td>{{ $inverter->manufacture }}</td>
                                        <td>{{ $inverter->country_of_manufacture }}</td>
                                        <td>{{ $inverter->model_name }}</td>
                                        <td>{{ $inverter->model_code }}</td>
                                        <td><span class="badge badge-info">{{ $inverter->inverter_type }}</span></td>
                                        <td>{{ $inverter->rated_power_kw }}</td>
                                        <td>{{ $inverter->mppt_count }}</td>
                                        <td>{{ $inverter->strings_per_mppt }}</td>
                                        <td>{{ $inverter->max_dc_input_voltage }} V</td>
                                        <td>{{ $inverter->max_input_current }} A</td>
                                        <td>{{ $inverter->max_output_current }} A</td>
                                        <td>{{ $inverter->output_voltage }} V</td>
                                        <td>{{ $inverter->output_frequency }} Hz</td>
                                        <td>{{ $inverter->max_efficiency }}%</td>
                                        <td>{{ $inverter->protection_level }}</td>
                                        <td>{{ $inverter->cooling_type ?? '-' }}</td>
                                        <td>{!! $inverter->dc_switch ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $inverter->ac_switch ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $inverter->reverse_polarity_protection ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $inverter->display ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $inverter->anti_islanding_protection ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $inverter->leakage_current_protection ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $inverter->spd_type ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{{ $inverter->thd ?? '-' }}</td>
                                        <td>{{ $inverter->mpp_voltage_range }}</td>
                                        <td>{{ $inverter->max_pv_input_power }} kW</td>
                                        <td>{{ $inverter->warranty_period }}</td>
                                        <td>
                                            @if($inverter->standards)
                                                @foreach($inverter->standards as $standard)
                                                    <span class="badge badge-secondary">{{ $standard }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($inverter->communication_protocols)
                                                @foreach($inverter->communication_protocols as $protocol)
                                                    <span class="badge badge-primary">{{ $protocol }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($inverter->lab_certified)
                                                <span class="badge badge-success">دارد</span>
                                            @else
                                                <span class="badge badge-danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td>{{ $inverter->lab_name ?? '-' }}</td>
                                        <td>
                                            @if($inverter->union_approved)
                                                <span class="badge badge-success">تایید شده</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ jdate($inverter->created_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('inverter-catalog.show', $inverter) }}" class="btn btn-sm btn-info" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('inverter-catalog.edit', $inverter) }}" class="btn btn-sm btn-warning" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('inverter-catalog.destroy', $inverter) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این اینورتر اطمینان دارید؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">
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
                    <div class="mt-3">
                        {{ $inverters->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#invertersTable').DataTable({
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
