<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>سامانه جامع اطلاعات خورشیدی NSIS</title>
    <script src="{{ url('behin/behin-dist/dist/js/tailwind-3.4.17.min.js') }}"></script>
    <link href="{{ url('behin/behin-dist/css/css2.css') }}?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        html, body { font-family: 'Vazirmatn', sans-serif; }
        .container { max-width: 1250px; margin-inline: auto }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Hero Section -->
    <header class="bg-gradient-to-br from-blue-600 via-purple-600 to-red-600 text-white py-20 shadow-lg">
        <div class="container px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <!-- Text -->
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-snug mb-4">
                        سامانه جامع اطلاعات خورشیدی NSIS
                    </h1>
                    <p class="text-lg md:text-xl opacity-90 mb-6">
                        سامانه جامع اطلاعات پروژه های خورشیدی
                    </p>

                    <a href="{{ route('login') }}">
                        <button class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">
                            ورود
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </header>


    <!-- Features Section -->
    {{-- <section class="container px-6 py-16">
        <h2 class="text-3xl font-bold mb-10 text-gray-800 text-center">چرا NSIS؟</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="font-bold text-lg mb-2">بانک اطلاعات خورشیدی</h3>
                <p class="text-sm text-gray-600">مرجع رسمی داده‌ها، ظرفیت‌ها و اطلاعات پروژه‌های خورشیدی کشور.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="font-bold text-lg mb-2">سامانه خدمات یکپارچه</h3>
                <p class="text-sm text-gray-600">ثبت و پیگیری هوشمند درخواست‌های مردمی، سازمانی و صنفی.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="font-bold text-lg mb-2">شبکه ملی پیمانکاران</h3>
                <p class="text-sm text-gray-600">اتصال مستقیم به پیمانکاران دارای تاییدیه اتحادیه.</p>
            </div>
        </div>
    </section> --}}


    <!-- Process Section -->
    {{-- <section class="bg-gray-100 py-16">
        <div class="container px-6">
            <h2 class="text-3xl font-bold mb-10 text-center">نحوه عملکرد سامانه</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow text-center">
                    <div class="text-3xl font-extrabold text-purple-600 mb-3">۱</div>
                    <h4 class="font-bold mb-2">ثبت اطلاعات</h4>
                    <p class="text-sm text-gray-600">کاربر، کسب‌وکار یا پیمانکار اطلاعات یا درخواست خود را وارد می‌کند.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow text-center">
                    <div class="text-3xl font-extrabold text-blue-600 mb-3">۲</div>
                    <h4 class="font-bold mb-2">بررسی کارشناسی</h4>
                    <p class="text-sm text-gray-600">اطلاعات توسط کارشناسان اتحادیه ارزیابی و پردازش می‌شود.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow text-center">
                    <div class="text-3xl font-extrabold text-red-600 mb-3">۳</div>
                    <h4 class="font-bold mb-2">اقدام و نتیجه</h4>
                    <p class="text-sm text-gray-600">معرفی پیمانکار، ثبت نهایی، پیگیری یا انجام فرایند مرتبط.</p>
                </div>
            </div>
        </div>
    </section> --}}


    <!-- Registration Boxes -->
    {{-- <section class="container px-6 py-16">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">ثبت‌نام‌ها</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <a href="{{ route('installers.apply') }}" class="block p-6 rounded-xl border bg-blue-50 border-blue-200 shadow hover:shadow-lg transition group text-center">
                <div class="text-blue-600 text-4xl mb-3 group-hover:scale-110 transition">🔧</div>
                <div class="font-bold text-lg">ثبت‌نام پیمانکاران</div>
                <p class="text-sm text-gray-600 mt-2">پیوستن به شبکه رسمی پیمانکاران خورشیدی کشور.</p>
            </a>

            <a href="{{ route('landing.sme-registration') }}" class="block p-6 rounded-xl border bg-purple-50 border-purple-200 shadow hover:shadow-lg transition group text-center">
                <div class="text-purple-600 text-4xl mb-3 group-hover:scale-110 transition">🏪</div>
                <div class="font-bold text-lg">ثبت‌نام اصناف</div>
                <p class="text-sm text-gray-600 mt-2">استفاده از خدمات و زیرساخت انرژی خورشیدی.</p>
            </a>
        </div>
    </section> --}}


    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 mt-16">
        <div class="container px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-2">سامانه جامع اطلاعات خورشیدی NSIS</h3>
                    <p class="text-sm opacity-80">سامانه رسمی اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته.</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-2">تماس</h4>
                    <p class="text-sm opacity-80">تلفن: 02191013791</p>
                </div>
            </div>
            <div class="text-center text-sm text-gray-400 mt-8">© تمامی حقوق متعلق به اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته است.</div>
        </div>
    </footer>

</body>
</html>