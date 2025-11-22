<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('behin/logo.ico') . '?' . config('app.version') }}">
    <title>سامانه جامع اطلاعات خورشیدی NSIS</title>
    <script src="{{ url('behin/behin-dist/dist/js/tailwind-3.4.17.min.js') }}"></script>
    <link href="{{ url('behin/behin-dist/css/css2.css') }}?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        html, body { font-family: 'Vazirmatn', sans-serif; }
        .container { max-width: 1200px; margin-inline: auto }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Hero -->
    <header class="bg-gradient-to-l from-yellow-400 via-yellow-300 to-amber-400 text-gray-900">
        <div class="container px-6 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">سامانه جامع اطلاعات خورشیدی NSIS</h1>
                    <p class="mb-6 text-lg md:text-xl">
                        این سامانه زیر نظر اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته طراحی شده و مرجع رسمی اطلاعات، ثبت درخواست‌ها و مدیریت پروژه‌های خورشیدی در کشور است.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <!-- فرم لاگین -->
                        <form id="login-form" method="POST" action="{{ route('otp.send') }}"
                            class="flex flex-col sm:flex-row sm:items-center gap-2 bg-white p-3 rounded-lg shadow w-full">
                            @csrf
                            <input type="text" name="phone"
                                class="w-full sm:flex-1 p-2 border rounded text-center sm:text-right"
                                id="inputMobile" placeholder="شماره موبایل" required dir="ltr" inputmode="numeric" autofocus>
                            <button type="submit" class="w-full sm:w-auto bg-gray-900 text-white px-4 py-2 rounded-lg">
                                ورود
                            </button>
                        </form>
                    </div>

                    <!-- stats -->
                    <div class="mt-8 grid grid-cols-3 gap-4 md:grid-cols-3">
                        <div class="bg-white/70 p-4 rounded-lg text-center shadow">
                            <div class="text-sm">ظرفیت ثبت‌شده</div>
                            <div class="text-2xl font-bold">۱۹ مگاوات</div>
                        </div>
                        <div class="bg-white/70 p-4 rounded-lg text-center shadow">
                            <div class="text-sm">پیمانکاران ثبت‌شده</div>
                            <div class="text-2xl font-bold">سراسر کشور</div>
                        </div>
                        <div class="bg-white/70 p-4 rounded-lg text-center shadow">
                            <div class="text-sm">پروژه‌های تکمیل‌شده</div>
                            <div class="text-2xl font-bold">۵۶</div>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="rounded-xl overflow-hidden shadow-lg bg-white">
                        <img src="{{ url('behin/slide1.png') }}" alt="پنل خورشیدی" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold mb-2">فعالیت‌ها در ۳ مرحله ساده</h3>
                            <ol class="list-decimal pr-4 space-y-2 text-sm mb-6">
                                <li>ثبت درخواست یا اطلاعات</li>
                                <li>بررسی و معرفی پیمانکار یا مرجع مرتبط</li>
                                <li>پیگیری، نظارت و تکمیل فرآیند</li>
                            </ol>

                            <!-- باکس‌های ثبت‌نام -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- باکس ثبت‌نام پیمانکار -->
                                <a href="{{ route('installers.apply') }}"
                                    class="group block p-4 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 transition-all duration-300 text-center shadow-sm hover:shadow-md">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-amber-400 text-white p-2 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-solar-panel text-xl"></i>
                                        </div>
                                        <div class="font-bold text-gray-800">ثبت‌نام پیمانکاران</div>
                                        <div class="text-xs text-gray-600 mt-1">پیوستن به شبکه رسمی اتحادیه</div>
                                    </div>
                                </a>

                                <!-- باکس ثبت‌نام کسب‌وکارها -->
                                <a href="{{ route('landing.sme-registration') }}"
                                    class="group block p-4 rounded-lg border border-yellow-300 bg-yellow-50 hover:bg-yellow-100 transition-all duration-300 text-center shadow-sm hover:shadow-md">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-yellow-400 text-white p-2 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-store text-xl"></i>
                                        </div>
                                        <div class="font-bold text-gray-800">ثبت‌نام اصناف</div>
                                        <div class="text-xs text-gray-600 mt-1">دریافت خدمات و توسعه انرژی خورشیدی</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <main class="container px-6 py-12">
        <!-- Features -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-4">ویژگی‌های اصلی سامانه NSIS</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h4 class="font-semibold mb-2">بانک جامع اطلاعاتی</h4>
                    <p class="text-sm">دسترسی به اطلاعات و آمار رسمی حوزه خورشیدی کشور.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h4 class="font-semibold mb-2">سامانه یکپارچه خدمات</h4>
                    <p class="text-sm">ثبت، پیگیری و مدیریت درخواست‌های مردمی و صنفی.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h4 class="font-semibold mb-2">شبکه سراسری پیمانکاران</h4>
                    <p class="text-sm">معرفی پیمانکاران تاییدشده توسط اتحادیه کشوری.</p>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section id="how" class="mb-12">
            <h2 class="text-2xl font-bold mb-4">نحوه کار</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow">
                    <div class="text-xl font-bold mb-2">۱. ثبت</div>
                    <p class="text-sm">کاربر یا پیمانکار درخواست یا اطلاعات خود را وارد می‌کند.</p>
                </div>
                <div class="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow">
                    <div class="text-xl font-bold mb-2">۲. بررسی</div>
                    <p class="text-sm">اتحادیه و کارشناسان مربوطه موضوع را ارزیابی می‌کنند.</p>
                </div>
                <div class="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow">
                    <div class="text-xl font-bold mb-2">۳. اقدام</div>
                    <p class="text-sm">معرفی پیمانکار، صدور مجوز، یا انجام فرآیند مرتبط.</p>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container px-6">
            <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                <div>
                    <h4 class="font-bold mb-2">سامانه جامع اطلاعات خورشیدی NSIS</h4>
                    <p class="text-sm">مرجع رسمی اطلاعات و خدمات حوزه انرژی خورشیدی تحت نظارت اتحادیه کشوری سوخت‌های جایگزین.</p>
                </div>
                <div>
                    <h5 class="font-semibold mb-2">تماس</h5>
                    <p class="text-sm">تلفن: 02191307571</p>
                </div>
            </div>

            <div class="text-sm text-gray-400 mt-6">
                © تمامی حقوق برای اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته محفوظ است.
            </div>
        </div>
    </footer>
</body>
</html>
