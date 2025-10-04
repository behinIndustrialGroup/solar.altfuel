@extends('behin-layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100">
    <div class="max-w-5xl mx-auto px-6 py-12">
        <div class="mb-8 flex flex-col gap-3 text-center">
            <span class="mx-auto inline-flex items-center gap-2 rounded-full bg-indigo-100 px-4 py-1 text-xs font-semibold text-indigo-700 shadow-sm">
                <span class="text-base">🛠️</span>
                Material Settings Panel
            </span>
            <h1 class="text-3xl font-black text-slate-800 md:text-4xl">پیکربندی اتصال AMI</h1>
            <p class="text-sm text-slate-500 md:text-base">جزئیات اتصال Asterisk Manager Interface را با الهام از متریال دیزاین مدیریت کنید.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-5">
            <div class="md:col-span-3">
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-indigo-50">
                    <div class="relative h-28 bg-gradient-to-r from-indigo-500 via-indigo-600 to-purple-500">
                        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 10% 20%, rgba(255,255,255,.45), transparent 45%), radial-gradient(circle at 80% 30%, rgba(255,255,255,.4), transparent 40%);"></div>
                        <div class="flex h-full items-center justify-between px-8">
                            <div class="text-white">
                                <p class="text-xs uppercase tracking-widest text-indigo-100">AMI</p>
                                <h2 class="text-2xl font-semibold">Connection Settings</h2>
                            </div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 backdrop-blur">
                                <span class="text-2xl text-white">⚙️</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 pb-10 pt-12">
                        @if(session('status'))
                            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">
                                <span class="text-lg">✅</span>
                                <span>{{ session('status') }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('ami.settings.store') }}" class="space-y-7">
                            @csrf

                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="group">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Host</label>
                                    <div class="relative mt-2">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.5a.375.375 0 01.375-.375h3.75a.375.375 0 01.375.375v4.5h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                                            </svg>
                                        </span>
                                        <input
                                            type="text"
                                            name="host"
                                            value="{{ old('host', $setting->host ?? '127.0.0.1') }}"
                                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-11 py-3 text-slate-700 shadow-inner transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                            placeholder="مانند 127.0.0.1"
                                        />
                                    </div>
                                    <p class="mt-2 text-xs text-slate-400">آدرس سرور Asterisk خود را وارد کنید.</p>
                                </div>

                                <div class="group">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Port</label>
                                    <div class="relative mt-2">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12a9.75 9.75 0 0119.5 0v.75m-16.5 0a3 3 0 016 0v.75m-6 0a3 3 0 006 0" />
                                            </svg>
                                        </span>
                                        <input
                                            type="text"
                                            name="port"
                                            value="{{ old('port', $setting->port ?? 5038) }}"
                                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-11 py-3 text-slate-700 shadow-inner transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                            placeholder="مانند 5038"
                                        />
                                    </div>
                                    <p class="mt-2 text-xs text-slate-400">پورت پیش‌فرض AMI معمولاً ۵۰۳۸ است.</p>
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Username</label>
                                <div class="relative mt-2">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </span>
                                    <input
                                        type="text"
                                        name="username"
                                        value="{{ old('username', $setting->username ?? '') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-11 py-3 text-slate-700 shadow-inner transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                        placeholder="نام کاربری مدیریتی"
                                    />
                                </div>
                                <p class="mt-2 text-xs text-slate-400">نام کاربری‌ای که در فایل <code class="rounded bg-slate-100 px-2 py-0.5 text-[10px] text-slate-600">manager.conf</code> تعریف کرده‌اید.</p>
                            </div>

                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Password</label>
                                <div class="relative mt-2">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0V10.5M5.25 21h13.5a1.5 1.5 0 001.5-1.5v-6.75a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5V19.5A1.5 1.5 0 005.25 21z" />
                                        </svg>
                                    </span>
                                    <input
                                        type="password"
                                        name="password"
                                        value="{{ old('password', $setting->password ?? '') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-11 py-3 text-slate-700 shadow-inner transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                        placeholder="رمز عبور قدرتمند"
                                    />
                                </div>
                                <p class="mt-2 text-xs text-slate-400">برای امنیت بیشتر، رمز عبور قوی انتخاب کنید.</p>
                            </div>

                            <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-xs text-slate-400">
                                    آخرین بروزرسانی: <span class="font-semibold text-slate-600">{{ now()->format('Y/m/d H:i') }}</span>
                                </div>
                                <button type="submit" class="group relative inline-flex items-center justify-center overflow-hidden rounded-2xl bg-indigo-600 px-7 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-indigo-700 hover:shadow-xl">
                                    <span class="absolute inset-0 h-full w-full scale-0 rounded-full bg-white opacity-20 transition duration-300 group-hover:scale-100"></span>
                                    <span class="relative flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        ذخیره تنظیمات
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="flex h-full flex-col justify-between gap-6 rounded-3xl border border-indigo-100 bg-white/60 p-8 shadow-lg backdrop-blur">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-800">راهنمای اتصال سریع</h3>
                        <p class="text-sm leading-6 text-slate-500">برای برقراری ارتباط موفق با Asterisk Manager Interface مراحل زیر را بررسی کنید:</p>
                        <ul class="space-y-3 text-sm text-slate-600">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-6 w-6 flex-none rounded-full bg-indigo-100 text-center text-sm font-semibold text-indigo-600">1</span>
                                <span>اطمینان حاصل کنید که سرویس <span class="font-semibold">manager</span> در سرور فعال باشد.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-6 w-6 flex-none rounded-full bg-indigo-100 text-center text-sm font-semibold text-indigo-600">2</span>
                                <span>دسترسی IP سرور این برنامه را در فایل <code class="rounded bg-slate-100 px-2 py-0.5 text-[10px] text-slate-600">manager.conf</code> تعریف کنید.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-6 w-6 flex-none rounded-full bg-indigo-100 text-center text-sm font-semibold text-indigo-600">3</span>
                                <span>پس از اعمال تغییرات، سرویس Asterisk را برای اعمال تنظیمات مجدداً بارگذاری کنید.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-500 p-6 text-white shadow-xl">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l8.25-8.25a1.5 1.5 0 012.121 0L21 13.5M4.5 12v7.125c0 .621.504 1.125 1.125 1.125H9.75v-3.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v3.75h4.125c.621 0 1.125-.504 1.125-1.125V12" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-widest text-indigo-100">Connection Health</p>
                                <p class="text-base font-semibold">{{ $setting?->host ?? '---' }} : {{ $setting?->port ?? '---' }}</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-indigo-100/90">در صورت بروز خطا در اتصال، دسترسی شبکه و صحت اطلاعات کاربری را بررسی کنید.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
