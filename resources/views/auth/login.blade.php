<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ستاپ — سامانه تأمین و اجرای پروژه‌های خورشیدی</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
  <style>html,body{font-family: 'Vazirmatn', sans-serif;} .container{max-width:1200px;margin-inline:auto}</style>
</head>
<body class="bg-gray-50 text-gray-800">
  <!-- Hero -->
  <header class="bg-gradient-to-l from-yellow-400 via-yellow-300 to-amber-400 text-gray-900">
    <div class="container px-6 py-12">
      <div class="flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
          <h1 class="text-3xl md:text-4xl font-bold mb-3">ستاپ — سامانه تأمین و اجرای پروژه‌های خورشیدی</h1>
          <p class="mb-6 text-lg md:text-xl">ما متقاضیان نصب پنل خورشیدی را به پیمانکاران معتبر در سراسر ایران وصل می‌کنیم، تسهیلات مالی فراهم می‌کنیم و از آغاز تا تحویل پروژه همراه شما هستیم.</p>
          <div class="flex flex-wrap gap-3">
        <!-- فرم لاگین -->
        <form
        id="login-form"
        method="POST"
        action="{{ route('otp.send') }}"
        class="flex flex-col sm:flex-row sm:items-center gap-2 bg-white p-3 rounded-lg shadow w-full"
      >
        @csrf
        <input
          type="text"
          name="phone"
          class="w-full sm:flex-1 p-2 border rounded text-center sm:text-right"
          id="inputMobile"
          placeholder="شماره موبایل"
          required
          dir="ltr"
          inputmode="numeric"
          autofocus
        >
        <button
          type="submit"
          class="w-full sm:w-auto bg-gray-900 text-white px-4 py-2 rounded-lg"
        >
          ورود
        </button>
      </form>  
        </div>
          <!-- stats -->
          <div class="mt-8 grid grid-cols-3 gap-4 md:grid-cols-3">
            <div class="bg-white/70 p-4 rounded-lg text-center shadow">
              <div class="text-sm">ظرفیت نصب‌شده</div>
              <div class="text-2xl font-bold">۱.۷ مگاوات</div>
            </div>
            <div class="bg-white/70 p-4 rounded-lg text-center shadow">
              <div class="text-sm">پیمانکار در سراسر ایران</div>
              <div class="text-2xl font-bold">بله</div>
            </div>
            <div class="bg-white/70 p-4 rounded-lg text-center shadow">
              <div class="text-sm">پروژه‌های تکمیل‌شده</div>
              <div class="text-2xl font-bold">—</div>
            </div>
          </div>
        </div>
        <div class="flex-1">
          <div class="rounded-xl overflow-hidden shadow-lg bg-white">
            <img src="https://images.unsplash.com/photo-1509395176047-4a66953fd231?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=placeholder" alt="پنل خورشیدی" class="w-full h-64 object-cover">
            <div class="p-4">
              <h3 class="font-bold mb-2">آغاز پروژه در ۳ مرحله ساده</h3>
              <ol class="list-decimal pr-4 space-y-2 text-sm">
                <li>درخواست آنلاین ثبت کنید</li>
                <li>پیمانکار مناسب معرفی می‌شود</li>
                <li>تأمین مالی و اجرای پروژه</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="container px-6 py-12">
    <!-- Features -->
    <section class="mb-12">
      <h2 class="text-2xl font-bold mb-4">ویژگی‌های اصلی ستاپ</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
          <h4 class="font-semibold mb-2">شبکه گسترده پیمانکاران</h4>
          <p class="text-sm">دسترسی به پیمانکاران معتبر و تایید‌شده در تمامی استان‌های ایران.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h4 class="font-semibold mb-2">تسهیلات مالی</h4>
          <p class="text-sm">امکان دریافت پیشنهادات مالی و تسهیلات برای نصب و راه‌اندازی نیروگاه.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h4 class="font-semibold mb-2">پشتیبانی فنی و مدیریتی</h4>
          <p class="text-sm">پیگیری پروژه از آغاز تا تحویل و تضمین کیفیت اجرا.</p>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section id="how" class="mb-12">
      <h2 class="text-2xl font-bold mb-4">نحوه کار</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow">
          <div class="text-xl font-bold mb-2">۱. ثبت درخواست</div>
          <p class="text-sm">فرم کوتاه را پر کنید تا تیم ما نیاز شما را بررسی کند.</p>
        </div>
        <div class="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow">
          <div class="text-xl font-bold mb-2">۲. انتخاب پیمانکار</div>
          <p class="text-sm">پیمانکاران واجد شرایط با شما تماس می‌گیرند و پیشنهاد ارسال می‌کنند.</p>
        </div>
        <div class="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow">
          <div class="text-xl font-bold mb-2">۳. اجرا و پشتیبانی</div>
          <p class="text-sm">تامین مالی، اجرا و تست نهایی تا تحویل نهایی پروژه.</p>
        </div>
      </div>
    </section>

    <!-- Map / contractors -->
    {{-- <section class="mb-12">
      <h2 class="text-2xl font-bold mb-4">پیمانکاران در سراسر ایران</h2>
      <div class="bg-white rounded-lg shadow overflow-hidden p-6">
        <div class="h-64 md:h-96 bg-gray-200 rounded-lg flex items-center justify-center">نقشه / ویجت نمایش پیمانکاران (قابل اتصال به گوگل مپز یا نقشه داخلی)</div>
        <p class="text-sm mt-3">ما با شبکه‌ای از پیمانکاران در تمامی استان‌ها همکاری می‌کنیم — در هر شهر یک شریک محلی برای اجرا.</p>
      </div>
    </section> --}}

    <!-- Testimonials / numbers -->
    {{-- <section class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="font-bold mb-2">اعداد و واقعیت‌ها</h3>
        <ul class="space-y-3 text-sm">
          <li>ظرفیت نصب‌شده: <strong>۱.۷ مگاوات</strong></li>
          <li>پیمانکاران فعال: <strong>در سراسر ایران</strong></li>
          <li>پروژه‌های موفق: <strong>در حال افزایش</strong></li>
        </ul>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="font-bold mb-2">نظرات مشتریان</h3>
        <blockquote class="text-sm italic">"اجرای پروژه ما سریع و دقیق انجام شد — از تیم ستاپ ممنونیم." — مشتری نمونه</blockquote>
      </div>
    </section> --}}

    <!-- Contact / CTA form -->
    {{-- <section id="contact" class="mb-12 bg-white p-6 rounded-lg shadow">
      <h2 class="text-2xl font-bold mb-4">درخواست مشاوره</h2>
      <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input placeholder="نام و نام خانوادگی" class="p-3 border rounded" />
        <input placeholder="شماره تماس" class="p-3 border rounded" />
        <input placeholder="شهر" class="p-3 border rounded" />
        <select class="p-3 border rounded">
          <option>نوع درخواست: نصب خانگی</option>
          <option>نوع درخواست: نصب تجاری</option>
        </select>
        <textarea placeholder="توضیحات کوتاه (اختیاری)" class="p-3 border rounded md:col-span-2"></textarea>
        <div class="md:col-span-2 flex justify-start">
          <button type="submit" class="px-6 py-2 bg-amber-500 rounded-lg text-white font-semibold">ارسال درخواست</button>
        </div>
      </form>
    </section> --}}

  </main>

  <footer class="bg-gray-900 text-white py-8">
    <div class="container px-6">
      <div class="flex flex-col md:flex-row justify-between items-start gap-6">
        <div>
          <h4 class="font-bold mb-2">ستاپ</h4>
          <p class="text-sm">سامانه تأمین و اجرای پروژه‌های خورشیدی — اتصال متقاضیان به پیمانکاران و ارائه تسهیلات مالی.</p>
        </div>
        <div>
          <h5 class="font-semibold mb-2">تماس</h5>
          <p class="text-sm">ایمیل: info@setap.example</p>
          <p class="text-sm">تلفن: ۰۲۱-xxxxxxx</p>
        </div>
      </div>
      <div class="text-sm text-gray-400 mt-6">© تمامی حقوق برای ستاپ محفوظ است.</div>
    </div>
  </footer>

</body>
</html>
