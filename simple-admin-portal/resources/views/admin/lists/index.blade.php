@extends('layouts.app')

@section('content')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($type) }} List</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mt-4">
            <div class="card-header" style="display: flex; justify-content: space-between;">
                <h3 class="card-title">{{ ucfirst($type) }} List</h3>
                <div class="dropdown">
                    <a href="{{ route('admin.create', ['type' => $type]) }}" class="btn btn-info btn-sm">
                        Create {{ ucfirst($type) }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="{{ $type }}-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            @if($type === 'customer')
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created At</th>
                            @elseif($type === 'invoice')
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable for dynamic table
        $('#{{ $type }}-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.data.index', ['type' => $type]) }}",
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                @if($type === 'customer')
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'created_at', name: 'created_at' },
                @elseif($type === 'invoice')
                    { data: 'customer_name', name: 'customer.name' },
                    { data: 'date', name: 'date' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status' },
                @endif
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/' + type + '/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON?.message || 'Something went wrong',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@endsection
