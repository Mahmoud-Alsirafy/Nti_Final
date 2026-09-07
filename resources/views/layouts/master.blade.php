<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PetCare')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    @stack('styles')
</head>
<body class="@yield('body-class', '')">

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>
