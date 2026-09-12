<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login to PetCare</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- HTML5 QR Code Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        .login-method-switch {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 10px;
        }

        .login-method-btn {
            flex: 1;
            padding: 9px 12px;
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .login-method-btn.active {
            background: #ffffff;
            color: #2f7d47;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .qr-login-container {
            display: none;
            animation: fadeIn 0.25s ease;
        }

        .qr-login-container.show {
            display: block;
        }

        .qr-scanner-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        #qr-reader {
            width: 100% !important;
            border: none !important;
            border-radius: 8px;
            overflow: hidden;
        }

        #qr-reader video {
            border-radius: 8px;
            max-height: 240px;
            object-fit: cover;
        }

        .qr-status-badge {
            font-size: 12.5px;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 14px;
            display: none;
            font-weight: 500;
        }

        .qr-status-badge.info {
            display: block;
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .qr-status-badge.success {
            display: block;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .qr-status-badge.error {
            display: block;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .qr-action-btn {
            width: 100%;
            height: 42px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 13.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 10px;
            font-family: inherit;
        }

        .qr-action-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        .qr-action-btn.primary {
            background: #2f7d47;
            border-color: #2f7d47;
            color: #ffffff;
        }

        .qr-action-btn.primary:hover {
            background: #236337;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
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

        <!-- Session Status / Errors -->
        @if (session('status'))
            <div style="background:#d1f5d3; color:#1a6e29; font-size:12px; padding:10px 14px; border-radius:8px; margin-bottom:14px; border:1px solid #b5e8ba; text-align:center;">
                {{ session('status') }}
            </div>
        @endif

        @if (session('success'))
            <div style="background:#d1f5d3; color:#1a6e29; font-size:12px; padding:10px 14px; border-radius:8px; margin-bottom:14px; border:1px solid #b5e8ba; text-align:center;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background:#fde8e8; color:#9b1c1c; font-size:12px; padding:10px 14px; border-radius:8px; margin-bottom:14px; border:1px solid #f5c2c2; text-align:center;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#fde8e8; color:#9b1c1c; font-size:12px; padding:10px 14px; border-radius:8px; margin-bottom:14px; border:1px solid #f5c2c2; text-align:center;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Login Method Switcher -->
        <div class="login-method-switch">
            <button type="button" class="login-method-btn active" id="btnMethodPassword" onclick="switchLoginMethod('password')">
                <i class="fa-solid fa-key"></i> Email &amp; Password
            </button>
            <button type="button" class="login-method-btn" id="btnMethodQr" onclick="switchLoginMethod('qr')">
                <i class="fa-solid fa-qrcode"></i> Scan QR Code
            </button>
        </div>

        <!-- 1. STANDARD PASSWORD LOGIN FORM -->
        <form action="{{ route('login') }}" method="POST" id="formPasswordLogin">
            @csrf

            <!-- Role -->
            <p class="role-title">Select your role</p>

            <div class="roles">
                <!-- Pet Owner -->
                <input type="radio" name="role" id="owner" value="owner" checked>
                <label for="owner" class="role-card">
                    <i class="fa-solid fa-paw paw-icon"></i>
                    <span>Pet Owner</span>
                </label>

                <!-- Veterinary Clinic -->
                <input type="radio" name="role" id="clinic" value="clinic">
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

        <!-- 2. QR CODE LOGIN SECTION -->
        <div class="qr-login-container" id="containerQrLogin">

            <div class="qr-status-badge info" id="qrStatusBadge">
                <i class="fa-solid fa-camera"></i> Point your camera at your personal PetCare QR code or upload an image.
            </div>

            <!-- Scanner Box -->
            <div class="qr-scanner-box">
                <div id="qr-reader"></div>
                <div id="scannerPlaceholder">
                    <i class="fa-solid fa-qrcode" style="font-size: 54px; color: #94a3b8; margin-bottom: 12px; display: block;"></i>
                    <p style="margin: 0 0 12px; font-size: 13.5px; color: #475569; font-weight: 500;">
                        Use your device camera or upload a QR image
                    </p>
                </div>
            </div>

            <!-- Scanner Controls -->
            <button type="button" class="qr-action-btn primary" id="btnStartScanner" onclick="startCameraScanner()">
                <i class="fa-solid fa-camera"></i> Open Camera Scanner
            </button>

            <button type="button" class="qr-action-btn" style="display: none;" id="btnStopScanner" onclick="stopCameraScanner()">
                <i class="fa-solid fa-stop"></i> Stop Camera
            </button>

            <label class="qr-action-btn" style="cursor: pointer;">
                <i class="fa-solid fa-upload"></i> Upload QR Code Image
                <input type="file" id="qrFileInput" accept="image/*" style="display: none;" onchange="scanQrFromFile(this)">
            </label>

            <!-- Direct Form for Submitting Token -->
            <form action="{{ route('qr.login.post') }}" method="POST" id="formQrTokenLogin" style="margin-top: 14px;">
                @csrf
                <div class="divider" style="margin: 14px 0;">
                    <span>Or enter QR token</span>
                </div>

                <div class="input-group" style="margin-bottom: 12px;">
                    <input type="text" id="manualQrToken" name="qr_code" placeholder="Paste QR Code Token or URL..." style="font-family: monospace; font-size: 13px;" required>
                </div>

                <button type="submit" class="submit-btn" style="height: 42px; font-size: 13.5px;">
                    <i class="fa-solid fa-right-to-bracket"></i> Login with Token
                </button>
            </form>

            <!-- Resend QR Code by Email Option -->
            <div style="margin-top: 15px; padding-top: 12px; border-top: 1px dashed #e2e8f0; text-align: center;">
                <a href="javascript:void(0)" onclick="toggleResendQrForm()" style="font-size: 12.5px; color: #2f7d47; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-paper-plane"></i> Missing your QR Code? Resend to Email
                </a>
                <form id="formResendQr" action="{{ route('qr.resend') }}" method="POST" style="display: none; margin-top: 10px;">
                    @csrf
                    <div class="input-group" style="margin-bottom: 8px;">
                        <input type="email" name="email" placeholder="Enter your registered email..." required style="font-size: 13px; height: 38px;">
                    </div>
                    <button type="submit" class="qr-action-btn primary" style="margin-bottom: 0;">
                        <i class="fa-solid fa-envelope"></i> Send QR to My Email
                    </button>
                </form>
            </div>
        </div>

        <p class="terms" style="margin-top: 18px;">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:#006e1c; font-weight:600; text-decoration:none;">Sign up</a>
        </p>

    </div>

    <script>
        let html5QrCode = null;
        let isCameraRunning = false;

        function switchLoginMethod(method) {
            const btnPassword = document.getElementById('btnMethodPassword');
            const btnQr = document.getElementById('btnMethodQr');
            const formPassword = document.getElementById('formPasswordLogin');
            const containerQr = document.getElementById('containerQrLogin');

            if (method === 'qr') {
                btnPassword.classList.remove('active');
                btnQr.classList.add('active');
                formPassword.style.display = 'none';
                containerQr.classList.add('show');
                // Automatically prompt/start scanner
                startCameraScanner();
            } else {
                btnQr.classList.remove('active');
                btnPassword.classList.add('active');
                containerQr.classList.remove('show');
                formPassword.style.display = 'block';
                stopCameraScanner();
            }
        }

        function setQrStatus(type, message) {
            const badge = document.getElementById('qrStatusBadge');
            badge.className = 'qr-status-badge ' + type;
            badge.innerHTML = message;
        }

        function onScanSuccess(decodedText) {
            console.log('Scanned QR:', decodedText);
            setQrStatus('success', '<i class="fa-solid fa-circle-check"></i> QR Code detected! Authenticating...');

            // If decoded text is full URL, extract token or redirect directly
            let token = decodedText.trim();
            if (token.includes('/qr/login/')) {
                const parts = token.split('/qr/login/');
                token = parts[parts.length - 1];
            } else if (token.includes('/')) {
                const parts = token.split('/');
                token = parts[parts.length - 1];
            }

            document.getElementById('manualQrToken').value = token;
            stopCameraScanner();

            // Submit form automatically
            document.getElementById('formQrTokenLogin').submit();
        }

        function startCameraScanner() {
            if (isCameraRunning) return;

            const placeholder = document.getElementById('scannerPlaceholder');
            const btnStart = document.getElementById('btnStartScanner');
            const btnStop = document.getElementById('btnStopScanner');

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("qr-reader");
            }

            setQrStatus('info', '<i class="fa-solid fa-spinner fa-spin"></i> Requesting camera access...');

            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 220, height: 220 }
                },
                onScanSuccess,
                (errorMessage) => {
                    // scanning in progress
                }
            ).then(() => {
                isCameraRunning = true;
                if (placeholder) placeholder.style.display = 'none';
                btnStart.style.display = 'none';
                btnStop.style.display = 'inline-flex';
                setQrStatus('info', '<i class="fa-solid fa-camera"></i> Camera active. Align QR code inside frame.');
            }).catch(err => {
                console.error('Camera start failed', err);
                isCameraRunning = false;
                setQrStatus('error', '<i class="fa-solid fa-triangle-exclamation"></i> Camera error: ' + (err.message || 'Permission denied. Please upload a QR image or enter token manually.'));
            });
        }

        function stopCameraScanner() {
            if (html5QrCode && isCameraRunning) {
                html5QrCode.stop().then(() => {
                    isCameraRunning = false;
                    const placeholder = document.getElementById('scannerPlaceholder');
                    const btnStart = document.getElementById('btnStartScanner');
                    const btnStop = document.getElementById('btnStopScanner');
                    if (placeholder) placeholder.style.display = 'block';
                    btnStart.style.display = 'inline-flex';
                    btnStop.style.display = 'none';
                }).catch(err => {
                    console.error('Stop scanner error:', err);
                });
            }
        }

        function scanQrFromFile(input) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            setQrStatus('info', '<i class="fa-solid fa-spinner fa-spin"></i> Reading QR from image: ' + file.name + '...');

            const scanner = new Html5Qrcode("qr-reader");
            scanner.scanFile(file, true)
                .then(decodedText => {
                    onScanSuccess(decodedText);
                })
                .catch(err => {
                    console.error('File scan error:', err);
                    setQrStatus('error', '<i class="fa-solid fa-xmark"></i> No valid QR code found in this image. Please try another image.');
                });
        }

        function toggleResendQrForm() {
            const form = document.getElementById('formResendQr');
            if (form) {
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            }
        }
    </script>
</body>
</html>
