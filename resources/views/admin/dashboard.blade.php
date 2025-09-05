@extends('behin-layouts.app')

@php
    $disableBackBtn = false;
@endphp

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .mobile-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .mobile-tile span {
            font-size: 0.85rem;
            font-weight: 500;
            color: #333;
        }

        @media (max-width: 767.98px) {
            .icon-circle {
                width: 60px;
                height: 60px;
                /* font-size: 24px; */
            }

            .mobile-tile span {
                font-size: 0.75rem;
            }
        }
    </style>
    <div class="container py-4">
        <div class="row g-3 text-center justify-content-center">

            @if (auth()->user()->access('ثبت درخواست احداث نیروگاه'))
                <div class="col-4 col-md-3">
                    <a href="{{ route('simpleWorkflow.process.start', [
                        'taskId' => 'cf8147ed-042e-49a9-a9cf-04b7591a4eca',
                        'force' => 1,
                        'redirect' => 1,
                        'inDraft' => 0,
                    ]) }}" class="mobile-tile text-decoration-none">
                        <div class="text-white">
                            <i class="icon-circle bg-warning bi bi-brightness-high"></i>
                        </div>
                        <span>احداث نیروگاه</span>
                    </a>
                </div>
            @endif

            @if (auth()->user()->access('داشبورد: آیکون شروع فرایند'))
                <div class="col-4 col-md-3">
                    <a href="{{ route('simpleWorkflow.process.startListView') }}" class="mobile-tile text-decoration-none">
                        <div class="text-white">
                            <i class="icon-circle bg-success bi bi-list-task"></i>
                        </div>
                        <span>شروع فرایند</span>
                    </a>
                </div>
            @endif

            @if (auth()->user()->access('داشبورد: درخواست های تکمیل نشده'))
                <div class="col-4 col-md-3">
                    <a href="{{ route('simpleWorkflow.inbox.index') }}" class="mobile-tile text-decoration-none">
                        <div class="text-white">
                            <i class="icon-circle bg-info bi bi-list"></i>
                        </div>
                        <span>درخواست‌های تکمیل نشده</span>
                    </a>
                </div>
            @endif
            @if (auth()->user()->access('داشبورد: درخواست های من'))
                <div class="col-4 col-md-3">
                    <a href="{{ route('simpleWorkflowReport.my-request.index') }}" class="mobile-tile text-decoration-none">
                        <div class="text-white">
                            <i class="icon-circle bg-success bi bi-list"></i>
                        </div>
                        <span>درخواست‌های من</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection

