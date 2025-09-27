@extends('behin-layouts.welcome')

@if (auth()->check())
    <?php header('Location: https://s3tup.ir/admin'); ?>
@endif

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #eeee23 0%, #2575fc 100%);
            font-family: 'IRANSans', sans-serif;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
        }

        .content-box {
            color: #fff;
        }

        .content-box h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .features {
            margin-top: 30px;
        }

        .feature-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .feature-item i {
            font-size: 22px;
            margin-left: 10px;
            color: #ffd700;
        }

        .login-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.93);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            background: transparent;
            box-shadow: none !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-bottom: 2px solid #2575fc;
            outline: none;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 117, 252, 0.3);
        }

        .floating-label {
            position: absolute;
            top: 12px;
            right: 10px;
            font-size: 14px;
            color: #777;
            transition: 0.3s;
            pointer-events: none;
        }

        .form-control:focus + .floating-label,
        .form-control:not(:placeholder-shown) + .floating-label {
            top: -8px;
            right: 0;
            font-size: 12px;
            color: #2575fc;
        }

        .login-tabs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 20px;
        }

        .login-tabs button {
            border: 0;
            border-radius: 12px;
            padding: 10px 0;
            font-weight: 600;
            color: #2575fc;
            background: rgba(37, 117, 252, 0.08);
            transition: all 0.3s ease;
        }

        .login-tabs button.active {
            color: #fff;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            box-shadow: 0 8px 20px rgba(37, 117, 252, 0.3);
        }

        .login-form {
            display: none;
        }

        .login-form.active {
            display: block;
        }

        .alert {
            border-radius: 12px;
        }
    </style>

    <div class="hero-section container">
        <div class="row align-items-center">

            <div class="col-lg-5 col-md-8 mx-auto">
                <div class="card login-card p-4">
                    <img src="{{ url('behin/logo.png') . '?' . config('app.version') }}" class="mb-4"
                         style="max-height: 80px; margin: auto; " alt="Logo" width="100">
                    <h4 class="text-center mb-4 fw-bold text-dark">ورود به حساب کاربری</h4>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->has('message'))
                        <div class="alert alert-danger">
                            {{ $errors->first('message') }}
                        </div>
                    @endif

                    @php($initialTab = $errors->has('phone') ? 'otp-login' : 'password-login')
                    <div class="login-tabs" data-initial-tab="{{ $initialTab }}">
                        <button type="button" class="tab-trigger active" data-target="password-login">ورود با رمز عبور</button>
                        <button type="button" class="tab-trigger" data-target="otp-login">دریافت کد یکبار مصرف</button>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="login-form active" id="password-login">
                        @csrf
                        <div class="mb-4 position-relative">
                            <input type="text" name="email" class="form-control text-start" id="inputEmail"
                                   placeholder=" " value="{{ old('email') }}" required dir="ltr" autocomplete="username">
                            <label for="inputEmail" class="floating-label"><i class="fa fa-user me-1"></i> نام کاربری</label>
                        </div>

                        @error('email')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        <div class="mb-4 position-relative">
                            <input type="password" name="password" class="form-control text-start" id="inputPassword"
                                   placeholder=" " required dir="ltr" autocomplete="current-password">
                            <label for="inputPassword" class="floating-label"><i class="fa fa-lock me-1"></i> رمز عبور</label>
                        </div>

                        @error('password')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-gradient w-100 py-3">ورود</button>
                    </form>

                    <form method="POST" action="{{ route('otp.send') }}" class="login-form" id="otp-login">
                        @csrf

                        <div class="mb-4 position-relative">
                            <input type="text" name="phone" class="form-control text-center" id="inputMobile"
                                   placeholder=" " required dir="ltr" inputmode="numeric" autocomplete="tel">
                            <label for="inputMobile" class="floating-label"><i class="fa fa-phone me-1"></i> موبایل</label>
                        </div>

                        @error('phone')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-gradient w-100 py-3">ارسال کد</button>
                    </form>

                    <div class="mt-4 text-center">
                        @include('auth.partial.enamad-and-version')
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 content-box text-center text-lg-start mb-5 mb-lg-0">
                <h1>ستاپ</h1>
                <h3 class="mb-3">سامانه تأمین و اجرای پروژه‌های خورشیدی</h3>
                <p class="lead">ستاپ بستری نوین برای ثبت، پیگیری و اجرای پروژه‌های خورشیدی است.
                    از ثبت درخواست تا اجرای کامل پروژه و دریافت گواهی‌های لازم، همه در یک سامانه.</p>

                <div class="features text-start">
                    <div class="feature-item"><i class="fa fa-check-circle"></i> امکان ارائه تسهیلات مالی (وام)</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> ثبت درخواست سریع و آنلاین</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> نمایش پروژه‌ها به متخصصان استانی</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> ثبت تجهیزات و قطعات مصرفی</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> صدور گواهی تأیید بعد از نصب</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> پشتیبانی 24 ساعته: 02191017175</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabTriggers = document.querySelectorAll('.tab-trigger');
            const forms = {
                'password-login': document.getElementById('password-login'),
                'otp-login': document.getElementById('otp-login')
            };
            const tabsContainer = document.querySelector('.login-tabs');
            const initialTab = tabsContainer ? tabsContainer.dataset.initialTab : 'password-login';

            tabTriggers.forEach(trigger => {
                const isInitial = trigger.dataset.target === initialTab;
                trigger.classList.toggle('active', isInitial);
                if (forms[trigger.dataset.target]) {
                    forms[trigger.dataset.target].classList.toggle('active', isInitial);
                }
            });

            tabTriggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    const target = trigger.dataset.target;
                    tabTriggers.forEach(btn => btn.classList.toggle('active', btn === trigger));

                    Object.keys(forms).forEach(key => {
                        forms[key].classList.toggle('active', key === target);
                    });
                });
            });
        });
    </script>
@endsection
