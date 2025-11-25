<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>سامانه جامع اطلاعات پروژه های خورشیدی NSIS</title>
    <script src="{{ url('behin/behin-dist/dist/js/tailwind-3.4.17.min.js') }}"></script>
    <link href="{{ url('behin/behin-dist/css/css2.css') }}?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        html, body { font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-600 via-purple-600 to-red-600 min-h-screen flex flex-col justify-between">

    <!-- Center Login Box -->
    <main class="flex-grow flex items-center justify-center px-4 py-10">
        <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-xl text-gray-800">

            <h1 class="text-2xl font-extrabold text-center mb-2">سامانه جامع اطلاعات پروژه‌های خورشیدی</h1>
            <h2 class="text-center text-sm text-gray-600 mb-8 tracking-wide">National Solar Information System</h2>

            <form method="POST" action="{{ route('otp.send') }}" class="flex flex-col gap-4">
                @csrf
                <label for="phone" class="text-sm font-semibold">شماره موبایل</label>
                <input type="text" name="phone" id="phone" dir="ltr" inputmode="numeric"
                    placeholder="مثال: 09123456789"
                    class="p-3 border rounded-lg text-center tracking-wide" required>

                <button
                    class="bg-purple-600 text-white py-3 rounded-lg font-bold hover:bg-purple-700 transition duration-200">
                    دریافت کد تأیید
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 mt-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>
                    <h3 class="font-bold text-lg mb-2">سامانه جامع اطلاعات خورشیدی NSIS</h3>
                    <p class="text-sm opacity-80 leading-6">سامانه رسمی اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته.</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-2">تماس</h4>
                    <p class="text-sm opacity-80 leading-6">تلفن: 02191013791</p>
                </div>
            </div>

            <div class="text-center text-sm text-gray-400 mt-8">© تمامی حقوق متعلق به اتحادیه کشوری سوخت‌های جایگزین و خدمات وابسته است.</div>
        </div>
    </footer>

</body>
</html>