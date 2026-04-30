<!-- HEADER SECTION START -->
<header>

    <!-- Top Bar -->
    <div class="bg-white border-bottom py-2 topbar-hide">
        <div
            class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2">

            <!-- Contact -->
            <ul class="list-unstyled d-flex flex-column flex-md-row mb-0 gap-2 gap-md-4 fw-medium topbar-list">
                <li><i class="fa fa-phone me-2 text-warning"></i> (12) 345 67890</li>
                <li><i class="fa fa-envelope me-2 text-warning"></i> info.colorlib@gmail.com</li>
            </ul>

            <!-- Social + Buttons -->
            <div class="d-flex align-items-center gap-2">
                <div class="social-icons d-flex">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>

                <!-- Direct href use kiya -->
                <a href="/booking" class="bk-btn text-center">Booking Now</a>
                @guest
                    <a href="{{ route('register') }}" class="bk-btn text-center">Signup Now</a>
                    <a href="{{ route('login') }}" class="bk-btn text-center">Login</a>
                @endguest
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="bk-btn text-center border-0" style="background: none;">Logout</button>
                    </form>
                @endauth

            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets_front/images/logo.png') }}" alt="Sona Hotel" style="height:40px;">
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse custom-sidebar" id="mainNav">

                <button class="sidebar-close" data-bs-toggle="collapse" data-bs-target="#mainNav">&times;</button>

                <!-- Direct href -->
                <a href="/booking" class="bk-btn btn text-center mb-1">Booking Now</a>
                @guest
                    <a href="{{ route('register') }}" class="bk-btn btn text-center mb-1">Signup Now</a>
                    <a href="{{ route('login') }}" class="bk-btn btn text-center mb-1">Login</a>
                @endguest
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="d-block mb-1">
                        @csrf
                        <button type="submit" class="bk-btn btn text-center w-100 border-0" style="background: none;">Logout</button>
                    </form>
                @endauth

                <ul class="navbar-nav ms-auto align-items-start gap-4 p-4">

                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/room">Rooms</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/about">About Us</a>
                    </li>

                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">
                            Pages
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/room-details">Room Details</a></li>
                            <li><a class="dropdown-item" href="/blog-details">Blog Details</a></li>
                            <li><a class="dropdown-item" href="#">Family Room</a></li>
                            <li><a class="dropdown-item" href="#">Premium Room</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/news">News</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link search-btn">
                            <i class="fas fa-search"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
    <span class="close-btn" id="closeSearch">&times;</span>
    <input type="text" placeholder="Search here..." />
</div>
