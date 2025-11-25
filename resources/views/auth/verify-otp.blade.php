<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>تأیید کد یکبار مصرف — NSIS</title>
    <script src="{{ url('behin/behin-dist/dist/js/tailwind-3.4.17.min.js') }}"></script>
    <link href="{{ url('behin/behin-dist/css/css2.css') }}?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        html, body { font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-600 via-purple-600 to-red-600 min-h-screen flex flex-col justify-between text-gray-800">

    <!-- Center OTP Box -->
    <main class="flex-grow flex items-center justify-center px-4 py-10">
        <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-xl text-gray-800">

            <h1 class="text-2xl font-extrabold text-center mb-2">تأیید کد یکبار مصرف</h1>
            <h2 class="text-center text-sm text-gray-600 mb-8 tracking-wide">National Solar Information System — NSIS</h2>

            <!-- Messages -->
            <div class="space-y-2 mb-4">
                @if (session('success'))
                    <div class="rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="rounded-lg bg-red-100 text-red-800 px-4 py-3 text-sm">{{ session('error') }}</div>
                @endif
                @isset($error)
                    <div class="rounded-lg bg-red-100 text-red-800 px-4 py-3 text-sm">{{ $error }}</div>
                @endisset
            </div>

            <!-- OTP Input Form -->
            <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">

                <label class="text-sm font-semibold">کد تأیید</label>
                <input type="text" name="otp" placeholder="مثال: ۱۲۳۴۵۶" required autofocus inputmode="numeric"
                    class="p-3 rounded-xl border text-center text-lg tracking-widest focus:ring-2 focus:ring-purple-500">

                <button
                    class="w-full bg-purple-600 text-white py-3 rounded-xl font-bold hover:bg-purple-700 transition duration-200">
                    تأیید و ورود
                </button>
            </form>

            <!-- RESEND -->
            <form method="POST" action="{{ route('otp.send') }}" class="mt-3">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">
                <button id="resendBtn" disabled
                    class="w-full border border-gray-300 text-gray-700 py-3 rounded-xl font-semibold disabled:opacity-60">
                    ارسال مجدد کد (60)
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 mt-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-bold text-lg mb-2">سامانه NSIS</h4>
                    <p class="text-sm opacity-80 leading-6">سامانه رسمی اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته.</p>
                </div>
                <div>
                    <h5 class="font-semibold mb-2">تماس</h5>
                    <p class="text-sm opacity-80 leading-6">تلفن: 02191017175</p>
                </div>
            </div>
            <p class="text-center text-sm text-gray-400 mt-8">© تمامی حقوق متعلق به اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendBtn = document.getElementById('resendBtn');
            let counter = 60;
            const timer = setInterval(() => {
                counter--;
                resendBtn.textContent = `ارسال مجدد کد (${counter})`;
                if (counter <= 0) {
                    clearInterval(timer);
                    resendBtn.textContent = 'ارسال مجدد کد';
                    resendBtn.disabled = false;
                }
            }, 1000);
        });
    </script>

</body>
</html>