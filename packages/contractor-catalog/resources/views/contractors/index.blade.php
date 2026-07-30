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

        <div class="mb-4 p-4 text-white" style="background: linear-gradient(135deg, #64B5F6 0%, #1976D2 100%); border-radius: 12px; box-shadow: 0 4px 20px rgba(25, 118, 210, 0.25);">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1 fw-bold"><i class="fa fa-building ms-2"></i>کاتالوگ پیمانکاران</h3>
                    <p class="mb-0 opacity-90">مدیریت پیمانکاران ساخت و ساز، پروانه‌ها و پروژه‌های ثبت‌شده</p>
                </div>
                <a href="{{ route('contractor-catalog.create') }}" class="btn btn-light btn-lg" style="border-radius: 12px; color: #1976D2; font-weight: 600; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <i class="fa fa-plus ms-1"></i> افزودن پیمانکار جدید
                </a>
            </div>
        </div>

        @php
            $totalContractors = $contractors->total();
            $validLicenses = 0;
            $expiredLicenses = 0;
            $totalProjects = 0;
            foreach($contractors as $c) {
                if($c->is_license_valid) $validLicenses++;
                else $expiredLicenses++;
                $totalProjects += $c->registered_projects_count;
            }
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 152, 0, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">کل پیمانکاران</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalContractors }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-building" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #81C784 0%, #4CAF50 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">پروانه معتبر</h6>
                            <h2 class="mb-0 fw-bold">{{ $validLicenses }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-check-circle" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #E57373 0%, #F44336 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(244, 67, 54, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">منقضی شده</h6>
                            <h2 class="mb-0 fw-bold">{{ $expiredLicenses }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-exclamation-triangle" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #64B5F6 0%, #1976D2 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(25, 118, 210, 0.25);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2 opacity-90">کل پروژه‌های ثبت‌شده</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalProjects }}</h2>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 12px;">
                            <i class="fa fa-project-diagram" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <div class="card-body p-0">
                @if($contractors->isEmpty())
                    <div class="text-center py-5 px-4">
                        <div style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-folder-open" style="font-size: 42px; color: #FF9800;"></i>
                        </div>
                        <h5 class="mb-2 fw-bold" style="color: #5D4037;">هنوز پیمانکاری ثبت نشده است</h5>
                        <p class="text-muted mb-4">با کلیک روی دکمه زیر، اولین پیمانکار خود را ثبت کنید</p>
                        <a href="{{ route('contractor-catalog.create') }}" class="btn text-white" style="background: linear-gradient(135deg, #64B5F6 0%, #1976D2 100%); border-radius: 12px; font-weight: 600;">
                            <i class="fa fa-plus ms-1"></i> ثبت پیمانکار اول
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table id="contractorsTable" class="table table-hover mb-0" style="width:100%; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr style="background: #FFF3E0;">
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">#</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">نام شرکت</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">شناسه ملی</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">مدیر عامل</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">موبایل</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">شماره پروانه</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">وضعیت پروانه</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">تعداد پروژه</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">تاریخ ثبت</th>
                                    <th style="padding: 14px 16px; font-weight: 700; color: #E65100; border: none;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contractors as $contractor)
                                    <tr style="border-bottom: 1px solid #F5F5F5; transition: all 0.2s;">
                                        <td style="padding: 14px 16px; vertical-align: middle;">{{ $loop->iteration + ($contractors->currentPage() - 1) * $contractors->perPage() }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); border-radius: 10px;">
                                                    <i class="fa fa-building" style="color: #1976D2;"></i>
                                                </div>
                                                <span class="fw-semibold" style="color: #263238;">{{ $contractor->company_name }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace;">{{ $contractor->national_id }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">{{ $contractor->ceo_name }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace;">{{ $contractor->ceo_mobile }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace;">{{ $contractor->license_number }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            @if($contractor->is_license_valid)
                                                <span class="badge" style="background: linear-gradient(135deg, #C8E6C9 0%, #A5D6A7 100%); color: #1B5E20; padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                                                    <i class="fa fa-check ms-1"></i>معتبر
                                                </span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #FFCDD2 0%, #EF9A9A 100%); color: #B71C1C; padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                                                    <i class="fa fa-times ms-1"></i>منقضی
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <span class="badge" style="background: linear-gradient(135deg, #BBDEFB 0%, #64B5F6 100%); color: #0D47A1; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                                                {{ $contractor->registered_projects_count }}
                                            </span>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; font-family: 'Vazir', monospace; color: #546E7A;">{{ jdate($contractor->created_at)->format('Y/m/d') }}</td>
                                        <td style="padding: 14px 16px; vertical-align: middle;">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('contractor-catalog.show', $contractor) }}" class="btn btn-sm" style="width: 36px; height: 36px; padding: 0; border-radius: 50%; background: linear-gradient(135deg, #B3E5FC 0%, #4FC3F7 100%); color: #01579B; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(79, 195, 247, 0.3);" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('contractor-catalog.edit', $contractor) }}" class="btn btn-sm" style="width: 36px; height: 36px; padding: 0; border-radius: 50%; background: linear-gradient(135deg, #FFE0B2 0%, #FFB74D 100%); color: #E65100; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(255, 183, 77, 0.3);" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('contractor-catalog.destroy', $contractor) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این پیمانکار اطمینان دارید؟');">
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
                        {{ $contractors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<style>
    #contractorsTable thead th:first-child { border-radius: 12px 12px 0 0; }
    #contractorsTable thead th:last-child { border-radius: 12px 0 0 0; }
    #contractorsTable tbody tr:hover { background-color: #FFF8E1 !important; }
    .pagination { justify-content: center !important; }
    .page-link { border-radius: 8px !important; margin: 0 3px; border: none; background: #FFF3E0; color: #E65100; padding: 8px 14px; font-weight: 600; }
    .page-item.active .page-link { background: linear-gradient(135deg, #FFB74D 0%, #FF9800 100%); color: white; box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3); }
    .dataTables_filter, .dataTables_length, .dataTables_info { padding: 16px; }
    .dataTables_filter input { border-radius: 8px; padding: 8px 14px; border: 1px solid #FFE0B2; background: #FFF8E1; }
    .dataTables_length select { border-radius: 8px; padding: 8px 12px; border: 1px solid #FFE0B2; background: #FFF8E1; }
</style>
<script>
    $(document).ready(function() {
        $('#contractorsTable').DataTable({
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
