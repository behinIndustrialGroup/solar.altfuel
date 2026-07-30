@extends('behin-layouts.app')

@section('content')
    <div class="container-fluid" style="direction: rtl; text-align: right;">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #C8E6C9 0%, #A5D6A7 100%); color: #1B5E20;">
                <i class="fa fa-check-circle ms-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="float: left;"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #FFCDD2 0%, #EF9A9A 100%); color: #B71C1C;">
                <i class="fa fa-exclamation-circle ms-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="float: left;"></button>
            </div>
        @endif

        <div class="mb-4 p-4 text-white" style="background: linear-gradient(135deg, #4DB6AC 0%, #26A69A 100%); border-radius: 12px; box-shadow: 0 4px 20px rgba(38, 166, 154, 0.25);">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1 fw-bold"><i class="fa fa-user-check ms-2"></i>کاتالوگ بازرس‌ها</h3>
                    <p class="mb-0 opacity-90">مدیریت بازرسان کنترل کیفیت و نظارت بر پروژه‌ها</p>
                </div>
                <a href="{{ route('inspector-catalog.create') }}" class="btn btn-light btn-lg" style="border-radius: 12px; color: #00695C; font-weight: 600; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <i class="fa fa-plus ms-1"></i> افزودن بازرس جدید
                </a>
            </div>
        </div>

        @php
            $totalInspectors = $inspectors->total();
            $activeCount = 0;
            $totalProjects = 0;
            $coveredCities = collect();
            foreach($inspectors as $i) {
                $activeCount++;
                $coveredCities->push($i->city);
            }
            $coveredCities = $coveredCities->unique()->count();
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 152, 0, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">کل بازرس‌ها</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalInspectors }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-users" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #81C784 0%, #4CAF50 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">بازرس فعال</h6>
                            <h2 class="mb-0 fw-bold">{{ $activeCount }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-user-check" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #4DB6AC 0%, #26A69A 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(38, 166, 154, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">پروژه‌های اختصاص‌یافته</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalProjects }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-project-diagram" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #9575CD 0%, #673AB7 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(103, 58, 183, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">شهرهای تحت پوشش</h6>
                            <h2 class="mb-0 fw-bold">{{ $coveredCities }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-city" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <div class="card-body p-0">
                @if($inspectors->isEmpty())
                    <div class="text-center py-5 px-4">
                        <div style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #E0F2F1 0%, #B2DFDB 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-user-shield" style="font-size: 42px; color: #26A69A;"></i>
                        </div>
                        <h5 class="mb-2 fw-bold" style="color: #004D40;">هنوز بازرسی ثبت نشده است</h5>
                        <p class="text-muted mb-4">با کلیک روی دکمه زیر، اولین بازرس کنترل کیفیت را ثبت کنید</p>
                        <a href="{{ route('inspector-catalog.create') }}" class="btn text-white" style="background: linear-gradient(135deg, #4DB6AC 0%, #26A69A 100%); border-radius: 12px; font-weight: 600;">
                            <i class="fa fa-plus ms-1"></i> ثبت بازرس اول
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table id="inspectorsTable" class="table table-hover mb-0" style="width:100%; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr style="background: #FFF3E0;">
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">#</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">نام و نام خانوادگی</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">کد ملی</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">شماره تماس</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">گواهی صلاحیت</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">استان/شهر</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">وضعیت</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">تاریخ ثبت</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inspectors as $inspector)
                                    <tr style="border-bottom: 1px solid #F5F5F5; transition: all 0.2s;">
                                        <td style="padding: 14px 16px; vertical-align: middle;">{{ $loop->iteration + ($inspectors->currentPage() - 1) * $inspectors->perPage() }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #E0F2F1 0%, #B2DFDB 100%); border-radius: 10px;">
                                                    <i class="fa fa-user" style="color: #00897B;"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-semibold d-block" style="color: #263238;">{{ $inspector->first_name }} {{ $inspector->last_name }}</span>
                                                    @if($inspector->user?->email)
                                                        <small class="text-muted" style="font-size: 12px;">{{ $inspector->user->email }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace;">{{ $inspector->national_id }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace;">
                                            <div class="fw-semibold" style="color: #00796B;">
                                                <i class="fa fa-mobile-alt ms-1" style="color: #26A69A;"></i>
                                                {{ $inspector->mobile }}
                                            </div>
                                            @if($inspector->phone)
                                                <small class="text-muted d-block mt-1" style="font-size: 12px;">ثابت: {{ $inspector->phone }}</small>
                                            @endif
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            @if($inspector->is_certificated)
                                                <span class="badge" style="background: linear-gradient(135deg, #C8E6C9 0%, #A5D6A7 100%); color: #1B5E20; padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                                                    <i class="fa fa-check ms-1"></i>داراست
                                                </span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #E0E0E0 0%, #BDBDBD 100%); color: #424242; padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                                                    <i class="fa fa-times ms-1"></i>ندارد
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <div class="fw-semibold" style="color: #37474F;">
                                                <i class="fa fa-map-marker-alt ms-1" style="color: #FF7043;"></i>
                                                {{ $inspector->province }}
                                            </div>
                                            <small class="text-muted d-block mt-1" style="font-size: 12px;">{{ $inspector->city }}</small>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <span class="badge" style="background: linear-gradient(135deg, #B2DFDB 0%, #4DB6AC 100%); color: #004D40; padding: 6px 14px; border-radius: 20px; font-weight: 700;">
                                                <i class="fa fa-circle ms-1" style="font-size: 8px;"></i>فعال
                                            </span>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace; color: #546E7A;">{{ jdate($inspector->created_at)->format('Y/m/d') }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('inspector-catalog.show', $inspector) }}" class="btn btn-sm" style="width: 36px; height: 36px; padding: 0; border-radius: 50%; background: linear-gradient(135deg, #B2EBF2 0%, #4DD0E1 100%); color: #006064; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(77, 208, 225, 0.3);" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('inspector-catalog.edit', $inspector) }}" class="btn btn-sm" style="width: 36px; height: 36px; padding: 0; border-radius: 50%; background: linear-gradient(135deg, #FFE0B2 0%, #FFB74D 100%); color: #E65100; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(255, 183, 77, 0.3);" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('inspector-catalog.destroy', $inspector) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این بازرس و حساب کاربری مرتبط اطمینان دارید؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" style="width: 36px; height: 36px; padding: 0; border-radius: 50%; background: linear-gradient(135deg, #FFCDD2 0%, #EF9A9A 100%); color: #B71C1C; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(239, 154, 154, 0.3);" title="حذف">
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
                    <div class="p-4" style="background: #FAFAFA; border-radius: 0 0 12px 12px;">
                        {{ $inspectors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<style>
    #inspectorsTable thead th:first-child { border-radius: 12px 12px 0 0; }
    #inspectorsTable thead th:last-child { border-radius: 12px 0 0 0; }
    #inspectorsTable tbody tr:hover { background-color: #E0F2F1 !important; }
    .pagination { justify-content: center !important; }
    .page-link { border-radius: 8px !important; margin: 0 3px; border: none; background: #E0F2F1; color: #00695C; padding: 8px 14px; font-weight: 600; }
    .page-item.active .page-link { background: linear-gradient(135deg, #4DB6AC 0%, #26A69A 100%); color: white; box-shadow: 0 2px 8px rgba(38, 166, 154, 0.3); }
    .dataTables_filter, .dataTables_length, .dataTables_info { padding: 16px; }
    .dataTables_filter input { border-radius: 8px; padding: 8px 14px; border: 1px solid #B2DFDB; background: #E0F2F1; }
    .dataTables_length select { border-radius: 8px; padding: 8px 12px; border: 1px solid #B2DFDB; background: #E0F2F1; }
</style>
<script>
    $(document).ready(function() {
        $('#inspectorsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']],
            paging: false,
            searching: true,
            info: true,
            language: {
                search: "جستجو:",
                lengthMenu: "نمایش _MENU_ رکورد",
                info: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                paginate: { first: "اول", last: "آخر", next: "بعدی", previous: "قبلی" },
                emptyTable: "هیچ داده‌ای موجود نیست"
            }
        });
    });
</script>
@endsection
