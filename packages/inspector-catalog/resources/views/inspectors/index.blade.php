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
                <h5 class="mb-0">جدول بازرسان</h5>
                <a href="{{ route('inspector-catalog.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus ms-1"></i> افزودن بازرس جدید
                </a>
            </div>
            <div class="card-body">
                @if($inspectors->isEmpty())
                    <div class="alert alert-info">هیچ بازرسی یافت نشد.</div>
                @else
                    <div class="table-responsive">
                        <table id="inspectorsTable" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>کد بازرس</th>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>کد ملی</th>
                                    <th>شماره همراه</th>
                                    <th>تلفن ثابت</th>
                                    <th>استان</th>
                                    <th>شهر</th>
                                    <th>گواهی صلاحیت</th>
                                    <th>ایمیل کاربری</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inspectors as $inspector)
                                    <tr>
                                        <td>{{ $loop->iteration + ($inspectors->currentPage() - 1) * $inspectors->perPage() }}</td>
                                        <td>{{ $inspector->inspector_code }}</td>
                                        <td>{{ $inspector->first_name }}</td>
                                        <td>{{ $inspector->last_name }}</td>
                                        <td>{{ $inspector->national_id }}</td>
                                        <td>{{ $inspector->mobile }}</td>
                                        <td>{{ $inspector->phone ?? '-' }}</td>
                                        <td>{{ $inspector->province }}</td>
                                        <td>{{ $inspector->city }}</td>
                                        <td>
                                            @if($inspector->is_certificated)
                                                <span class="badge badge-success">بلی</span>
                                            @else
                                                <span class="badge badge-secondary">خیر</span>
                                            @endif
                                        </td>
                                        <td>{{ $inspector->user?->email ?? '-' }}</td>
                                        <td>{{ jdate($inspector->created_at)->format('Y/m/d') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('inspector-catalog.show', $inspector) }}" class="btn btn-sm btn-info" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('inspector-catalog.edit', $inspector) }}" class="btn btn-sm btn-warning" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('inspector-catalog.destroy', $inspector) }}" style="display:inline;" onsubmit="return confirm('آیا از حذف این بازرس و حساب کاربری مرتبط اطمینان دارید؟');">
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
                    <div class="mt-3">{{ $inspectors->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#inspectorsTable').DataTable({
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
