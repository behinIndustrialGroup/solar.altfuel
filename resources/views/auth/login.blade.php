@extends('behin-layouts.welcome')

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
            background: rgba(255, 255, 255, 0.9);
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

        .form-control:focus+.floating-label,
        .form-control:not(:placeholder-shown)+.floating-label {
            top: -8px;
            right: 0;
            font-size: 12px;
            color: #2575fc;
        }

    </style>
    
    <div class="hero-section container">
        
        <div class="row align-items-center">

            <!-- فرم ورود -->
            <div class="col-lg-5 col-md-8 mx-auto">
                <div class="card login-card p-4">
                    <img src="{{ url('behin/logo.png') . '?' . config('app.version') }}" class="mb-4"
                        style="max-height: 80px; margin: auto; " alt="Logo" width="100">
                    <h4 class="text-center mb-4 fw-bold text-dark">ورود به حساب کاربری</h4>
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form id="login-form" method="POST" action="javascript:void(0)" class="position-relative">
                        @csrf
                        <input type="hidden" name="remember" value="1">

                        <div class="mb-4 position-relative">
                            <input type="text" name="email" class="form-control" id="inputMobile" placeholder=" "
                                required>
                            <label for="inputMobile" class="floating-label"><i class="fa fa-phone me-1"></i> موبایل</label>
                        </div>

                        <div class="mb-4 position-relative">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder=" "
                                required>
                            <label for="inputPassword" class="floating-label"><i class="fa fa-lock me-1"></i> رمز
                                عبور</label>
                        </div>

                        <button type="submit" onclick="submitLogin()" class="btn btn-gradient w-100 py-3">
                            ورود
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('register') }}" class="d-block small text-decoration-none text-primary">ثبت
                            نام</a>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('password.request') }}"
                            class="d-block small text-decoration-none text-primary">فراموشی رمز عبور</a>
                    </div>

                    <div class="mt-4 text-center">
                        @include('auth.partial.enamad-and-version')
                    </div>
                </div>
            </div>

            <!-- بخش معرفی -->
            <div class="col-lg-6 col-md-12 content-box text-center text-lg-start mb-5 mb-lg-0">
                <img src="{{ url('behin/logo.png') . '?' . config('app.version') }}" class="mb-4" style="max-height: 80px"
                    alt="Logo">
                <h1>ستاپ</h1>
                <h3 class="mb-3">سامانه تأمین و اجرای پروژه‌های خورشیدی</h3>
                <p class="lead">ستاپ بستری نوین برای ثبت، پیگیری و اجرای پروژه‌های خورشیدی است.
                    از ثبت درخواست تا اجرای کامل پروژه و دریافت گواهی‌های لازم، همه در یک سامانه.</p>

                <div class="features text-start">
                    <div class="feature-item"><i class="fa fa-check-circle"></i> ثبت درخواست سریع و آنلاین</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> نمایش پروژه‌ها به متخصصان استانی</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> ثبت تجهیزات و قطعات مصرفی</div>
                    <div class="feature-item"><i class="fa fa-check-circle"></i> صدور گواهی تأیید بعد از نصب</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        @if (auth()->id())
            show_message("شما قبلا وارد شده‌اید");
            show_message("به صفحه داشبورد منتقل می‌شوید");
            window.location = "{{ url('admin') }}";
        @endif

        function submitLogin() {
            send_ajax_request(
                "{{ route('login') }}",
                $('#login-form').serialize(),
                function(response) {
                    show_message("به صفحه داشبورد منتقل می‌شوید");
                    window.location = "{{ url('admin') }}";
                },
                function(response) {
                    console.log(response)
                    if (response.status == 404) {
                        show_error(response.responseJSON.message)
                        let mobile = $('#inputMobile').val();
                        window.location = 'https://s3tup.ir/register?mobile=' + encodeURIComponent(mobile);
                    } else {
                        show_error(response);
                        hide_loading();
                    }

                }
            )
        }
    </script>
@endsection
