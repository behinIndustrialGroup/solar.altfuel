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
                <h5 class="mb-0">جدول باتری‌ها</h5>
                <a href="{{ route('battery-catalog.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i> افزودن باتری جدید
                </a>
            </div>
            <div class="card-body">
                @if($batteries->isEmpty())
                    <div class="alert alert-info">هیچ باتری‌ای یافت نشد.</div>
                @else
                    <div class="table-responsive">
                        <table id="batteriesTable" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>برند</th>
                                    <th>سازنده</th>
                                    <th>کشور</th>
                                    <th>نام مدل</th>
                                    <th>کد مدل</th>
                                    <th>نوع باتری</th>
                                    <th>ظرفیت (kWh)</th>
                                    <th>ظرفیت (Ah)</th>
                                    <th>ولتاژ نامی</th>
                                    <th>جریان شارژ</th>
                                    <th>جریان دشارژ</th>
                                    <th>سیکل عمر</th>
                                    <th>DOD %</th>
                                    <th>قابل توسعه</th>
                                    <th>حداکثر موازی</th>
                                    <th>IP Rating</th>
                                    <th>پروتکل‌ها</th>
                                    <th>ابعاد</th>
                                    <th>وزن</th>
                                    <th>گارانتی</th>
                                    <th>استانداردها</th>
                                    <th>تایید آزمایشگاه</th>
                                    <th>نام آزمایشگاه</th>
                                    <th>تایید اتحادیه</th>
                                    <th>تاریخ تایید</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($batteries as $battery)
                                    <tr>
                                        <td>{{ $loop->iteration + ($batteries->currentPage() - 1) * $batteries->perPage() }}</td>
                                        <td>{{ $battery->brand }}</td>
                                        <td>{{ $battery->manufacture }}</td>
                                        <td>{{ $battery->country_of_manufacture }}</td>
                                        <td>{{ $battery->model_name }}</td>
                                        <td>{{ $battery->model_code }}</td>
                                        <td><span class="badge badge-info">{{ $battery->battery_type }}</span></td>
                                        <td>{{ $battery->energy_capacity_kwh }} kWh</td>
                                        <td>{{ $battery->capacity_ah }} Ah</td>
                                        <td>{{ $battery->nominal_voltage }} V</td>
                                        <td>{{ $battery->max_charge_current }} A</td>
                                        <td>{{ $battery->max_discharge_current }} A</td>
                                        <td>{{ number_format($battery->cycle_life) }}</td>
                                        <td>{{ $battery->depth_of_discharge }}%</td>
                                        <td>{!! $battery->expandable ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                        <td>{{ $battery->max_parallel_units ?? '-' }}</td>
                                        <td>{{ $battery->ip_rating }}</td>
                                        <td>
                                            @if($battery->communication_protocols)
                                                @foreach($battery->communication_protocols as $protocol)
                                                    <span class="badge badge-primary">{{ $protocol }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $battery->dimensions }}</td>
                                        <td>{{ $battery->weight }} kg</td>
                                        <td>{{ $battery->warranty_years }} سال</td>
                                        <td>
                                            @if($battery->standards)
                                                @foreach($battery->standards as $standard)
                                                    <span class="badge badge-secondary">{{ $standard }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($battery->lab_certified)
                                                <span class="badge badge-success">دارد</span>
                                            @else
                                                <span class="badge badge-danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td>{{ $battery->lab_name ?? '-' }}</td>
                                        <td>
                                            @if($battery->union_approved)
                                                <span class="badge badge-success">تایید شده</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $battery->union_approval_date ? toJalaliFormatted($battery->union_approval_date, 'Y/m/d') : '-' }}</td>
                                        <td>{{ jdate($battery->created_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('battery-catalog.show', $battery) }}" class="btn btn-sm btn-info" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('battery-catalog.edit', $battery) }}" class="btn btn-sm btn-warning" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('battery-catalog.destroy', $battery) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این باتری اطمینان دارید؟');">
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
                        {{ $batteries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#batteriesTable').DataTable({
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
