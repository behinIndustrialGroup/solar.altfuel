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
                <h5 class="mb-0">جدول پیمانکاران</h5>
                <a href="{{ route('contractor-catalog.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i> افزودن پیمانکار جدید
                </a>
            </div>
            <div class="card-body">
                @if($contractors->isEmpty())
                    <div class="alert alert-info">هیچ پیمانکاری یافت نشد.</div>
                @else
                    <div class="table-responsive">
                        <table id="contractorsTable" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام شرکت</th>
                                    <th>شناسه ملی</th>
                                    <th>مدیر عامل</th>
                                    <th>کد ملی م.ع</th>
                                    <th>موبایل م.ع</th>
                                    <th>شخص رابط</th>
                                    <th>موبایل رابط</th>
                                    <th>تلفن شرکت</th>
                                    <th>استان</th>
                                    <th>شهر</th>
                                    <th>شماره پروانه</th>
                                    <th>تاریخ صدور</th>
                                    <th>تاریخ انقضا</th>
                                    <th>وضعیت پروانه</th>
                                    <th>تعداد پروژه</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contractors as $contractor)
                                    <tr>
                                        <td>{{ $loop->iteration + ($contractors->currentPage() - 1) * $contractors->perPage() }}</td>
                                        <td>{{ $contractor->company_name }}</td>
                                        <td>{{ $contractor->national_id }}</td>
                                        <td>{{ $contractor->ceo_name }}</td>
                                        <td>{{ $contractor->ceo_national_code }}</td>
                                        <td>{{ $contractor->ceo_mobile }}</td>
                                        <td>{{ $contractor->contact_person_name }}</td>
                                        <td>{{ $contractor->contact_person_mobile }}</td>
                                        <td>{{ $contractor->company_phone ?? '-' }}</td>
                                        <td>{{ $contractor->province }}</td>
                                        <td>{{ $contractor->city }}</td>
                                        <td>{{ $contractor->license_number }}</td>
                                        <td>{{ $contractor->license_issue_date ? toJalaliFormatted($contractor->license_issue_date, 'Y/m/d') : '-' }}</td>
                                        <td>{{ $contractor->license_expiry_date ? toJalaliFormatted($contractor->license_expiry_date, 'Y/m/d') : '-' }}</td>
                                        <td>
                                            @if($contractor->is_license_valid)
                                                <span class="badge badge-success">معتبر</span>
                                            @else
                                                <span class="badge badge-danger">منقضی</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $contractor->registered_projects_count }}</span>
                                        </td>
                                        <td>{{ jdate($contractor->created_at)->format('Y/m/d') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('contractor-catalog.show', $contractor) }}" class="btn btn-sm btn-info" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('contractor-catalog.edit', $contractor) }}" class="btn btn-sm btn-warning" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('contractor-catalog.destroy', $contractor) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این پیمانکار اطمینان دارید؟');">
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
                    <div class="mt-3">{{ $contractors->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#contractorsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']],
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
