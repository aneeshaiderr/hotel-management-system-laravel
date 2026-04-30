@php
    $current_uri = $current_uri ?? request()->segment(1);
    $role = Auth::user()->role;

    // Section expansion logic
    $dashboard_routes = ['analytics', 'setting'];
    $is_dashboard_section = in_array($current_uri, $dashboard_routes);
@endphp

<aside id="sidebar" class="vh-100">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand text-center">
        <h5 class="sidebar-brand-text fw-bold">Hotel Reservation</h5>
    </div>

    <!-- User Profile Section -->
    <div class="sidebar-user text-center">
        <img src="{{ asset('assets_dashboard/img/avatar.jpg') }}" class="rounded-circle img-fluid mb-2" alt="User Avatar" style="width:60px; height:60px;">
        <div class="sidebar-user-title">
            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
            <small class="sidebar-user-subtitle">{{ ucfirst($role) }}</small>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <ul class="sidebar-nav">

        <!-- Dashboard Direct Link -->
        <li class="sidebar-item">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ $current_uri == 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>

        @if($role === 'super-admin')
        <!-- Dashboards Section -->
        <li class="sidebar-item">
            <a class="sidebar-link {{ $is_dashboard_section ? '' : 'collapsed' }}" 
               href="javascript:void(0)"
               data-bs-toggle="collapse" 
               data-bs-target="#dashboards" 
               aria-expanded="{{ $is_dashboard_section ? 'true' : 'false' }}">
                <i class="fas fa-sliders-h"></i> <span>Dashboards</span>
            </a>
            <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse {{ $is_dashboard_section ? 'show' : '' }}">
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.analytics') }}" class="sidebar-link {{ $current_uri == 'analytics' ? 'active' : '' }}">Analytics</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.setting') }}" class="sidebar-link {{ $current_uri == 'setting' ? 'active' : '' }}">Settings</a>
                </li>
            </ul>
        </li>
        @endif

        {{-- Direct Links instead of dropdown --}}
        <li class="sidebar-item">
            <a href="{{ route('dashboard.user') }}" class="sidebar-link {{ $current_uri == 'user' ? 'active' : '' }}">
                <i class="fas fa-user"></i> <span>{{ $role === 'user' ? 'My Profile' : 'Users' }}</span>
            </a>
        </li>

        @if($role === 'super-admin')
        <li class="sidebar-item">
            <a href="{{ route('dashboard.hotel') }}" class="sidebar-link {{ $current_uri == 'hotel' ? 'active' : '' }}">
                <i class="fas fa-hotel"></i> <span>Hotels</span>
            </a>
        </li>
        @endif

        @if($role === 'super-admin' || $role === 'staff')
        <li class="sidebar-item">
            <a href="{{ route('dashboard.rooms') }}" class="sidebar-link {{ $current_uri == 'rooms' ? 'active' : '' }}">
                <i class="fas fa-bed"></i> <span>Rooms</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('dashboard.services') }}" class="sidebar-link {{ $current_uri == 'services' ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i> <span>Services</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('dashboard.discount') }}" class="sidebar-link {{ $current_uri == 'discount' ? 'active' : '' }}">
                <i class="fas fa-tag"></i> <span>Discounts</span>
            </a>
        </li>
        @endif

        <li class="sidebar-item">
            <a href="{{ route('dashboard.reservation') }}" class="sidebar-link {{ $current_uri == 'reservation' ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> <span>{{ $role === 'user' ? 'My Reservations' : 'Reservations' }}</span>
            </a>
        </li>

        @if($role === 'super-admin')
        <li class="sidebar-item">
            <a href="{{ route('dashboard.payment') }}" class="sidebar-link {{ $current_uri == 'payment' ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> <span>Payments</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('dashboard.permission') }}" class="sidebar-link {{ $current_uri == 'permission' ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> <span>Permissions</span>
            </a>
        </li>
        @endif

    </ul>
</aside>



