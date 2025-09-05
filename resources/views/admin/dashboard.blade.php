@extends('behin-layouts.app')

@php
    $disableBackBtn = false;
@endphp

@section('content')

    <div class="container py-4">
        <div class="row g-3 text-center justify-content-center">
            @if (auth()->user()->access('ثبت درخواست احداث نیروگاه'))
                <div class="col-4 col-md-4">
                    <a href="{{ route('simpleWorkflow.process.start', [
                        'taskId' => 'cf8147ed-042e-49a9-a9cf-04b7591a4eca',
                        'force' => 1,
                        'redirect' => 1,
                        'inDraft' => 0,
                    ]) }}" class="icon-tile text-decoration-none text-dark">
                        <i class="bi bi-brightness-high fs-2 text-warning"></i>
                        <span class="mt-2 fw-bold">احداث نیروگاه</span>
                    </a>
                </div>
            @endif

            @if (auth()->user()->access('داشبورد: آیکون شروع فرایند'))
                <div class="col-4 col-md-4">
                    <a href="{{ route('simpleWorkflow.process.startListView') }}"
                        class="icon-tile text-decoration-none text-dark">
                        <i class="bi bi-list-task fs-2 text-success"></i>
                        <span class="mt-2 fw-bold">شروع فرایند</span>
                    </a>
                </div>
            @endif
            @if (auth()->user()->access('داشبورد: آیکون کارتابل من'))
                <div class="col-4 col-md-4">
                    <a href="{{ route('simpleWorkflow.inbox.index') }}" class="icon-tile text-decoration-none text-dark">
                        <i class="bi bi-list fs-2 text-warning"></i>
                        <span class="mt-2 fw-bold">درخواست های تکمیل نشده</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .icon-tile {
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .icon-tile:hover {
            transform: translateY(-5px);
        }

        @media (max-width: 767.98px) {
            .icon-tile {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                padding: 0;
            }

            .icon-tile span {
                display: none;
            }
        }
    </style>
@endpush
