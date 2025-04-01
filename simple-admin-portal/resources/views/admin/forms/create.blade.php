@extends('layouts.app')

@section('header')
    {{ __('Admin Dashboard') }}
@endsection

@section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($type) }}</li>
            </ol>
        </nav>
    </div>

    <div class="row"> 
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-body"  >
                        <h5 class="card-title">Create {{ ucfirst($type)}}</h5>
                    
                    <form method="POST" action="{{ route('admin.store', $type) }}">
                        @csrf
            
                        @if($type === 'customer')
                            <!-- Customer Fields -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                        @else
                            <!-- Invoice Fields -->
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer *</label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="date" class="form-label">Date *</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount *</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        @endif
            
                        <button type="submit" class="btn btn-primary">Create {{ ucfirst($type) }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
