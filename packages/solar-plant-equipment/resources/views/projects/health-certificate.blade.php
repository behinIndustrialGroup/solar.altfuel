<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <title>گواهی سلامت نیروگاه خورشیدی - {{ $project->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 12mm 10mm;
        }

        * { box-sizing: border-box; }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Tahoma', 'DejaVu Sans', sans-serif;
            font-size: 11.5px;
            line-height: 1.55;
            color: #222;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .cert-page {
            width: 100%;
            max-width: 190mm;
            margin: 0 auto;
        }

        .page-break {
            page-break-after: always;
            break-after: page;
        }

        .cert-header {
            border: 2.5px solid #0c6e46;
            border-radius: 8px;
            padding: 14px 18px 12px 18px;
            background: linear-gradient(180deg, #eaf7ef 0%, #ffffff 100%);
            text-align: center;
            position: relative;
            margin-bottom: 10px;
        }

        .cert-header .cert-logo {
            position: absolute;
            top: 10px;
            left: 18px;
            width: 72px;
            height: 72px;
            max-width: 72px;
            max-height: 72px;
            object-fit: contain;
            background: #fff;
            border: 1px solid #cfd8dc;
            border-radius: 10px;
            padding: 5px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .cert-header h1 {
            font-size: 18px;
            color: #0c6e46;
            margin: 0 0 4px 0;
            padding: 0;
        }

        .cert-header h2 {
            font-size: 12px;
            color: #555;
            margin: 0 0 6px 0;
            font-weight: normal;
        }

        .cert-header .cert-code-row {
            margin-top: 6px;
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 11px;
            color: #333;
        }

        .cert-header .cert-code-row span {
            display: inline-block;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 3px 10px;
        }

        .cert-header .cert-code-row b {
            color: #0c6e46;
        }

        .section {
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .section-title {
            background: #0c6e46;
            color: #fff;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .section-body {
            padding: 6px 10px;
        }

        .combined-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 11.5px;
        }

        .combined-table th,
        .combined-table td {
            border: 1px solid #bbb;
            padding: 4px 9px;
            vertical-align: middle;
        }

        .combined-table th {
            background: #f1f3f5;
            color: #333;
            font-weight: bold;
            text-align: right;
            width: 28%;
            white-space: nowrap;
        }

        .combined-table td {
            color: #111;
            text-align: left;
            direction: ltr;
            font-weight: 600;
        }

        .combined-table td.fa {
            direction: rtl;
            text-align: right;
        }

        .combined-table .group-header td {
            background: #eaf7ef;
            color: #0c6e46;
            font-weight: bold;
            text-align: center;
            direction: rtl;
            padding: 4px 8px;
            font-size: 11.5px;
        }

        .cert-text-box {
            background: #fbf8ee;
            border: 1px dashed #c79b2e;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 11.5px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }

        .serials-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 11px;
        }

        .serials-table th,
        .serials-table td {
            border: 1px solid #bbb;
            padding: 4px 8px;
            text-align: center;
        }

        .serials-table th {
            background: #f1f3f5;
            color: #333;
            font-weight: bold;
        }

        .serials-table td.sns {
            text-align: left;
            direction: ltr;
            word-break: break-all;
            line-height: 1.6;
        }

        .equipment-summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 11px;
        }

        .equipment-summary th,
        .equipment-summary td {
            border: 1px solid #bbb;
            padding: 4px 8px;
        }

        .equipment-summary th {
            background: #f1f3f5;
            font-weight: bold;
            text-align: center;
            width: 22%;
        }

        .equipment-summary td {
            text-align: center;
            direction: ltr;
        }

        .equipment-summary td.fa {
            direction: rtl;
            text-align: right;
        }

        .equipment-subtitle {
            font-weight: bold;
            color: #0c6e46;
            background: #eaf7ef;
            padding: 4px 10px;
            border-radius: 4px;
            margin: 2px 0 6px 0;
            font-size: 11.5px;
        }

        .cert-footer {
            margin-top: 14px;
            padding-top: 8px;
            border-top: 2px solid #0c6e46;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            direction: rtl;
        }

        .sign-box {
            text-align: center;
            border: 1px dashed #999;
            border-radius: 5px;
            padding: 12px 6px 10px 6px;
            min-height: 100px;
            position: relative;
        }

        .sign-box .stamp-area {
            position: absolute;
            top: 6px;
            right: 8px;
            width: 54px;
            height: 54px;
            border: 2px dotted #a66;
            border-radius: 50%;
            opacity: 0.4;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.25;
            color: #844;
        }

        .sign-box .sign-title {
            font-size: 11px;
            color: #444;
            margin-top: 34px;
            font-weight: bold;
        }

        .sign-box .sign-line {
            border-bottom: 1px solid #555;
            width: 70%;
            margin: 14px auto 3px auto;
        }

        .sign-box .sign-label {
            font-size: 10px;
            color: #666;
        }

        .mt-4 { margin-top: 10px !important; }
        .mb-2 { margin-bottom: 4px !important; }
        .mb-3 { margin-bottom: 6px !important; }

        .no-print-toolbar {
            background: #0c6e46;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 100;
            margin: -10mm -10mm 8mm -10mm;
            width: calc(100% + 20mm);
        }

        .no-print-toolbar button {
            background: #fff;
            color: #0c6e46;
            border: none;
            border-radius: 6px;
            padding: 6px 16px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 10px;
            font-family: inherit;
        }

        .no-print-toolbar button:hover { background: #eaf7ef; }

        .empty-note {
            text-align: center;
            color: #888;
            padding: 10px;
            border: 1px dashed #ddd;
            border-radius: 5px;
            margin: 4px 0;
        }

        @media print {
            .no-print-toolbar { display: none !important; }
            .cert-page { max-width: none; width: 100%; }
        }
    </style>
</head>
<body>

<div class="no-print-toolbar">
    <form method="GET" action="{{ route('solar-plant-equipment.projects.show', $project) }}" style="display:inline">
        <button type="submit">بازگشت به پروژه</button>
    </form>
    <button onclick="window.print()">🖨️  چاپ / ذخیره به صورت PDF</button>
</div>

<div class="cert-page">

    {{-- ========================================================= --}}
    {{--                      صفحه اول گواهی                       --}}
    {{-- ========================================================= --}}

    {{-- هدر گواهی --}}
    <div class="cert-header">
        {{-- لوگوی رسمی سمت چپ هدر (جایگزین نماد متنی قبلی) --}}
        @php
            $logoPaths = [
                'behin/images/logo-union.png',
                'behin/images/logo.png',
                'behin/images/ieeu-logo.png',
                'behin/logo.png',
            ];
            $selectedLogo = null;
            foreach ($logoPaths as $lp) {
                $fullPath = public_path($lp);
                if (file_exists($fullPath)) {
                    $selectedLogo = $lp;
                    break;
                }
            }
        @endphp
        @if ($selectedLogo)
            <img src="{{ asset($selectedLogo) }}" alt="لوگوی اتحادیه" class="cert-logo">
        @endif

        <h1>گواهی سلامت نیروگاه خورشیدی</h1>
        <h2>سامانه جامع خورشیدی اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته</h2>
        <div class="cert-code-row">
            <span><b>شماره گواهی:</b> {{ $project->health_card_no ?? '—' }}</span>
            <span><b>شناسه یکتای پروژه:</b> PRJ-{{ $project->id }}</span>
            <span><b>تاریخ صدور:</b>
                @if ($project->health_card_issue_date)
                    {{ \Morilog\Jalali\Jalalian::fromDateTime($project->health_card_issue_date)->format('Y/m/d') }}
                @else
                    —
                @endif
            </span>
        </div>
    </div>

    {{-- بخش یک: اطلاعات مالک و پروژه (ادغام در یک جدول واحد) --}}
    <div class="section">
        <div class="section-title">اطلاعات مالک و مشخصات نیروگاه</div>
        <div class="section-body" style="padding: 10px;">
            @php
                $req = $project->request;
                $hasInv = $project->installedInverters->count();
                $hasBat = $project->installedBatteries->count();
                if ($hasInv && $hasBat) { $pt = 'Hybrid (هیبریدی)'; }
                elseif ($hasInv)        { $pt = 'On-Grid (متصل به شبکه)'; }
                else                    { $pt = 'Off-Grid (خودکفا)'; }
            @endphp
            <table class="combined-table">
                <tbody>
                    <tr class="group-header">
                        <td colspan="2">■ مشخصات مالک نیروگاه</td>
                    </tr>
                    <tr>
                        <th>نام و نام خانوادگی / نام شرکت:</th>
                        <td class="fa">
                            @if ($req)
                                @if ($req->applicant_type && $req->applicant_type->value === 'legal' && $req->company_name)
                                    {{ $req->company_name }}
                                @else
                                    {{ trim(($req->first_name ?? '') . ' ' . ($req->last_name ?? '')) }}
                                @endif
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>کد ملی / شناسه ملی:</th>
                        <td>
                            @if ($req)
                                {{ $req->national_code ?? $req->registration_number ?? '—' }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>

                    <tr class="group-header">
                        <td colspan="2">■ مشخصات فنی و آدرس نیروگاه</td>
                    </tr>
                    <tr>
                        <th>ظرفیت نیروگاه (kW):</th>
                        <td>{{ $req->capacity_kw ?? ($totalPanelKwp ?? '—') }}</td>
                    </tr>
                    <tr>
                        <th>نوع نیروگاه:</th>
                        <td class="fa">{{ $pt }}</td>
                    </tr>
                    <tr>
                        <th>استان:</th>
                        <td class="fa">{{ $req->province ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>شهر:</th>
                        <td class="fa">{{ $req->city ?? '—' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- بخش دو: اطلاعات پیمانکار و بازرس --}}
    <div class="section">
        <div class="section-title">اطلاعات پیمانکار اجرایی و بازرس فنی</div>
        <div class="section-body" style="padding: 10px;">
            @php
                $approvedInspection = $project->inspections
                    ->where('result', 'approved')
                    ->sortByDesc('visit_date')
                    ->first();
            @endphp
            <table class="combined-table">
                <tbody>
                    <tr class="group-header">
                        <td colspan="2">■ پیمانکار اجرایی</td>
                    </tr>
                    <tr>
                        <th>نام شرکت مجری:</th>
                        <td class="fa">{{ $project->contractor->company_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>کد پیمانکار (شناسه ملی):</th>
                        <td>{{ $project->contractor->national_id ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>شماره پروانه کسب:</th>
                        <td>{{ $project->contractor->license_number ?? '—' }}</td>
                    </tr>

                    <tr class="group-header">
                        <td colspan="2">■ بازرس فنی</td>
                    </tr>
                    <tr>
                        <th>نام بازرس:</th>
                        <td class="fa">{{ $project->inspector->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>کد بازرس (نام کاربری / پرسنلی):</th>
                        <td>{{ $project->inspector->number ?? $project->inspector->id ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>تاریخ بازرسی:</th>
                        <td>
                            @if ($approvedInspection && $approvedInspection->visit_date)
                                {{ \Morilog\Jalali\Jalalian::fromDateTime($approvedInspection->visit_date)->format('Y/m/d') }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- بخش سه: متن گواهی --}}
    <div class="section">
        <div class="section-title">متن گواهی</div>
        <div class="section-body">
            <div class="cert-text-box">
                بدین‌وسیله گواهی می‌شود نیروگاه خورشیدی موضوع این گواهی، با شناسه یکتای پروژه
                <b dir="ltr">PRJ-{{ $project->id }}</b>
                به نام
                <b>
                    @if ($req = $project->request)
                        @if ($req->applicant_type && $req->applicant_type->value === 'legal' && $req->company_name)
                            {{ $req->company_name }}
                        @else
                            {{ trim(($req->first_name ?? '') . ' ' . ($req->last_name ?? '')) }}
                        @endif
                    @endif
                </b>
                ، با ظرفیت نامی
                <b>{{ $req->capacity_kw ?? ($totalPanelWp ?? ($totalPanelKwp ?? '—')) }} کیلووات</b>
                واقع در استان <b>{{ $req->province ?? '—' }}</b> - شهر <b>{{ $req->city ?? '—' }}</b>،
                پس از ارزیابی فنی، بررسی تجهیزات، کنترل کیفیت اجرا و بازرسی نهایی،
                مطابق ضوابط و الزامات اتحادیه کشوری سوخت‌های جایگزین، خدمات وابسته و انرژی‌های تجدیدپذیر،
                مورد تأیید قرار گرفته و این «گواهی سلامت» برای آن صادر شده است.
            </div>
        </div>
    </div>

    {{-- جدا کننده صفحه اول و دوم --}}
    <div class="page-break"></div>

    {{-- ========================================================= --}}
    {{--                      صفحه دوم گواهی                       --}}
    {{--              مشخصات کامل تجهیزات نصب شده                   --}}
    {{-- ========================================================= --}}

    <div class="section">
        <div class="section-title">مشخصات تجهیزات نصب‌شده در نیروگاه</div>
        <div class="section-body">

            {{-- پنل خورشیدی --}}
            @php
                $panelGroups = $project->installedPanels->groupBy('panel_model_id');
                $totalPanelWp = 0;
            @endphp
            <div class="equipment-subtitle">الف) پنل‌های خورشیدی</div>
            @if ($project->installedPanels->isEmpty())
                <div class="empty-note">— پنلی ثبت نشده —</div>
            @else
                @foreach ($panelGroups as $groupId => $panels)
                    @php
                        $first = $panels->first();
                        $cat   = $first->catalog;
                        $count = $panels->count();
                        $wp    = $cat->rated_power_wp ?? 0;
                        $kwp   = round(($wp * $count) / 1000, 2);
                        $totalPanelWp += ($wp * $count);
                        $serials = $panels->pluck('serial_number')->filter()->values();
                        $useTable = $count >= 10;
                    @endphp
                    <table class="equipment-summary mb-2">
                        <tbody>
                            <tr>
                                <th>برند پنل</th>
                                <td class="fa">{{ $cat->brand ?? '—' }}</td>
                                <th>مدل پنل</th>
                                <td class="fa" colspan="3">{{ $cat->model ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>تعداد پنل</th>
                                <td>{{ $count }} عدد</td>
                                <th>توان هر پنل (W)</th>
                                <td>{{ $wp ?: '—' }}</td>
                                <th>ظرفیت کل (kWp)</th>
                                <td><b>{{ $kwp }}</b></td>
                            </tr>
                        </tbody>
                    </table>

                    @if (!$serials->isEmpty())
                        <table class="serials-table mb-3">
                            <thead>
                                <tr>
                                    <th style="width:28%">تجهیزات</th>
                                    <th>شماره سریال پنل‌ها</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>پنل خورشیدی {{ $cat->model ?? '' }}</td>
                                    <td class="sns">
                                        @if ($useTable)
                                            @foreach (array_chunk($serials->all(), 5) as $row)
                                                {{ implode('، ', $row) }}<br/>
                                            @endforeach
                                        @else
                                            {{ implode('، ', $serials->all()) }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                    @if (!$loop->last) <hr style="margin:14px 0; border:none; border-top:1px dashed #ccc"> @endif
                @endforeach
            @endif

            {{-- اینورتر --}}
            @php
                $invGroups = $project->installedInverters->groupBy('inverter_model_id');
                $totalInvKw = 0;
            @endphp
            <div class="equipment-subtitle mt-4">ب) اینورترها</div>
            @if ($project->installedInverters->isEmpty())
                <div class="empty-note">— اینورتری ثبت نشده —</div>
            @else
                @foreach ($invGroups as $groupId => $invs)
                    @php
                        $first = $invs->first();
                        $cat   = $first->catalog;
                        $count = $invs->count();
                        $kw    = $cat->rated_power_kw ?? 0;
                        $totKw = round($kw * $count, 2);
                        $totalInvKw += ($kw * $count);
                        $serials = $invs->pluck('serial_number')->filter()->values();
                    @endphp
                    <table class="equipment-summary mb-2">
                        <tbody>
                            <tr>
                                <th>برند اینورتر</th>
                                <td class="fa">{{ $cat->brand ?? '—' }}</td>
                                <th>مدل اینورتر</th>
                                <td class="fa" colspan="3">{{ $cat->model_name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>تعداد اینورتر</th>
                                <td>{{ $count }} عدد</td>
                                <th>ظرفیت هر اینورتر (kW)</th>
                                <td>{{ $kw ?: '—' }}</td>
                                <th>ظرفیت کل (kW)</th>
                                <td><b>{{ $totKw }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    @if (!$serials->isEmpty())
                        <table class="serials-table mb-3">
                            <thead>
                                <tr>
                                    <th style="width:28%">تجهیزات</th>
                                    <th>شماره سریال اینورترها</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>اینورتر {{ $cat->model_name ?? '' }}</td>
                                    <td class="sns">{{ implode('، ', $serials->all()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                    @if (!$loop->last) <hr style="margin:14px 0; border:none; border-top:1px dashed #ccc"> @endif
                @endforeach
            @endif

            {{-- باتری --}}
            @php
                $batGroups = $project->installedBatteries->groupBy('battery_model_id');
                $totalBatKwh = 0;
            @endphp
            <div class="equipment-subtitle mt-4">ج) باتری‌ها</div>
            @if ($project->installedBatteries->isEmpty())
                <div class="empty-note">— باتری ثبت نشده —</div>
            @else
                @foreach ($batGroups as $groupId => $bats)
                    @php
                        $first = $bats->first();
                        $cat   = $first->catalog;
                        $count = $bats->count();
                        $kwh   = $cat->energy_capacity_kwh ?? 0;
                        $totKwh = round($kwh * $count, 2);
                        $totalBatKwh += ($kwh * $count);
                        $serials = $bats->pluck('serial_number')->filter()->values();
                    @endphp
                    <table class="equipment-summary mb-2">
                        <tbody>
                            <tr>
                                <th>برند باتری</th>
                                <td class="fa">{{ $cat->brand ?? '—' }}</td>
                                <th>مدل باتری</th>
                                <td class="fa" colspan="3">{{ $cat->model_name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>تعداد باتری</th>
                                <td>{{ $count }} عدد</td>
                                <th>ظرفیت هر باتری (kWh)</th>
                                <td>{{ $kwh ?: '—' }}</td>
                                <th>ظرفیت کل (kWh)</th>
                                <td><b>{{ $totKwh }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    @if (!$serials->isEmpty())
                        <table class="serials-table mb-3">
                            <thead>
                                <tr>
                                    <th style="width:28%">تجهیزات</th>
                                    <th>شماره سریال باتری‌ها</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>باتری {{ $cat->model_name ?? '' }}</td>
                                    <td class="sns">{{ implode('، ', $serials->all()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                    @if (!$loop->last) <hr style="margin:14px 0; border:none; border-top:1px dashed #ccc"> @endif
                @endforeach
            @endif

        </div>
    </div>

    {{-- بخش امضاها (در پایین صفحه دوم) --}}
    <div class="section">
        <div class="section-title">تأیید نهایی</div>
        <div class="section-body">
            <div class="cert-footer" style="border:none;margin:0;padding:0">
                <div class="sign-box">
                    <div class="sign-title">پیشنهاد / تأیید بازرس فنی</div>
                    <div class="sign-line"></div>
                    <div class="sign-label">نام و امضا: {{ $project->inspector->name ?? '—' }}</div>
                </div>
                <div class="sign-box">
                    <div class="sign-title">تأیید پیمانکار اجرایی</div>
                    <div class="sign-line"></div>
                    <div class="sign-label">نام شرکت: {{ $project->contractor->company_name ?? '—' }}</div>
                </div>
                <div class="sign-box">
                    <div class="stamp-area">مهر<br/>اتحادیه</div>
                    <div class="sign-title">نام و سمت مقام مجاز اتحادیه</div>
                    <div class="sign-line"></div>
                    <div class="sign-label">امضا و مهر اتحادیه</div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
