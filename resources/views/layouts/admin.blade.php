<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <!-- Other CSS files as needed -->
    @yield('css')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- Sidebar -->
        {{-- @include('layouts.sidebar') --}}
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>
        <!-- Footer -->
        {{-- @include('layouts.footer') --}}
    </div>
    <!-- AdminLTE Scripts -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <!-- Other JS files as needed -->
    @yield('scripts')
</body>
</html>
