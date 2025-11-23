<!-- طراحی جدید صفحه تأیید کد یکبار مصرف به رنگ‌های آبی، بنفش و قرمز اتحادیه -->
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
        .container { max-width: 1100px; margin-inline:auto; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- HERO -->
    <header class="bg-gradient-to-br from-blue-600 via-purple-600 to-red-600 text-white py-16 shadow-xl">
        <div class="container px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold mb-4">تأیید کد یکبار مصرف</h1>
                    <p class="text-lg opacity-90 mb-6">برای ورود به سامانه NSIS، کد ارسال‌شده به شماره شما را وارد کنید.</p>

                    <!-- OTP FORM CARD -->
                    <div class="bg-white text-gray-800 p-6 rounded-2xl shadow-lg backdrop-blur">

                        <!-- Messages -->
                        <div class="space-y-2 mb-2">
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

                        <!-- OTP Input -->
                        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="phone" value="{{ $phone }}">

                            <label class="text-sm font-semibold">کد تأیید</label>
                            <input type="text" name="otp" placeholder="مثال: ۱۲۳۴۵۶" required autofocus
                                inputmode="numeric"
                                class="p-3 rounded-xl border text-center text-lg tracking-widest focus:ring-2 focus:ring-purple-500">

                            <button class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold hover:bg-purple-700 transition">
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
                </div>

            </div>
        </div>
    </header>


    <!-- INFO BOXES -->
    <main class="container px-6 py-14">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-semibold mb-2">کد یکبار مصرف چیست؟</h4>
                <p class="text-sm text-gray-600 leading-6">برای امنیت بیشتر، ورود به سیستم تنها با کد پیامکی معتبر انجام می‌شود.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-semibold mb-2">مشکل در دریافت کد؟</h4>
                <p class="text-sm text-gray-600 leading-6">پس از پایان شمارش معکوس می‌توانید دوباره درخواست ارسال کد دهید.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-semibold mb-2">حفظ اطلاعات</h4>
                <p class="text-sm text-gray-600 leading-6">تمام اطلاعات شما محرمانه است و فقط جهت ارتباط ضروری استفاده می‌شود.</p>
            </div>

        </div>
    </main>


    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-10 mt-10">
        <div class="container px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-bold mb-2">سامانه NSIS</h4>
                    <p class="text-sm opacity-80">سامانه رسمی اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته.</p>
                </div>
                <div>
                    <h5 class="font-semibold mb-2">تماس</h5>
                    <p class="text-sm opacity-80">تلفن: 02191017175</p>
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
