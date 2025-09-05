@extends('behin-layouts.app')

@php
    $disableBackBtn = false;
@endphp

@section('content')
    {{-- Slider (Top Banner) --}}
    <div id="dashboardCarousel" class="carousel slide mb-4 rounded-4 overflow-hidden shadow-sm" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ url('behin/slide1.png') }}" class="d-block w-100" alt="slide">
            </div>
        </div>
    </div>

    {{-- Mobile: Floating Circle Buttons --}}
    <div class="d-md-none fixed-bottom mb-4">
        <div class="container">
            <div class="row g-4 text-center justify-content-center">
                @if (auth()->user()->access('ثبت درخواست احداث نیروگاه'))
                    <div class="col-6">
                        <a href="{{ route('simpleWorkflow.process.start', [
                            'taskId' => 'cf8147ed-042e-49a9-a9cf-04b7591a4eca',
                            'force' => 1,
                            'redirect' => 1,
                            'inDraft' => 0,
                        ]) }}" 
                           class="circle-btn bg-warning shadow-lg text-white text-decoration-none">
                            <i class="bi bi-brightness-high fs-2"></i>
                            <span class="mt-2 fw-semibold small">احداث نیروگاه</span>
                        </a>
                    </div>
                @endif

                @if (auth()->user()->access('داشبورد: آیکون کارتابل من'))
                    <div class="col-6">
                        <a href="{{ route('simpleWorkflow.inbox.index') }}" 
                           class="circle-btn bg-success shadow-lg text-white text-decoration-none">
                            <i class="bi bi-list-check fs-2"></i>
                            <span class="mt-2 fw-semibold small">درخواست‌های من</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Desktop: Material Tiles --}}
    <div class="container d-none d-md-block py-3">
        <div class="row g-4 justify-content-center">
            @if (auth()->user()->access('ثبت درخواست احداث نیروگاه'))
                <div class="col-6 col-lg-3">
                    <a href="{{ route('simpleWorkflow.process.start', [
                        'taskId' => 'cf8147ed-042e-49a9-a9cf-04b7591a4eca',
                        'force' => 1,
                        'redirect' => 1,
                        'inDraft' => 0,
                    ]) }}" class="tile-btn bg-warning text-white text-decoration-none">
                        <i class="bi bi-brightness-high fs-1"></i>
                        <span class="fw-bold mt-3 d-block">احداث نیروگاه</span>
                    </a>
                </div>
            @endif

            @if (auth()->user()->access('داشبورد: آیکون کارتابل من'))
                <div class="col-6 col-lg-3">
                    <a href="{{ route('simpleWorkflow.inbox.index') }}" 
                       class="tile-btn bg-success text-white text-decoration-none">
                        <i class="bi bi-list-check fs-1"></i>
                        <span class="fw-bold mt-3 d-block">درخواست‌های من</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    /* Mobile circle buttons */
    .circle-btn {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        transition: all 0.25s ease;
    }
    .circle-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.25);
    }

    /* Desktop tiles */
    .tile-btn {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem 1rem;
        border-radius: 1rem;
        min-height: 160px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .tile-btn:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.25);
    }
</style>
@endpush
