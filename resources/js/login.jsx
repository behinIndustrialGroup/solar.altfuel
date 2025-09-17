import './bootstrap';
import React, { useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';

const Spinner = () => (
    <svg
        className="h-5 w-5 animate-spin text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
    >
        <circle
            className="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            strokeWidth="4"
        />
        <path
            className="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
        />
    </svg>
);

const StatsGrid = ({ stats }) => (
    <div className="mt-8 grid grid-cols-2 gap-3">
        {stats.map((stat) => (
            <div
                key={stat.label}
                className="bg-white/80 p-4 rounded-lg text-center shadow"
            >
                <div className="text-sm text-gray-600">{stat.label}</div>
                <div className="text-2xl font-bold text-gray-900">
                    {stat.value}
                </div>
            </div>
        ))}
    </div>
);

const FeaturesSection = ({ features }) => (
    <section className="space-y-6">
        <h2 className="text-2xl font-bold">ویژگی‌های اصلی ستاپ</h2>
        <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
            {features.map((feature) => (
                <div
                    key={feature.title}
                    className="bg-white p-6 rounded-lg shadow"
                >
                    <h3 className="font-semibold mb-2 text-lg">
                        {feature.title}
                    </h3>
                    <p className="text-sm text-gray-600">
                        {feature.description}
                    </p>
                </div>
            ))}
        </div>
    </section>
);

const StepsSection = ({ steps }) => (
    <section className="space-y-6">
        <h2 className="text-2xl font-bold">نحوه کار با ستاپ</h2>
        <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
            {steps.map((step) => (
                <div
                    key={step.title}
                    className="p-6 bg-gradient-to-tr from-white to-gray-50 rounded-lg shadow"
                >
                    <div className="text-xl font-bold mb-2 text-gray-800">
                        {step.title}
                    </div>
                    <p className="text-sm text-gray-600">{step.description}</p>
                </div>
            ))}
        </div>
    </section>
);

const LoginForm = ({
    loginUrl,
    dashboardUrl,
    forgotPasswordUrl,
    registerUrl,
    otpUrl,
}) => {
    const [formData, setFormData] = useState({
        email: '',
        password: '',
        remember: false,
    });
    const [fieldErrors, setFieldErrors] = useState({});
    const [message, setMessage] = useState('');
    const [status, setStatus] = useState('idle');

    const isSubmitting = status === 'submitting';

    const handleChange = (event) => {
        const { name, type, checked, value } = event.target;
        setFormData((previous) => ({
            ...previous,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        setStatus('submitting');
        setMessage('');
        setFieldErrors({});

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        if (!csrfToken) {
            setMessage('توکن امنیتی یافت نشد. لطفاً صفحه را دوباره بارگذاری کنید.');
            setStatus('idle');
            return;
        }

        try {
            const response = await fetch(loginUrl || '/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    email: formData.email,
                    password: formData.password,
                    remember: formData.remember,
                }),
            });

            if (response.ok) {
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                let payload = null;
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    payload = await response.json().catch(() => null);
                }

                const target = payload?.redirect || dashboardUrl || '/admin';
                window.location.href = target;
                return;
            }

            let payload = null;
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                payload = await response.json().catch(() => null);
            }

            const validationErrors = payload?.errors || {};
            setFieldErrors(validationErrors);

            const responseMessage =
                payload?.message ||
                validationErrors?.message?.[0] ||
                (response.status === 404
                    ? 'کاربر مورد نظر یافت نشد.'
                    : response.status === 429
                      ? 'تعداد تلاش‌ها بیش از حد مجاز است. لطفاً بعداً تلاش کنید.'
                      : response.status === 419
                        ? 'نشست شما منقضی شده است. لطفاً صفحه را بازآوری کنید.'
                        : 'ورود ناموفق بود. لطفاً دوباره تلاش کنید.');

            setMessage(responseMessage);
        } catch (error) {
            console.error(error);
            setMessage('خطایی در برقراری ارتباط رخ داد. لطفاً اتصال اینترنت خود را بررسی کنید.');
        } finally {
            setStatus('idle');
        }
    };

    const emailError = fieldErrors?.email?.[0];
    const passwordError = fieldErrors?.password?.[0];

    return (
        <form
            onSubmit={handleSubmit}
            className="w-full bg-white p-6 rounded-2xl shadow-lg space-y-5"
            noValidate
        >
            <div className="space-y-1">
                <label htmlFor="email" className="block text-sm font-medium text-gray-700">
                    ایمیل سازمانی
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autoComplete="email"
                    inputMode="email"
                    required
                    dir="ltr"
                    value={formData.email}
                    onChange={handleChange}
                    className={`mt-1 block w-full rounded-lg border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900 ${
                        emailError ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''
                    }`}
                    placeholder="you@example.com"
                />
                {emailError && (
                    <p className="text-xs text-red-600" role="alert">
                        {emailError}
                    </p>
                )}
            </div>

            <div className="space-y-1">
                <label htmlFor="password" className="block text-sm font-medium text-gray-700">
                    رمز عبور
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autoComplete="current-password"
                    required
                    dir="ltr"
                    value={formData.password}
                    onChange={handleChange}
                    className={`mt-1 block w-full rounded-lg border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900 ${
                        passwordError
                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                            : ''
                    }`}
                    placeholder="رمز عبور"
                />
                {passwordError && (
                    <p className="text-xs text-red-600" role="alert">
                        {passwordError}
                    </p>
                )}
            </div>

            <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label className="inline-flex items-center gap-2 text-sm text-gray-600">
                    <input
                        type="checkbox"
                        name="remember"
                        checked={formData.remember}
                        onChange={handleChange}
                        className="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                    />
                    مرا به خاطر بسپار
                </label>
                <div className="flex flex-wrap gap-3 text-sm">
                    {forgotPasswordUrl && (
                        <a
                            href={forgotPasswordUrl}
                            className="text-gray-700 hover:text-gray-900"
                        >
                            فراموشی رمز عبور
                        </a>
                    )}
                    {otpUrl && (
                        <a href={otpUrl} className="text-gray-700 hover:text-gray-900">
                            ورود با رمز یکبار مصرف
                        </a>
                    )}
                </div>
            </div>

            {message && (
                <div
                    className="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    role="alert"
                >
                    {message}
                </div>
            )}

            <button
                type="submit"
                disabled={isSubmitting}
                className="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-black disabled:cursor-not-allowed disabled:opacity-70"
            >
                {isSubmitting ? 'در حال ورود...' : 'ورود به پنل مدیریت'}
                {isSubmitting && <Spinner />}
            </button>

            {registerUrl && (
                <p className="text-center text-xs text-gray-500">
                    حساب کاربری ندارید؟{' '}
                    <a
                        className="font-medium text-gray-700 hover:text-gray-900"
                        href={registerUrl}
                    >
                        ثبت‌نام کنید
                    </a>
                </p>
            )}
        </form>
    );
};

