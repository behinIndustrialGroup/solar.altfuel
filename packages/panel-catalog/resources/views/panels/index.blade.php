@extends('behin-layouts.app')

@section('content')
    <style>
        :root {
            --solar-primary: #FF9800;
            --solar-gradient-start: #FFB74D;
            --solar-gradient-end: #FF9800;
            --solar-header-bg: #FFF3E0;
            --solar-card-radius: 12px;
        }

        * {
            direction: rtl;
        }

        .solar-card {
            border-radius: var(--solar-card-radius);
            box-shadow: 0 4px 20px rgba(255, 152, 0, 0.08);
            border: none;
            overflow: hidden;
        }

        .solar-card-header {
            background: linear-gradient(135deg, var(--solar-gradient-start) 0%, var(--solar-gradient-end) 100%);
            color: white;
            border: none;
            padding: 1.25rem 1.5rem;
        }

        .solar-btn-white {
            background: white;
            color: var(--solar-primary);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .solar-btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: var(--solar-primary);
        }

        .summary-card {
            border-radius: var(--solar-card-radius);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: none;
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .summary-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .icon-orange { background: linear-gradient(135deg, #FFE0B2, #FFCC80); color: #E65100; }
        .icon-green { background: linear-gradient(135deg, #C8E6C9, #A5D6A7); color: #2E7D32; }
        .icon-blue { background: linear-gradient(135deg, #BBDEFB, #90CAF9); color: #1565C0; }
        .icon-purple { background: linear-gradient(135deg, #E1BEE7, #CE93D8); color: #6A1B9A; }

        .summary-number {
            font-size: 2rem;
            font-weight: 700;
            color: #37474F;
            margin: 0;
            line-height: 1.2;
        }

        .summary-label {
            font-size: 0.9rem;
            color: #78909C;
            margin: 0.25rem 0 0 0;
        }

        #panelsTable {
            border-collapse: separate;
            border-spacing: 0;
        }

        #panelsTable thead tr th {
            background: var(--solar-header-bg) !important;
            color: #E65100;
            font-weight: 700;
            border: none;
            padding: 14px 12px;
            white-space: nowrap;
            border-bottom: 2px solid #FFE0B2;
        }

        #panelsTable tbody tr td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #F5F5F5;
        }

        #panelsTable tbody tr:hover {
            background-color: #FFF8E1;
        }

        #panelsTable tbody tr:last-child td {
            border-bottom: none;
        }

        .solar-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }

        .badge-approved {
            background: linear-gradient(135deg, #66BB6A, #43A047);
            color: white;
        }

        .badge-pending {
            background: linear-gradient(135deg, #FFB74D, #FF9800);
            color: white;
        }

        .badge-rejected {
            background: linear-gradient(135deg, #EF5350, #E53935);
            color: white;
        }

        .badge-has {
            background: linear-gradient(135deg, #81C784, #66BB6A);
            color: white;
        }

        .badge-no {
            background: linear-gradient(135deg, #E57373, #EF5350);
            color: white;
        }

        .badge-neutral {
            background: linear-gradient(135deg, #E0E0E0, #BDBDBD);
            color: #424242;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            margin: 0 2px;
        }

        .action-btn-edit {
            background: linear-gradient(135deg, #64B5F6, #42A5F5);
            color: white;
        }

        .action-btn-delete {
            background: linear-gradient(135deg, #EF9A9A, #E57373);
            color: white;
        }

        .action-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 96px;
            color: #FFB74D;
            margin-bottom: 1.5rem;
            display: block;
            opacity: 0.8;
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #546E7A;
            margin-bottom: 0.5rem;
        }

        .empty-state-desc {
            color: #90A4AE;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #FFE0B2;
            border-radius: 8px;
            padding: 6px 12px;
            margin: 0 8px;
        }

        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            outline: none;
            border-color: var(--solar-primary);
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
        }

        .dataTables_wrapper .paginate_button {
            border-radius: 8px !important;
            margin: 0 3px !important;
            border: none !important;
        }

        .dataTables_wrapper .paginate_button.current {
            background: linear-gradient(135deg, var(--solar-gradient-start), var(--solar-gradient-end)) !important;
            color: white !important;
            border: none !important;
        }

        .alert-solar-success {
            background: linear-gradient(135deg, #C8E6C9, #A5D6A7);
            border: none;
            border-right: 5px solid #2E7D32;
            border-radius: 10px;
            color: #1B5E20;
            font-weight: 500;
        }

        .alert-solar-danger {
            background: linear-gradient(135deg, #FFCDD2, #EF9A9A);
            border: none;
            border-right: 5px solid #C62828;
            border-radius: 10px;
            color: #B71C1C;
            font-weight: 500;
        }

        .table-wrapper {
            border-radius: var(--solar-card-radius);
            overflow: hidden;
            border: 1px solid #F5F5F5;
        }
    </style>

    <div class="container-fluid py-4">
        @if (session()->has('success'))
            <div class="alert alert-solar-success mb-4">
                <i class="fa fa-check-circle ms-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-solar-danger mb-4">
                <i class="fa fa-exclamation-circle ms-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="card solar-card mb-4">
            <div class="card-header solar-card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <i class="fa fa-sun-o ms-3" style="font-size: 28px;"></i>
                    <h3 class="mb-0 fw-bold">کاتالوگ پنل‌های خورشیدی</h3>
                </div>
                <a href="{{ route('panel-catalog.create') }}" class="solar-btn-white">
                    <i class="fa fa-plus ms-1"></i> افزودن پنل جدید
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row g-4 mb-4">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="summary-card d-flex align-items-center">
                            <div class="summary-icon-wrap icon-orange ms-3 flex-shrink-0">
                                <i class="fa fa-solar-panel"></i>
                            </div>
                            <div>
                                <h4 class="summary-number">{{ $panels->count() }}</h4>
                                <p class="summary-label">کل پنل‌ها</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="summary-card d-flex align-items-center">
                            <div class="summary-icon-wrap icon-green ms-3 flex-shrink-0">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div>
                                <h4 class="summary-number">{{ $panels->where('union_approval_status', 'union-approved')->count() }}</h4>
                                <p class="summary-label">تایید اتحادیه</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="summary-card d-flex align-items-center">
                            <div class="summary-icon-wrap icon-blue ms-3 flex-shrink-0">
                                <i class="fa fa-flask"></i>
                            </div>
                            <div>
                                <h4 class="summary-number">{{ $panels->where('lab_certified', true)->count() }}</h4>
                                <p class="summary-label">تایید آزمایشگاه</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="summary-card d-flex align-items-center">
                            <div class="summary-icon-wrap icon-purple ms-3 flex-shrink-0">
                                <i class="fa fa-tags"></i>
                            </div>
                            <div>
                                <h4 class="summary-number">{{ $panels->unique('brand')->count() }}</h4>
                                <p class="summary-label">برندهای مختلف</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($panels->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-sun-o empty-state-icon"></i>
                        <h4 class="empty-state-title">هنوز پنلی ثبت نشده است</h4>
                        <p class="empty-state-desc">برای شروع، اولین پنل خورشیدی خود را به کاتالوگ اضافه کنید.</p>
                        <a href="{{ route('panel-catalog.create') }}" class="btn solar-btn-white" style="background: linear-gradient(135deg, #FFB74D, #FF9800); color: white;">
                            <i class="fa fa-plus ms-1"></i> افزودن پنل جدید
                        </a>
                    </div>
                @else
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table id="panelsTable" class="table table-hover" style="width:100%">
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
                                        <th>عملیات</th>
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
                                                    <span class="solar-badge badge-has"><i class="fa fa-check ms-1"></i>دارد</span>
                                                @else
                                                    <span class="solar-badge badge-no"><i class="fa fa-times ms-1"></i>ندارد</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($panel->iec_61730)
                                                    <span class="solar-badge badge-has"><i class="fa fa-check ms-1"></i>دارد</span>
                                                @else
                                                    <span class="solar-badge badge-no"><i class="fa fa-times ms-1"></i>ندارد</span>
                                                @endif
                                            </td>
                                            <td>{{ $panel->connector_type }}</td>
                                            <td>{{ $panel->dimensions }}</td>
                                            <td>{{ $panel->weight }}</td>
                                            <td>{{ $panel->datasheet_version }}</td>
                                            <td>
                                                @if($panel->union_approval_status === 'union-approved')
                                                    <span class="solar-badge badge-approved"><i class="fa fa-check-circle ms-1"></i>تایید شده</span>
                                                @elseif($panel->union_approval_status && $panel->union_approval_status !== '-')
                                                    <span class="solar-badge badge-pending"><i class="fa fa-clock-o ms-1"></i>{{ $panel->union_approval_status }}</span>
                                                @else
                                                    <span class="solar-badge badge-neutral"><i class="fa fa-minus-circle ms-1"></i>نامشخص</span>
                                                @endif
                                            </td>
                                            <td>{{ $panel->production_date ? toJalaliFormatted($panel->production_date, 'Y/m/d') : '' }}</td>
                                            <td>{{ $panel->discontinuation_date ? toJalaliFormatted($panel->discontinuation_date, 'Y/m/d') : '' }}</td>
                                            <td>
                                                @if($panel->lab_certified)
                                                    <span class="solar-badge badge-has"><i class="fa fa-check ms-1"></i>دارد</span>
                                                @else
                                                    <span class="solar-badge badge-no"><i class="fa fa-times ms-1"></i>ندارد</span>
                                                @endif
                                            </td>
                                            <td>{{ $panel->lab_name }}</td>
                                            <td>{{ jdate($panel->created_at)->format('Y/m/d H:i') }}</td>
                                            <td>
                                                <form action="{{ route('panel-catalog.destroy', $panel->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این پنل اطمینان دارید؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn action-btn-delete" title="حذف">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
