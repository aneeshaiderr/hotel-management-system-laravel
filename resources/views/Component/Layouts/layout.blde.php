
<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Include head partial --}}
    @include('dashPartial.head')
</head>

<body>

    {{-- Include navbar partial --}}
    @include('dashPartial.nav')

    {{-- Include sidebar partial --}}
    @include('dashPartial.sidebar')

    <main class="d-flex flex-column min-vh-100">
        {{-- Content section --}}
        @yield('content')
    </main>

    {{-- Include footer partial --}}
    @include('dashPartial.footer')

</body>
</html>
