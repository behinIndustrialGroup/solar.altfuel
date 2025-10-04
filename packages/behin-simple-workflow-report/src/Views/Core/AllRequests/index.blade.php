@extends('behin-layouts.app')

@section('title', 'لیست تمام درخواست‌ها')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="mb-0">لیست تمام درخواست‌ها</h5>
                        <span class="badge bg-light text-primary">{{ $rows->count() }} مورد</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>شماره پرونده</th>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>شناسه قبض برق</th>
                                    <th>نوع نیروگاه</th>
                                    <th>استان محل نیروگاه</th>
                                    <th>ظرفیت درخواستی</th>
                                    <th>نتیجه اولین تماس</th>
                                    <th>سود تسهیلات</th>
                                    <th>مبلغ اولیه</th>
                                    <th>امکان‌سنجی</th>
                                    <th>آخرین وضعیت درخواست</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($rows as $row)
                                    <tr>
                                        <td>{{ $row['case_number'] ?? '---' }}</td>
                                        <td>{{ $row['user_firstname'] ?? '---' }}</td>
                                        <td>{{ $row['user_lastname'] ?? '---' }}</td>
                                        <td dir="ltr">{{ $row['electricity_bill_id'] ?? '---' }}</td>
                                        <td>{{ $row['powerhouse_type'] ?? '---' }}</td>
                                        <td>{{ $row['powerhouse_province'] ?? '---' }}</td>
                                        <td>{{ $row['requested_capacity_of_powerhouse'] ?? '---' }}</td>
                                        <td>{{ $row['first_call_result'] ?? '---' }}</td>
                                        <td>{{ $row['loan_interest'] ?? '---' }}</td>
                                        <td>{{ $row['initial_amount'] ?? '---' }}</td>
                                        <td>{{ $row['feasibility_study'] ?? '---' }}</td>
                                        <td>{{ $row['last_status'] ?? '---' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted">رکوردی یافت نشد.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
