<div class="content-wrapper">
    <aside id="sidebar" class="text-white vh-100 p-3">
        <div class="text-center mb-4">
            <h5 class="fw-bold mb-1">Hotel Reservation</h5>
            <small>{{ auth()->user()?->name }}</small>
        </div>

        <hr class="border-secondary">

        <ul class="nav flex-column">
            <li class="nav-item mb-1">
                <a href="{{ route('dashboard') }}"
                    class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-gauge me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('profile.edit') }}"
                    class="nav-link text-white {{ request()->routeIs('profile.*') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-user me-2"></i> Profile
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('dashboard') }}"
                    class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-table me-2"></i> Rooms DataTable
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ url('/') }}"
                    class="nav-link text-white {{ request()->is('/') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-house me-2"></i> Home
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ url('/room') }}"
                    class="nav-link text-white {{ request()->is('room') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-bed me-2"></i> Rooms Page
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ url('/about') }}"
                    class="nav-link text-white {{ request()->is('about') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-circle-info me-2"></i> About
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ url('/news') }}"
                    class="nav-link text-white {{ request()->is('news') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-newspaper me-2"></i> News
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ url('/contact') }}"
                    class="nav-link text-white {{ request()->is('contact') ? 'active bg-dark text-white' : '' }}">
                    <i class="fas fa-envelope me-2"></i> Contact
                </a>
            </li>
        </ul>
    </aside>
</div>
