<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ستاپ — سامانه تأمین و اجرای پروژه‌های خورشیدی</title>
    <link href="{{ url('behin/behin-dist/css/css2.css') }}?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/login.jsx'])
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div id="login-root"
        data-login-url="{{ route('login') }}"
        data-dashboard-url="{{ route('admin.dashboard') }}"
        @if (Route::has('password.request')) data-forgot-password-url="{{ route('password.request') }}" @endif
        @if (Route::has('register')) data-register-url="{{ route('register') }}" @endif
        @if (Route::has('otp.view')) data-otp-url="{{ route('otp.view') }}" @endif
        data-hero-image="{{ url('behin/home-1.jpg') }}">
    </div>
</body>

</html>
