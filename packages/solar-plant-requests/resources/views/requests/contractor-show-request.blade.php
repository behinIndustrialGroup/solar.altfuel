@extends('behin-layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-header">
                        <h5 class="mb-0">لیست درخواست‌ها</h5>
                    </div>
                    <div class="card-body table-responsive">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