const LoginPage = ({ dataset }) => {
    const stats = useMemo(
        () => [
            { label: 'ظرفیت نصب‌شده', value: '۱.۷ مگاوات' },
            { label: 'پروژه‌های تکمیل‌شده', value: '84 پروژه' },
        ],
        [],
    );

    const features = useMemo(
        () => [
            {
                title: 'شبکه گسترده پیمانکاران',
                description:
                    'دسترسی به پیمانکاران معتبر و تایید‌شده در تمامی استان‌های ایران.',
            },
            {
                title: 'تسهیلات مالی انعطاف‌پذیر',
                description:
                    'امکان دریافت پیشنهادات مالی و تسهیلات برای نصب و راه‌اندازی نیروگاه.',
            },
            {
                title: 'پشتیبانی فنی و مدیریتی',
                description:
                    'پیگیری پروژه از آغاز تا تحویل و تضمین کیفیت اجرا توسط تیم تخصصی ستاپ.',
            },
        ],
        [],
    );

    const steps = useMemo(
        () => [
            {
                title: '۱. ثبت درخواست',
                description:
                    'فرم کوتاه را پر کنید تا کارشناسان ما نیاز شما را بررسی کنند.',
            },
            {
                title: '۲. معرفی پیمانکار برتر',
                description:
                    'پیمانکاران واجد شرایط با شما تماس می‌گیرند و پیشنهاد ارائه می‌دهند.',
            },
            {
                title: '۳. اجرا و پشتیبانی کامل',
                description:
                    'از تامین مالی تا اجرا و تحویل پروژه در کنار شما هستیم.',
            },
        ],
        [],
    );

    return (
        <div className="min-h-screen bg-gray-50 text-gray-800" dir="rtl">
            <header className="bg-gradient-to-l from-yellow-400 via-yellow-300 to-amber-400 text-gray-900">
                <div className="mx-auto flex max-w-6xl flex-col gap-10 px-6 py-12 md:flex-row md:items-start">
                    <div className="flex-1 space-y-6">
                        <div>
                            <h1 className="text-3xl font-bold md:text-4xl">
                                ستاپ — سامانه تأمین و اجرای پروژه‌های خورشیدی
                            </h1>
                            <p className="mt-3 text-lg text-gray-800 md:text-xl">
                                ما متقاضیان نصب پنل خورشیدی را به پیمانکاران معتبر در سراسر ایران وصل
                                می‌کنیم و از آغاز تا تحویل پروژه در کنارتان هستیم.
                            </p>
                        </div>

                        <LoginForm
                            loginUrl={dataset.loginUrl}
                            dashboardUrl={dataset.dashboardUrl}
                            forgotPasswordUrl={dataset.forgotPasswordUrl}
                            registerUrl={dataset.registerUrl}
                            otpUrl={dataset.otpUrl}
                        />

                        <StatsGrid stats={stats} />
                    </div>

                    <div className="flex-1">
                        <div className="overflow-hidden rounded-2xl bg-white shadow-xl">
                            {dataset.heroImage && (
                                <img
                                    src={dataset.heroImage}
                                    alt="پنل خورشیدی"
                                    className="h-64 w-full object-cover"
                                />
                            )}
                            <div className="space-y-3 p-5">
                                <h3 className="text-lg font-bold text-gray-900">
                                    شروع همکاری در سه گام ساده
                                </h3>
                                <ol className="list-decimal space-y-2 pr-5 text-sm text-gray-600">
                                    <li>درخواست آنلاین ثبت کنید.</li>
                                    <li>پیمانکار مناسب معرفی می‌شود.</li>
                                    <li>تأمین مالی و اجرای پروژه با نظارت ستاپ.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main className="mx-auto max-w-6xl space-y-12 px-6 py-12">
                <FeaturesSection features={features} />
                <StepsSection steps={steps} />
            </main>

            <footer className="bg-gray-900 py-8 text-white">
                <div className="mx-auto flex max-w-6xl flex-col gap-6 px-6 md:flex-row md:items-start md:justify-between">
                    <div className="space-y-2">
                        <h4 className="text-lg font-bold">ستاپ</h4>
                        <p className="text-sm text-gray-300">
                            سامانه تأمین و اجرای پروژه‌های خورشیدی — اتصال متقاضیان به پیمانکاران و ارائه تسهیلات مالی.
                        </p>
                    </div>
                    <div className="space-y-2">
                        <h5 className="font-semibold">تماس</h5>
                        <p className="text-sm text-gray-300">تلفن: 02191017175</p>
                    </div>
                    <div className="space-y-2">
                        <h5 className="font-semibold">مجوزها</h5>
                        <a
                            referrerPolicy="origin"
                            target="_blank"
                            rel="noreferrer"
                            href="https://trustseal.enamad.ir/?id=642135&Code=Zmyvcsbjmy4wR9QgoHCBdzNN3L93m4qf"
                        >
                            <img
                                referrerPolicy="origin"
                                src="https://trustseal.enamad.ir/logo.aspx?id=642135&Code=Zmyvcsbjmy4wR9QgoHCBdzNN3L93m4qf"
                                alt="نماد اعتماد"
                                className="h-16 w-auto"
                            />
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    );
};

const rootElement = document.getElementById('login-root');

if (rootElement) {
    const dataset = rootElement.dataset || {};
    createRoot(rootElement).render(<LoginPage dataset={dataset} />);
}
