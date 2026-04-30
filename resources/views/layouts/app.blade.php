<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        <!-- Bootstrap 5.3.3 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome + Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.bootstrap5.css" />

        <!-- Custom Dashboard CSS -->
        <link rel="stylesheet" href="{{ asset('assets_dashboard/css/style.css') }}">

        <!-- Scripts -->
        @php
            $hasViteHot = file_exists(public_path('hot'));
            $hasViteBuild = file_exists(public_path('build/manifest.json'));
        @endphp
        @if ($hasViteHot || $hasViteBuild)
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @if ($showDefaultNavigation)
                @include('layouts.navigation')
            @else
                @include('dashPartials.sidebar')
                <div class="main-wrapper">
                    @include('dashPartials.nav')
                    <main class="main-content">
                        {{ $slot }}
                    </main>
                </div>
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.js"></script>
        <!-- Dashboard JS -->
        <script src="{{ asset('assets_dashboard/js/script.js') }}"></script>
        @stack('scripts')
    </body>
</html>
