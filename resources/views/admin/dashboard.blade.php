@extends('behin-layouts.app')

@php
    $disableBackBtn = false;
@endphp

@section('content')
    <div class="container py-4">
        <div class="row g-3 text-center">
            @if (auth()->user()->access('ثبت درخواست احداث نیروگاه'))
                <div class="col-6 col-md-3">
                    <a href="{{ route('simpleWorkflow.process.start', [
                        'taskId' => 'cf8147ed-042e-49a9-a9cf-04b7591a4eca',
                        'force' => 1,
                        'redirect' => 1,
                        'inDraft' => 0,
                    ]) }}"
                        class="d-block p-3 shadow-sm rounded-3 bg-white hover-card">
                        <i class="bi bi-brightness-high fs-2 text-warning"></i>
                        <div class="mt-2 fw-bold">احداث نیروگاه</div>
                    </a>
                </div>
            @endif

            @if (auth()->user()->access('داشبورد: آیکون شروع فرایند'))
                <div class="col-6 col-md-3">
                    <a href="{{ route('simpleWorkflow.process.startListView') }}"
                        class="d-block p-3 shadow-sm rounded-3 bg-white hover-card">
                        <i class="bi bi-list-task fs-2 text-success"></i>
                        <div class="mt-2 fw-bold">شروع فرایند</div>
                    </a>
                </div>
            @endif
            @if (auth()->user()->access('داشبورد: آیکون کارتابل من'))
                <div class="col-6 col-md-3">
                    <a href="{{ route('simpleWorkflow.inbox.index') }}"
                        class="d-block p-3 shadow-sm rounded-3 bg-white hover-card">
                        <i class="bi bi-list fs-2 text-warning"></i>
                        <div class="mt-2 fw-bold">کارتابل من</div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }
    </style>
@endpush
