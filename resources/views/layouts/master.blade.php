<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PetCare')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>

<body class="@yield('body-class', '')">

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Flash Messages -->
    @if (session('success'))
        <div style="margin-left:250px; padding: 12px 30px; background:#d1f5d3; color:#1a6e29; font-size:14px; border-bottom:1px solid #b5e8ba;">
            {{ session('success') }}
        </div>
    @endif

    @if (isset($errors) && $errors->has('error'))
        <div style="margin-left:250px; padding: 12px 30px; background:#fde8e8; color:#9b1c1c; font-size:14px; border-bottom:1px solid #f5c2c2;">
            {{ $errors->first('error') }}
        </div>
    @endif

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    @include('layouts.partials.footer')

    @stack('scripts')
</body>

</html>
