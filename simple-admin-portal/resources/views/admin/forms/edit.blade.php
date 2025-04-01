@extends('layouts.app')

@section('header')
    {{ __('Edit '.ucfirst($type)) }}
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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.'.$type.'s.index') }}">
                        {{ ucfirst($type).'s' }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row"> 
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Edit {{ ucfirst($type) }}</h5>
                    
                    <form method="POST" action="{{ route('admin.update', ['type' => $type, 'id' => $model->id]) }}">
                        @csrf
                        @method('PUT')

                        @if($type === 'customer')
                            <!-- Customer Fields -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $model->name) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $model->email) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $model->phone) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $model->address) }}</textarea>
                            </div>
                        @else
                            <!-- Invoice Fields -->
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer *</label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" 
                                            {{ old('customer_id', $model->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="date" class="form-label">Date *</label>
                                <input type="date" class="form-control" id="date" name="date" 
                                       value="{{ old('date', $model->date) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount *</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                                       value="{{ old('amount', $model->amount) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="unpaid" {{ old('status', $model->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ old('status', $model->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="cancelled" {{ old('status', $model->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        @endif
            
                        <button type="submit" class="btn btn-primary">Update {{ ucfirst($type) }}</button>
                        <a href="{{ route('admin.'.$type.'s.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection