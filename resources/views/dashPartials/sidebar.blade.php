@php
    $current_uri = $current_uri ?? request()->segment(1);

    // Section expansion logic
    $pages_routes = ['user', 'hotel', 'rooms', 'services', 'discount', 'reservation', 'payment', 'permission'];
    $is_pages_section = in_array($current_uri, $pages_routes);
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
            <h6 class="mb-0">Super Admin</h6>
            <small class="sidebar-user-subtitle">Administrator</small>
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

        <!-- Pages Section -->
        <li class="sidebar-item">
            <a class="sidebar-link" 
               data-bs-toggle="collapse" 
               data-bs-target="#pages" 
               aria-expanded="true">
                <i class="fas fa-th-large"></i> <span>Pages</span>
            </a>
            <ul id="pages" class="sidebar-dropdown list-unstyled show">
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.user') }}" class="sidebar-link {{ $current_uri == 'user' ? 'active' : '' }}">Users</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.hotel') }}" class="sidebar-link {{ $current_uri == 'hotel' ? 'active' : '' }}">Hotels</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.rooms') }}" class="sidebar-link {{ $current_uri == 'rooms' ? 'active' : '' }}">Rooms</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.services') }}" class="sidebar-link {{ $current_uri == 'services' ? 'active' : '' }}">Services</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.discount') }}" class="sidebar-link {{ $current_uri == 'discount' ? 'active' : '' }}">Discounts</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.reservation') }}" class="sidebar-link {{ $current_uri == 'reservation' ? 'active' : '' }}">Reservations</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.payment') }}" class="sidebar-link {{ $current_uri == 'payment' ? 'active' : '' }}">Payments</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.permission') }}" class="sidebar-link {{ $current_uri == 'permission' ? 'active' : '' }}">Permissions</a>
                </li>
            </ul>
        </li>

    </ul>
</aside>



