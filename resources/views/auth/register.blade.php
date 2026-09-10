<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account � PetCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .signup-card {
            min-height: auto;
            width: 340px;
        }

        .register-two-col {
            display: flex;
            gap: 10px;
        }

        .register-two-col .input-group {
            flex: 1;
        }

        .error-msg {
            font-size: 9px;
            color: #d32f2f;
            margin-top: 3px;
            margin-bottom: 4px;
            display: block;
        }

        .flash-error {
            background: #fde8e8;
            color: #9b1c1c;
            font-size: 10px;
            padding: 8px 12px;
            border-radius: 5px;
            margin-bottom: 12px;
            border: 1px solid #f5c2c2;
            text-align: center;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle input {
            padding-right: 32px !important;
        }

        .password-toggle .toggle-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #8b9787;
            font-size: 11px;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .password-toggle .toggle-btn:hover {
            color: #4caf50;
        }

        .terms-agree {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 14px;
            margin-bottom: 4px;
        }

        .terms-agree input[type="checkbox"] {
            width: 13px;
            height: 13px;
            margin-top: 1px;
            accent-color: #4caf50;
            cursor: pointer;
            flex-shrink: 0;
        }

        .terms-agree label {
            font-size: 9px;
            color: #3f4a3c;
            line-height: 13px;
            cursor: pointer;
        }

        .terms-agree label a {
            color: #006e1c;
            font-weight: 600;
            text-decoration: none;
        }

        .terms-agree label a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="login-page">

    <div class="signup-card">

        <div class="logo">
            <i class="fa-solid fa-paw"></i>
        </div>

        <h1>PetCare</h1>
        <p class="subtitle">SaaS Management</p>

        <div class="tabs">
            <a href="{{ route('login') }}" class="tab">Login</a>
            <a href="{{ route('register') }}" class="tab active">Create an Account</a>
        </div>

        @if (session('error'))
            <div class="flash-error">
                <i class="fa-solid fa-circle-exclamation" style="margin-right:5px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="register-form">
            @csrf

            <p class="role-title">Select your role</p>

            <div class="roles">
                <input type="radio" name="role" id="owner" value="owner"
                    {{ old('role', 'owner') === 'owner' ? 'checked' : '' }}>
                <label for="owner" class="role-card">
                    <i class="fa-solid fa-paw paw-icon"></i>
                    <span>Pet Owner</span>
                </label>
            </div>

            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}"
                    required autocomplete="name">
                @error('name')
                    <span class="error-msg"><i class="fa-solid fa-circle-exclamation" style="font-size:8px;"></i>
                        {{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="name@example.com"
                    value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <span class="error-msg"><i class="fa-solid fa-circle-exclamation" style="font-size:8px;"></i>
                        {{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="+20 1XX XXX XXXX"
                    value="{{ old('phone') }}" required autocomplete="tel">
                @error('phone')
                    <span class="error-msg"><i class="fa-solid fa-circle-exclamation" style="font-size:8px;"></i>
                        {{ $message }}</span>
                @enderror
            </div>

            <div class="register-two-col">
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-toggle">
                        <input type="password" id="password" name="password" placeholder="��������" required
                            autocomplete="new-password">
                        <button type="button" class="toggle-btn" onclick="togglePass('password', this)" tabindex="-1">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Confirm</label>
                    <div class="password-toggle">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="��������" required autocomplete="new-password">
                        <button type="button" class="toggle-btn" onclick="togglePass('password_confirmation', this)"
                            tabindex="-1">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="terms-agree">
                <input type="checkbox" id="agree" required>
                <label for="agree">
                    By creating an account you agree to our
                    <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="submit-btn" style="margin-top: 14px;">
                <i class="fa-solid fa-user-plus" style="font-size:11px;"></i>
                Create Account
            </button>

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
            Already have an account?
            <a href="{{ route('login') }}" style="color:#006e1c; font-weight:600; text-decoration:none;">Sign in</a>
        </p>

    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-solid fa-eye';
            } else {
                input.type = 'password';
                icon.className = 'fa-solid fa-eye-slash';
            }
        }
    </script>

</body>

</html>
