<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login to PetCare</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="login-page">

    <div class="signup-card">

        <!-- Logo -->
        <div class="logo">
            <i class="fa-solid fa-paw"></i>
        </div>

        <!-- Title -->
        <h1>PetCare</h1>

        <p class="subtitle">SaaS Management</p>

        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('login') }}" class="tab active">Login</a>
            <a href="{{ route('register') }}" class="tab">Create an Account</a>
        </div>

        <!-- Session Error -->
        @if (session('status'))
            <div style="background:#d1f5d3; color:#1a6e29; font-size:10px; padding:8px 12px; border-radius:5px; margin-bottom:12px; border:1px solid #b5e8ba; text-align:center;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#fde8e8; color:#9b1c1c; font-size:10px; padding:8px 12px; border-radius:5px; margin-bottom:12px; border:1px solid #f5c2c2; text-align:center;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Role -->
            <p class="role-title">Select your role</p>

            <div class="roles">

                <!-- Pet Owner -->
                <input
                    type="radio"
                    name="role"
                    id="owner"
                    value="owner"
                    checked
                >

                <label for="owner" class="role-card">
                    <i class="fa-solid fa-paw paw-icon"></i>
                    <span>Pet Owner</span>
                </label>

                <!-- Veterinary Clinic -->
                <input
                    type="radio"
                    name="role"
                    id="clinic"
                    value="clinic"
                >

                <label for="clinic" class="role-card">
                    <i class="fa-solid fa-hospital clinic-icon"></i>
                    <span>Veterinary Clinic</span>
                </label>

            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-btn">
                Log In
            </button>

            <!-- Social Logins -->
            <div class="divider">
                <span>Or continue with</span>
            </div>

            <div class="social-login">
                <a href="{{ route('google.redirect') }}" class="social-btn google">
                    <i class="fa-brands fa-google"></i> Google
                </a>
            </div>

        </form>

        <p class="terms" style="margin-top: 14px;">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:#006e1c; font-weight:600; text-decoration:none;">Sign up</a>
        </p>

    </div>

</body>
</html>
