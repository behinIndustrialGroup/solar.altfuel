@extends('behin-layouts.app')
@php
    use SolarPlantRequests\Enums\SolarPlantRequestStatus;
@endphp

@push('styles')
    <style>
        .certificate-page {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            color: #1f2937;
            padding: 32px;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .certificate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            padding-bottom: 24px;
            border-bottom: 3px solid #0ea5e9;
            margin-bottom: 24px;
        }

        .certificate-logo img {
            max-height: 80px;
        }

        .certificate-title h1 {
            font-size: 28px;
            margin: 0;
            color: #0f172a;
        }

        .certificate-title p {
            margin: 4px 0 0;
            color: #475569;
        }

        .certificate-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .certificate-field {
            padding: 14px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: linear-gradient(145deg, #f8fafc, #ffffff);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
            page-break-inside: avoid;
        }

        .certificate-field label {
            display: block;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .certificate-field span,
        .certificate-field p {
            margin: 0;
            color: #334155;
            line-height: 1.6;
        }

        .address-box {
            grid-column: 1/-1;
        }

        .print-section {
            margin-top: 24px;
            page-break-inside: avoid;
        }

        .print-section h3 {
            font-size: 20px;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 12px;
            margin-bottom: 12px;
            display: inline-block;
        }

        .certificate-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            page-break-inside: auto;
        }

        .certificate-table th,
        .certificate-table td {
            padding: 12px 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
            color: #1f2937;
        }

        .certificate-table thead {
            background: #0ea5e9;
            color: #ffffff;
        }

        .certificate-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e0f2fe;
            color: #0369a1;
            font-weight: 700;
        }

        .cta-row {
            margin-top: 24px;
        }

        .print-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 16px;
        }

        @media print {
            body {
                background: #ffffff !important;
            }

            .certificate-page {
                box-shadow: none;
                border: none;
                padding: 20mm;
                page-break-after: always;
            }

            .print-actions,
            header.navbar,
            footer {
                display: none !important;
            }

            .print-section {
                page-break-inside: avoid;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="print-actions">
            <button class="btn btn-outline-primary" onclick="window.print()">چاپ گواهی</button>
        </div>
        <div class="certificate-page">
            <div class="certificate-header">
                <div class="certificate-logo">
                    <img src="{{ asset('behin/logo.png') }}" alt="لوگو">
                </div>
                <div class="certificate-title text-end">
                    <h1>گواهی درخواست نیروگاه خورشیدی</h1>
                    <p class="mb-1">اطلاعات ثبت شده متقاضی و تجهیزات همراه</p>
                    <span class="status-badge">وضعیت: {{ $solarPlantRequest->status?->label() }}</span>
                </div>
            </div>

            <div class="certificate-grid">
                <div class="certificate-field">
                    <label>نام</label>
                    <span>{{ $solarPlantRequest->first_name }}</span>
                </div>
                <div class="certificate-field">
                    <label>نام خانوادگی</label>
                    <span>{{ $solarPlantRequest->last_name }}</span>
                </div>
                <div class="certificate-field">
                    <label>شماره همراه</label>
                    <span>{{ $solarPlantRequest->mobile }}</span>
                </div>
                <div class="certificate-field">
                    <label>کد ملی</label>
                    <span>{{ $solarPlantRequest->national_code }}</span>
                </div>
                <div class="certificate-field">
                    <label>کد پستی</label>
                    <span>{{ $solarPlantRequest->postal_code }}</span>
                </div>
                <div class="certificate-field">
                    <label>شناسه قبض</label>
                    <span>{{ $solarPlantRequest->bill_identifier }}</span>
                </div>
                <div class="certificate-field">
                    <label>متراژ (متر مربع)</label>
                    <span>{{ $solarPlantRequest->area }}</span>
                </div>
                <div class="certificate-field address-box">
                    <label>آدرس</label>
                    <p class="mb-0">{{ $solarPlantRequest->address }}</p>
                </div>
            </div>

            @if ($solarPlantRequest->panels->count())
                <div class="print-section">
                    <h3>پنل‌های ثبت شده</h3>
                    <table class="certificate-table">
                        <thead>
                            <tr>
                                <th>سریال</th>
                                <th>سازنده / واردکننده</th>
                                <th>سال تولید</th>
                                <th>سال انقضا</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solarPlantRequest->panels as $panel)
                                <tr>
                                    <td>{{ $panel->serial }}</td>
                                    <td>{{ $panel->manufacturer?->name ?? $panel->manufacturer?->email }}</td>
                                    <td>{{ $panel->production_year }}</td>
                                    <td>{{ $panel->expiration_year }}</td>
                                    <td>{{ $panel->status?->label() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($solarPlantRequest->batteries->count())
                <div class="print-section">
                    <h3>باتری‌های ثبت شده</h3>
                    <table class="certificate-table">
                        <thead>
                            <tr>
                                <th>سریال</th>
                                <th>سازنده / واردکننده</th>
                                <th>سال تولید</th>
                                <th>سال انقضا</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solarPlantRequest->batteries as $battery)
                                <tr>
                                    <td>{{ $battery->serial }}</td>
                                    <td>{{ $battery->manufacturer?->name ?? $battery->manufacturer?->email }}</td>
                                    <td>{{ $battery->production_year }}</td>
                                    <td>{{ $battery->expiration_year }}</td>
                                    <td>{{ $battery->status?->label() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($solarPlantRequest->inverters->count())
                <div class="print-section">
                    <h3>اینورترهای ثبت شده</h3>
                    <table class="certificate-table">
                        <thead>
                            <tr>
                                <th>سریال</th>
                                <th>سازنده / واردکننده</th>
                                <th>سال تولید</th>
                                <th>سال انقضا</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solarPlantRequest->inverters as $inverter)
                                <tr>
                                    <td>{{ $inverter->serial }}</td>
                                    <td>{{ $inverter->manufacturer?->name ?? $inverter->manufacturer?->email }}</td>
                                    <td>{{ $inverter->production_year }}</td>
                                    <td>{{ $inverter->expiration_year }}</td>
                                    <td>{{ $inverter->status?->label() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($solarPlantRequest->status == SolarPlantRequestStatus::INSPECTION)
                <div class="cta-row">
                    <form method="POST"
                        action="{{ route('solar-plant-requests.inspection.result-approved', $solarPlantRequest) }}">
                        @csrf
                        <button class="btn btn-primary w-100" type="submit">تایید بازرسی</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
