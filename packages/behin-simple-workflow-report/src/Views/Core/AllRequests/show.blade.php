@extends('behin-layouts.app')

@section('title', 'جزئیات درخواست')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h4 class="mb-0 fw-bold text-primary">جزئیات درخواست شماره پرونده {{ $requestRow->case_number ?? '---' }}</h4>
                    <a href="{{ route('simpleWorkflowReport.all-requests.index') }}" class="btn btn-light border-primary text-primary">
                        بازگشت به فهرست
                    </a>
                </div>

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="bg-gradient" style="background: linear-gradient(135deg, #1976d2, #42a5f5);">
                        <div class="p-4 text-white">
                            <h5 class="mb-1">{{ trim(($requestRow->user_firstname ?? '') . ' ' . ($requestRow->user_lastname ?? '')) ?: 'کاربر ناشناخته' }}</h5>
                            <p class="mb-0 opacity-75">آخرین وضعیت: {{ $requestRow->last_status ?? '---' }}</p>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-4">
                            @php
                                $details = [
                                    ['label' => 'شماره پرونده', 'value' => $requestRow->case_number, 'ltr' => true],
                                    ['label' => 'نام', 'value' => $requestRow->user_firstname],
                                    ['label' => 'نام خانوادگی', 'value' => $requestRow->user_lastname],
                                    ['label' => 'شماره همراه', 'value' => $requestRow->mobile, 'ltr' => true],
                                    ['label' => 'کد ملی', 'value' => $requestRow->user_national_id, 'ltr' => true],
                                    ['label' => 'شناسه قبض برق', 'value' => $requestRow->electricity_bill_id, 'ltr' => true],
                                    ['label' => 'نوع نیروگاه', 'value' => $requestRow->powerhouse_type],
                                    ['label' => 'استان محل نیروگاه', 'value' => $requestRow->powerhouse_province],
                                    ['label' => 'کد پستی محل نیروگاه', 'value' => $requestRow->powerhouse_postal_code, 'ltr' => true],
                                    ['label' => 'آدرس محل نیروگاه', 'value' => $requestRow->powerhouse_address],
                                    ['label' => 'ظرفیت درخواستی', 'value' => $requestRow->requested_capacity_of_powerhouse],
                                    ['label' => 'نتیجه اولین تماس', 'value' => $requestRow->first_call_result],
                                    ['label' => 'سود تسهیلات', 'value' => $requestRow->loan_interest],
                                    ['label' => 'مبلغ اولیه', 'value' => $requestRow->initial_amount],
                                    ['label' => 'امکان‌سنجی', 'value' => $requestRow->feasibility_study],
                                ];
                            @endphp

                            @foreach($details as $detail)
                                <div class="col-md-6">
                                    <div class="bg-white rounded-4 shadow-sm h-100 p-3 d-flex flex-column gap-2 border border-light">
                                        <span class="text-secondary small fw-semibold">{{ $detail['label'] }}</span>
                                        <span class="fw-bold text-dark" @if(($detail['ltr'] ?? false)) dir="ltr" @endif>
                                            {{ $detail['value'] ?? '---' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
