@extends('behin-layouts.app')

@php
    use SolarPlantRequests\Enums\SolarPlantRequestStatus;
@endphp

@push('styles')
<style>
    /* ---------- GLOBAL ---------- */
    body {
        background: #f3f4f6;
        font-family: IRANSans, sans-serif;
    }

    .certificate-container {
        max-width: 820px;
        margin: 0 auto;
        background: #fff;
        padding: 40px 50px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 24px;
        border-bottom: 2px solid #0ea5e9;
        margin-bottom: 24px;
    }

    .header img {
        max-height: 75px;
    }

    .header-title {
        text-align: right;
    }

    .header-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
    }

    .header-title p {
        margin: 4px 0 0;
        color: #64748b;
    }

    .status-badge {
        margin-top: 8px;
        background: #e0f2fe;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: bold;
        color: #0369a1;
        display: inline-block;
    }

    /* ---------- GRID FIELDS ---------- */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 14px;
    }

    .field {
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
    }

    .field label {
        font-weight: 700;
        margin-bottom: 6px;
        display: block;
        color: #0f172a;
    }

    .field span {
        color: #334155;
        display: block;
    }

    /* ---------- TABLES ---------- */
    .section-title {
        font-size: 20px;
        margin-top: 35px;
        margin-bottom: 12px;
        font-weight: 700;
        border-bottom: 2px solid #e2e8f0;
        display: inline-block;
        padding-bottom: 6px;
        color: #0f172a;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 14px;
    }

    table th {
        background: #0ea5e9;
        color: white;
        padding: 10px;
        font-weight: bold;
    }

    table td {
        padding: 10px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    table tr:nth-child(even) {
        background: #f8fafc;
    }

    /* ---------- PRINT STYLES ---------- */
    @media print {
        body {
            background: #fff !important;
        }
        .print-actions,
        header.navbar,
        footer {
            display: none !important;
        }
        .certificate-container {
            box-shadow: none;
            border-radius: 0;
            border: none;
            width: 100%;
            padding: 25mm;
            page-break-after: always;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <div class="print-actions mb-3 text-end">
        <button onclick="window.print()" class="btn btn-outline-primary">چاپ گواهی</button>
    </div>

    <div class="certificate-container">

        <!-- HEADER -->
        <div class="header">
            <img src="{{ asset('behin/logo.png') }}" alt="لوگو">
            <div class="header-title">
                <h1>گواهی درخواست نیروگاه خورشیدی</h1>
                <p>مشخصات متقاضی و تجهیزات ثبت شده</p>
                <span class="status-badge">وضعیت: {{ $solarPlantRequest->status?->label() }}</span>
            </div>
        </div>

        <!-- INFO GRID -->
        <div class="info-grid">
            <div class="field"><label>نام</label><span>{{ $solarPlantRequest->first_name }}</span></div>
            <div class="field"><label>نام خانوادگی</label><span>{{ $solarPlantRequest->last_name }}</span></div>
            <div class="field"><label>شماره همراه</label><span>{{ $solarPlantRequest->mobile }}</span></div>
            <div class="field"><label>کد ملی</label><span>{{ $solarPlantRequest->national_code }}</span></div>
            <div class="field"><label>کد پستی</label><span>{{ $solarPlantRequest->postal_code }}</span></div>
            <div class="field"><label>شناسه قبض</label><span>{{ $solarPlantRequest->bill_identifier }}</span></div>
            <div class="field"><label>متراژ</label><span>{{ $solarPlantRequest->area }}</span></div>

            <div class="field" style="grid-column:1/-1;">
                <label>آدرس</label>
                <span>{{ $solarPlantRequest->address }}</span>
            </div>
        </div>

        <!-- PANELS -->
        @if ($solarPlantRequest->panels->count())
            <h3 class="section-title">پنل‌های ثبت شده</h3>
            <table>
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
        @endif

        <!-- BATTERIES -->
        @if ($solarPlantRequest->batteries->count())
            <h3 class="section-title">باتری‌های ثبت شده</h3>
            <table>
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
        @endif

        <!-- INVERTERS -->
        @if ($solarPlantRequest->inverters->count())
            <h3 class="section-title">اینورترهای ثبت شده</h3>
            <table>
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
        @endif

        <!-- INSPECTION BUTTON -->
        @if ($solarPlantRequest->status == SolarPlantRequestStatus::INSPECTION)
            <form method="POST" action="{{ route('solar-plant-requests.inspection.result-approved', $solarPlantRequest) }}" class="mt-4">
                @csrf
                <button class="btn btn-primary w-100" type="submit">تایید بازرسی</button>
            </form>
        @endif

    </div>
</div>
@endsection
