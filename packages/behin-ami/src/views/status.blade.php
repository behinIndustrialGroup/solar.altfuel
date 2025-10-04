@extends('behin-layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-100">
    <div class="max-w-5xl mx-auto px-6 py-12">
        <div class="mb-8 flex flex-col gap-3 text-center">
            <span class="mx-auto inline-flex items-center gap-2 rounded-full bg-slate-900/5 px-4 py-1 text-xs font-semibold text-slate-700 shadow-sm">
                <span class="text-base">📞</span>
                Material Status Dashboard
            </span>
            <h1 class="text-3xl font-black text-slate-800 md:text-4xl">وضعیت داخلی‌ها</h1>
            <p class="text-sm text-slate-500 md:text-base">رصد لحظه‌ای سلامت داخلی‌های Asterisk با سبک متریال دیزاین.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div class="overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-indigo-50">
                    <div class="relative h-24 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600">
                        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,.45), transparent 45%), radial-gradient(circle at 70% 30%, rgba(255,255,255,.3), transparent 40%);"></div>
                        <div class="flex h-full items-center justify-between px-8">
                            <div class="text-white">
                                <p class="text-xs uppercase tracking-[0.35em] text-indigo-100">Extensions</p>
                                <h2 class="text-2xl font-semibold">Real-time Availability</h2>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white backdrop-blur">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.5l8.954 4.477a1.125 1.125 0 001.012 0L21.75 7.5m-19.5 9l8.954 4.477a1.125 1.125 0 001.012 0L21.75 16.5m-19.5-4.5l8.954 4.477a1.125 1.125 0 001.012 0L21.75 12" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-8 pt-10">
                        <div class="flex items-center justify-between pb-4 text-xs font-medium uppercase tracking-[0.3em] text-slate-400">
                            <span>Extension</span>
                            <span>Status</span>
                        </div>

                        <div class="space-y-3">
                            @forelse($peers as $peer)
                                @php
                                    $isOnline = str_contains(strtolower($peer['status']), 'ok');
                                @endphp
                                <div class="group flex items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 px-5 py-4 shadow-sm transition hover:border-indigo-200 hover:bg-white hover:shadow-md">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-500/10 text-indigo-600">
                                            <span class="text-lg font-semibold">{{ $peer['objectname'] }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-700">داخلی {{ $peer['objectname'] }}</p>
                                            <p class="text-xs text-slate-400">{{ $peer['ipaddress'] ?? 'بدون IP ثبت شده' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $isOnline ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                            <span class="h-2 w-2 rounded-full {{ $isOnline ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            {{ $isOnline ? 'Online' : 'Offline' }}
                                        </span>
                                        <div class="text-right text-[11px] text-slate-400">
                                            <p>Last Response</p>
                                            <p class="font-semibold text-slate-500">{{ $peer['status'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-white px-6 py-10 text-center text-sm text-slate-400">
                                    اطلاعاتی برای نمایش وجود ندارد.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="flex h-full flex-col gap-6 rounded-3xl border border-indigo-100 bg-white/70 p-8 shadow-lg backdrop-blur">
                    <div class="rounded-2xl bg-gradient-to-r from-emerald-400 via-emerald-500 to-emerald-600 p-6 text-white shadow-xl">
                        <p class="text-xs uppercase tracking-[0.35em] text-emerald-100">Health Overview</p>
                        <div class="mt-4 flex items-end justify-between">
                            @php
                                $onlineCount = collect($peers)->filter(fn($peer) => str_contains(strtolower($peer['status']), 'ok'))->count();
                                $total = count($peers);
                            @endphp
                            <div>
                                <p class="text-4xl font-black">{{ $onlineCount }}</p>
                                <p class="text-sm text-emerald-100">داخلی آنلاین</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-semibold">{{ $total }}</p>
                                <p class="text-xs text-emerald-100/80">کل داخلی‌ها</p>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-emerald-100/80">به‌روزرسانی صفحه برای دریافت آخرین وضعیت‌ها را فراموش نکنید.</p>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-800">گزارش سریع</h3>
                        <ul class="space-y-3 text-sm text-slate-600">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-6 w-6 flex-none rounded-full bg-indigo-100 text-center text-sm font-semibold text-indigo-600">1</span>
                                <span>برای داخلی‌های آفلاین، اتصال شبکه و ثبت نام کاربر در سرور را بررسی کنید.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-6 w-6 flex-none rounded-full bg-indigo-100 text-center text-sm font-semibold text-indigo-600">2</span>
                                <span>اطمینان حاصل کنید که فایروال مانعی برای ارتباطات SIP ایجاد نکرده باشد.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-6 w-6 flex-none rounded-full bg-indigo-100 text-center text-sm font-semibold text-indigo-600">3</span>
                                <span>از طریق کنسول Asterisk دستور <code class="rounded bg-slate-100 px-2 py-0.5 text-[10px] text-slate-600">sip show peers</code> را اجرا کنید.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/60 p-6 text-sm text-indigo-700">
                        <p class="font-semibold">راهنمای بروزرسانی خودکار</p>
                        <p class="mt-2 text-xs leading-6">برای دریافت وضعیت لحظه‌ای، از سرویس‌های به‌روزرسانی خودکار یا Push Notifications استفاده کنید و این داشبورد را در مانیتورینگ داخلی‌ها به‌کار گیرید.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
