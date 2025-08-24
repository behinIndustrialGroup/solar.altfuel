<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>انرژی خورشیدی | آینده‌ات را روشن کن</title>
  <!-- Tailwind (CDN for demo) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="{{ url('public/behin/behin-dist/dist/css/custom-style.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('public/behin/behin-dist/dist/css/custom.css') . '?' . config('app.version') }}">
  <style>
    /* فونت ایران‌سنس/پیش‌فرض */
    @font-face { font-family: IransansX; src: src: url('/public/behin/behin-dist/dist/fonts/Vazir.eot'); }
    html, body { font-family: Vazir, IransansX, Vazirmatn, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; }

    /* گرادیان پویا پس‌زمینه */
    .bg-animated {
      background: radial-gradient(60% 60% at 80% 20%, rgba(255, 234, 138, .55) 0%, rgba(255, 234, 138, 0) 60%),
                  radial-gradient(60% 60% at 20% 80%, rgba(134, 239, 172, .5) 0%, rgba(134, 239, 172, 0) 60%),
                  linear-gradient(135deg, #ecfccb 0%, #fef9c3 45%, #e0f2fe 100%);
      animation: moveGlow 12s ease-in-out infinite alternate;
    }
    @keyframes moveGlow {
      0% { background-position: 0% 0%, 100% 100%, 0% 0%; }
      100% { background-position: 20% -10%, 80% 120%, 100% 100%; }
    }

    /* کارت شیشه‌ای */
    .glass { backdrop-filter: blur(10px); background: rgba(255,255,255,.65); }

    /* خطوط تزئینی خورشیدی */
    .sunburst {
      background: conic-gradient(from 180deg at 50% 50%, rgba(255, 193, 7,.35), rgba(255, 193, 7, 0) 25%);
      mask: radial-gradient(circle at center, black 30%, transparent 31%);
    }

    .floating { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%,100% { transform: translateY(0) } 50% { transform: translateY(-8px) } }
  </style>
</head>
<body class="min-h-screen bg-animated">
  <!-- لایه‌های تزئینی -->
  <div aria-hidden="true" class="fixed inset-0 pointer-events-none select-none">
    <div class="absolute -top-16 -left-10 w-72 h-72 rounded-full sunburst opacity-40"></div>
    <div class="absolute -bottom-10 -right-10 w-80 h-80 rounded-full sunburst opacity-30"></div>
  </div>

  <!-- Hero -->
  <header class="relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-6">
      <nav class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <!-- لوگوی ساده خورشیدی -->
          <div class="w-10 h-10 rounded-xl bg-yellow-400/90 grid place-content-center shadow-md">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 4V2M12 22v-2M4 12H2M22 12h-2M5 5 3.5 3.5M20.5 20.5 19 19M5 19l-1.5 1.5M20.5 3.5 19 5" stroke="#78350f" stroke-width="1.6" stroke-linecap="round"/>
              <circle cx="12" cy="12" r="4.5" fill="#fde047" stroke="#f59e0b" stroke-width="1.2"/>
            </svg>
          </div>
          <span class="text-xl md:text-2xl font-extrabold text-gray-800">گروه صنعتی بهین انرژی</span>
        </div>
      </nav>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
      <div class="grid lg:grid-cols-2 gap-8 items-center">
        <!-- متن قهرمان -->
        <div class="space-y-5">
          <h1 class="text-3xl md:text-5xl font-black leading-[1.15] text-gray-900">
            خانه‌ات را با <span class="bg-gradient-to-r from-yellow-500 to-green-600 bg-clip-text text-transparent">انرژی خورشیدی</span>
            روشن کن.
          </h1>
          <p class="text-gray-700 md:text-lg leading-8">
            قبض برق کمتر، خانه‌ای سبزتر و خیالت راحت‌تر؛ ما مسیرت را از صفر تا نور همراهی می‌کنیم—مشاوره رایگان، طراحی هوشمند، نصب حرفه‌ای.
          </p>

          <!-- تنها دکمه صفحه -->
          <div>
            <a id="startBtn" href="#start" class="inline-flex items-center justify-center px-8 py-3 rounded-2xl text-base md:text-lg font-bold text-white bg-gradient-to-r from-green-600 to-yellow-500 shadow-lg shadow-yellow-500/30 hover:shadow-yellow-500/50 transition-transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-yellow-300">
              شروع کنید
              <svg class="ms-2" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>

          <div class="flex items-center gap-4 text-sm text-gray-600">
            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500"></span> صرفه‌جویی تا ۷۰٪</div>
            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> پشتیبانی ۲۴/۷</div>
            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> گارانتی واقعی</div>
          </div>
        </div>

        <!-- تصویر مفهومی پنل‌ها -->
        <div class="relative">
          <div class="glass rounded-3xl p-6 md:p-8 shadow-2xl floating">
            <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-gradient-to-tr from-sky-100 to-emerald-100 grid place-items-center">
              <!-- پنل خورشیدی SVG -->
              <svg viewBox="0 0 600 360" class="w-full h-full">
                <defs>
                  <linearGradient id="panel" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0%" stop-color="#c7eaff"/>
                    <stop offset="100%" stop-color="#a7f3d0"/>
                  </linearGradient>
                </defs>
                <!-- خورشید -->
                <circle cx="520" cy="60" r="40" fill="#fde047" stroke="#f59e0b" stroke-width="4" />
                <!-- زمین -->
                <rect x="0" y="260" width="600" height="120" fill="#bbf7d0" />
                <!-- پنل‌ها -->
                <g transform="translate(100,210) rotate(-12)">
                  <rect x="0" y="0" width="240" height="120" rx="10" fill="url(#panel)" stroke="#334155" stroke-width="6"/>
                  <!-- خانه‌های پنل -->
                  <g transform="translate(16,16)">
                    <!-- 3x5 grid -->
                    <g fill="#93c5fd" stroke="#1f2937" stroke-width="2" opacity=".9">
                      <!-- rows -->
                      <rect x="0" y="0" width="60" height="26"/>
                      <rect x="68" y="0" width="60" height="26"/>
                      <rect x="136" y="0" width="60" height="26"/>

                      <rect x="0" y="34" width="60" height="26"/>
                      <rect x="68" y="34" width="60" height="26"/>
                      <rect x="136" y="34" width="60" height="26"/>

                      <rect x="0" y="68" width="60" height="26"/>
                      <rect x="68" y="68" width="60" height="26"/>
                      <rect x="136" y="68" width="60" height="26"/>
                    </g>
                  </g>
                </g>
              </svg>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-3 text-center text-sm text-gray-700">
              <div class="bg-white/70 rounded-xl p-3 shadow">نصب سریع</div>
              <div class="bg-white/70 rounded-xl p-3 shadow">تضمین بازده</div>
              <div class="bg-white/70 rounded-xl p-3 shadow">پشتیبانی هوشمند</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  @yield('content')

  <footer class="relative z-10 border-t border-white/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-3 text-gray-600">
      <div>© <span id="year"></span> گروه صنعتی بهین انرژی — همه حقوق محفوظ است.</div>
      <div class="text-xs">طراحی با عشق به طبیعت و تکنولوژی ☀️</div>
    </div>
  </footer>

  <script>
    // سال جاری
    document.getElementById('year').textContent = new Date().getFullYear();

    // اسکرول نرم به بخش بعد از کلیک روی تنها دکمه
    document.getElementById('startBtn')?.addEventListener('click', function (e) {
      if (this.getAttribute('href') === '#start') {
        e.preventDefault();
        document.getElementById('start')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  </script>
</body>
</html>
