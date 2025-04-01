@extends('layouts.app')

@section('header')
    {{ __('Admin Dashboard') }}
@endsection

@section('content')
<div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col-lg-12 col-md-12">
        <div class="card widget">
            <div class="card-header">
                <h5 class="card-title">Dashboard Overview</h5>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="{{ route('admin.data.index', ['type' => 'customer']) }}">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <div class="display-5">
                                    <i class="bi bi-person text-secondary"></i>
                                </div>
                                <h5 class="my-3">Total Customers</h5>
                                <div class="text-muted">{{ $customerCount }} Customers</div>
                                <div class="progress mt-3" style="height: 5px">
                                    <div class="progress-bar bg-secondary" role="progressbar" 
                                         style="width: {{ $customerPercentage }}%"
                                         aria-valuenow="{{ $customerPercentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('admin.data.index', ['type' => 'invoice']) }}">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <div class="display-5">
                                    <i class="bi bi-receipt text-warning"></i>
                                </div>
                                <h5 class="my-3">Total Invoices</h5>
                                <div class="text-muted">{{ $invoiceCount }} Invoices</div>
                                <div class="progress mt-3" style="height: 5px">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: {{ $invoicePercentage }}%"
                                         aria-valuenow="{{ $invoicePercentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection