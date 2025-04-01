<div class="menu">
    <div class="menu-header">
        <a href="{{ url('/') }}" class="menu-header-logo">

        </a>
        <a href="{{ url('/') }}" class="btn btn-sm menu-close-btn">
            <i class="bi bi-x"></i>
        </a>
    </div>
    <div class="menu-body">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                <div class="avatar me-3">
                    <div class="avatar avatar-primary me-1">
                        <span class="avatar-text rounded-circle">{{strtoupper(substr(auth()->user()->name, 0, 1))}}</span>
                    </div>
                </div>
                <div style="width: 90%;">
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
                <div class="">
                    <i class="bi bi-gear"></i> 
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="{{route('profile.edit')}}" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-person dropdown-item-icon"></i> Profile
                </a>
                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item d-flex align-items-center text-danger">
                    <i class="bi bi-box-arrow-right dropdown-item-icon"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <ul>
            <li>
                <a @if(!request()->segment(1) || request()->is('dashboard')) class="active"
                   @endif href="{{ route('admin.dashboard') }}">
                    <span class="nav-link-icon">
                        <i class="bi bi-bar-chart"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a @if(request()->is('customer')) class="active" @endif href="{{route('admin.data.index', ['type' => 'customer'])}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-person"></i>
                    </span>
                    <span>Customer</span>
                </a>
            </li>
            <li>
                <a @if(request()->is('invoice')) class="active" @endif href="{{ route('admin.data.index', ['type' => 'invoice']) }}">
                    <span class="nav-link-icon">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <span>Invoice</span>
                </a>
            </li>
        </ul>
    </div>
</div>