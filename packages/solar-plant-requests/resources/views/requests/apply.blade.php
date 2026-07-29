<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('behin/logo.ico') . '?' . config('app.version') }}">
    <title>ثبت درخواست نیروگاه خورشیدی</title>
    <script src="{{ url('behin/behin-dist/dist/js/tailwind-3.4.17.min.js') }}"></script>
    <link href="{{ url('behin/behin-dist/css/css2.css') }}?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            font-family: 'Vazirmatn', sans-serif;
        }

        .container {
            max-width: 900px;
            margin-inline: auto;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .step-indicator {
            transition: all 0.3s ease;
        }

        .step-indicator.active {
            background-color: #f59e0b;
            color: white;
        }

        .step-indicator.completed {
            background-color: #22c55e;
            color: white;
        }

        .step-connector {
            transition: background-color 0.3s ease;
        }

        .step-connector.active {
            background-color: #22c55e;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">
    <header class="bg-gradient-to-l from-amber-400 via-yellow-300 to-lime-300 text-gray-900">
        <div class="container px-6 py-8">
            <h1 class="text-2xl md:text-3xl font-bold">ثبت درخواست نیروگاه خورشیدی</h1>
            <p class="mt-2 text-sm md:text-base">لطفاً اطلاعات زیر را در ۴ مرحله تکمیل کنید.</p>
        </div>
    </header>

    <main class="container px-6 py-8">
        {{-- Progress Indicator --}}
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center gap-2">
                <div id="indicator-1" class="step-indicator active w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-2 border-amber-500">۱</div>
                <div id="connector-1" class="step-connector w-16 h-1 bg-gray-300 rounded"></div>
                <div id="indicator-2" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-2 border-gray-300 text-gray-400">۲</div>
                <div id="connector-2" class="step-connector w-16 h-1 bg-gray-300 rounded"></div>
                <div id="indicator-3" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-2 border-gray-300 text-gray-400">۳</div>
                <div id="connector-3" class="step-connector w-16 h-1 bg-gray-300 rounded"></div>
                <div id="indicator-4" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-2 border-gray-300 text-gray-400">۴</div>
            </div>
        </div>

        {{-- Step Labels --}}
        <div class="flex justify-between text-xs text-center mb-6 px-4">
            <div class="w-20">اطلاعات متقاضی</div>
            <div class="w-20">محل نصب</div>
            <div class="w-20">مشخصات فنی</div>
            <div class="w-20">مدارک و تصاویر</div>
        </div>

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-100 text-red-800 px-4 py-3 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form id="multi-step-form" method="POST" action="{{ route('solar-plant-requests.store') }}" class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            @csrf

            {{-- Step 1: Applicant Info --}}
            <div id="step-1" class="step active">
                <h2 class="text-xl font-bold mb-6">اطلاعات متقاضی</h2>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">نوع متقاضی</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="applicant_type" value="individual" class="peer sr-only" checked>
                            <div class="border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 rounded-lg p-4 text-center transition">
                                <div class="font-semibold">شخص حقیقی</div>
                                <div class="text-xs text-gray-500 mt-1">انسان عادی</div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="applicant_type" value="company" class="peer sr-only">
                            <div class="border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 rounded-lg p-4 text-center transition">
                                <div class="font-semibold">شخص حقوقی</div>
                                <div class="text-xs text-gray-500 mt-1">شرکت</div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="applicant_type" value="foreigner" class="peer sr-only">
                            <div class="border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 rounded-lg p-4 text-center transition">
                                <div class="font-semibold">اتباع</div>
                                <div class="text-xs text-gray-500 mt-1">خارجی</div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Individual Fields --}}
                <div id="fields-individual" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نام</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نام خانوادگی</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">کد ملی</label>
                        <input type="text" name="national_code" value="{{ old('national_code') }}" dir="ltr" inputmode="numeric" maxlength="10"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شناسه قبض برق</label>
                        <input type="text" name="bill_identifier" value="{{ old('bill_identifier') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شماره موبایل</label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" dir="ltr" inputmode="tel"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">تلفن ثابت (اختیاری)</label>
                        <input type="text" name="landline" value="{{ old('landline') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                {{-- Company Fields --}}
                <div id="fields-company" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نام شرکت</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شماره ثبت شرکت</label>
                        <input type="text" name="registration_number" value="{{ old('registration_number') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شماره موبایل</label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" dir="ltr" inputmode="tel"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شناسه مدیر عامل</label>
                        <input type="text" name="ceo_national_id" value="{{ old('ceo_national_id') }}" dir="ltr" maxlength="10"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شناسه قبض برق</label>
                        <input type="text" name="bill_identifier" value="{{ old('bill_identifier') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">تلفن ثابت (اختیاری)</label>
                        <input type="text" name="landline" value="{{ old('landline') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                {{-- Foreigner Fields --}}
                <div id="fields-foreigner" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نام</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نام خانوادگی</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">کد اتباع</label>
                        <input type="text" name="immigration_code" value="{{ old('immigration_code') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شناسه قبض برق</label>
                        <input type="text" name="bill_identifier" value="{{ old('bill_identifier') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شماره موبایل</label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" dir="ltr" inputmode="tel"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">تلفن ثابت (اختیاری)</label>
                        <input type="text" name="landline" value="{{ old('landline') }}" dir="ltr"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="button" onclick="nextStep(2)"
                        class="bg-amber-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-amber-600 transition">
                        مرحله بعد
                    </button>
                </div>
            </div>

            {{-- Step 2: Installation Location --}}
            <div id="step-2" class="step">
                <h2 class="text-xl font-bold mb-6">محل نصب</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">استان</label>
                        <input type="text" name="province" value="{{ old('province') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">شهر</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">کد پستی</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" dir="ltr" maxlength="10"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">آدرس دقیق</label>
                        <textarea name="address" rows="3"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button type="button" onclick="prevStep(1)"
                        class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        مرحله قبل
                    </button>
                    <button type="button" onclick="nextStep(3)"
                        class="bg-amber-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-amber-600 transition">
                        مرحله بعد
                    </button>
                </div>
            </div>

            {{-- Step 3: Technical Specs --}}
            <div id="step-3" class="step">
                <h2 class="text-xl font-bold mb-6">مشخصات فنی</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نوع کاربری</label>
                        <select name="usage_type"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">انتخاب کنید</option>
                            <option value="villa" {{ old('usage_type') === 'villa' ? 'selected' : '' }}>ویلایی</option>
                            <option value="industrial" {{ old('usage_type') === 'industrial' ? 'selected' : '' }}>صنعتی</option>
                            <option value="commercial" {{ old('usage_type') === 'commercial' ? 'selected' : '' }}>تجاری</option>
                            <option value="agriculture" {{ old('usage_type') === 'agriculture' ? 'selected' : '' }}>کشاورزی</option>
                            <option value="apartment" {{ old('usage_type') === 'apartment' ? 'selected' : '' }}>آپارتمان</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نوع ملک مشاع؟</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="is_shared_property" value="1" {{ old('is_shared_property') == '1' ? 'checked' : '' }}
                                    class="text-amber-500 focus:ring-amber-500">
                                <span>بلی</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="is_shared_property" value="0" {{ old('is_shared_property', '0') == '0' ? 'checked' : '' }}
                                    class="text-amber-500 focus:ring-amber-500">
                                <span>خیر</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">مساحت تقریبی محل نصب (متر مربع)</label>
                        <input type="number" name="installation_area" value="{{ old('installation_area') }}" min="0"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">نوع سطح محل نصب</label>
                        <select name="surface_type"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">انتخاب کنید</option>
                            <option value="flat" {{ old('surface_type') === 'flat' ? 'selected' : '' }}>تخت</option>
                            <option value="sloped" {{ old('surface_type') === 'sloped' ? 'selected' : '' }}>شیبدار</option>
                            <option value="ground" {{ old('surface_type') === 'ground' ? 'selected' : '' }}>زمین</option>
                            <option value="other" {{ old('surface_type') === 'other' ? 'selected' : '' }}>سایر</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">هدف</label>
                        <select name="purpose"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">انتخاب کنید</option>
                            <option value="off_grid" {{ old('purpose') === 'off_grid' ? 'selected' : '' }}>مصرف شخصی (Off-grid)</option>
                            <option value="on_grid" {{ old('purpose') === 'on_grid' ? 'selected' : '' }}>فروش به شبکه (On-grid)</option>
                            <option value="hybrid" {{ old('purpose') === 'hybrid' ? 'selected' : '' }}>هیبرید (Hybrid)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">ظرفیت (کیلو وات)</label>
                        <input type="number" name="capacity_kw" value="{{ old('capacity_kw') }}" min="1"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">برق ۳ فاز دارید؟</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="has_three_phase" value="1" {{ old('has_three_phase') == '1' ? 'checked' : '' }}
                                    class="text-amber-500 focus:ring-amber-500">
                                <span>بله</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="has_three_phase" value="0" {{ old('has_three_phase', '0') == '0' ? 'checked' : '' }}
                                    class="text-amber-500 focus:ring-amber-500">
                                <span>خیر</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">تمایل به دریافت وام دارید؟</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="wants_loan" value="1" {{ old('wants_loan') == '1' ? 'checked' : '' }}
                                    class="text-amber-500 focus:ring-amber-500">
                                <span>بله</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="wants_loan" value="0" {{ old('wants_loan', '0') == '0' ? 'checked' : '' }}
                                    class="text-amber-500 focus:ring-amber-500">
                                <span>خیر</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">توضیحات</label>
                        <textarea name="description" rows="3"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button type="button" onclick="prevStep(2)"
                        class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        مرحله قبل
                    </button>
                    <button type="button" onclick="nextStep(4)"
                        class="bg-amber-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-amber-600 transition">
                        مرحله بعد
                    </button>
                </div>
            </div>

            {{-- Step 4: Documents & Images --}}
            <div id="step-4" class="step">
                <h2 class="text-xl font-bold mb-6">مدارک و تصاویر</h2>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-800 mb-2">نکات عکس‌برداری:</h3>
                    <ul class="text-sm text-blue-700 space-y-1 list-disc pr-5">
                        <li>تصاویر باید واضح و با کیفیت باشند.</li>
                        <li>از زوایای مختلف محل نصب عکس بگیرید.</li>
                        <li>تصویر قبض برق و مدارک هویتی را آپلود کنید.</li>
                        <li>فرمت‌های مجاز: JPG, PNG, PDF</li>
                        <li>حداکثر حجم هر فایل: ۵ مگابایت</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">تصاویر محل نصب</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <p class="text-xs text-gray-500">می‌توانید چند تصویر انتخاب کنید.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">مدارک هویتی</label>
                        <input type="file" name="documents[]" multiple accept="image/*,.pdf"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <p class="text-xs text-gray-500">کارت ملی، گذرنامه، یا سایر مدارک هویتی.</p>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button type="button" onclick="prevStep(3)"
                        class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        مرحله قبل
                    </button>
                    <button type="submit"
                        class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        ثبت درخواست
                    </button>
                </div>
            </div>
        </form>
    </main>

    <footer class="bg-gray-900 text-gray-100 mt-12">
        <div class="container px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4 text-sm">
            <div>گروه صنعتی بهین انرژی</div>
            <div class="flex gap-4">
                <span>پشتیبانی: 021-91307571</span>
                <span>ایمیل: info@altfuel.ir</span>
            </div>
        </div>
    </footer>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function showStep(step) {
            document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');

            // Update indicators
            for (let i = 1; i <= totalSteps; i++) {
                const indicator = document.getElementById('indicator-' + i);
                indicator.classList.remove('active', 'completed');

                if (i < step) {
                    indicator.classList.add('completed');
                    indicator.innerHTML = '✓';
                } else if (i === step) {
                    indicator.classList.add('active');
                    indicator.innerHTML = ['۱', '۲', '۳', '۴'][i - 1];
                } else {
                    indicator.innerHTML = ['۱', '۲', '۳', '۴'][i - 1];
                }
            }

            // Update connectors
            for (let i = 1; i < totalSteps; i++) {
                const connector = document.getElementById('connector-' + i);
                if (i < step) {
                    connector.classList.add('active');
                } else {
                    connector.classList.remove('active');
                }
            }

            // Scroll to top of form
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function nextStep(step) {
            currentStep = step;
            showStep(step);
        }

        function prevStep(step) {
            currentStep = step;
            showStep(step);
        }

        // Applicant type toggle
        document.querySelectorAll('input[name="applicant_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const type = this.value;

                // Hide all fields
                document.getElementById('fields-individual').classList.add('hidden');
                document.getElementById('fields-company').classList.add('hidden');
                document.getElementById('fields-foreigner').classList.add('hidden');

                // Show selected fields
                document.getElementById('fields-' + type).classList.remove('hidden');
            });
        });

        // Initialize
        showStep(1);
    </script>
</body>

</html>
