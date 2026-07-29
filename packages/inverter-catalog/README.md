# Inverter Catalog Package

پکیج مدیریت جامع کاتالوگ اینورترها برای سیستم‌های انرژی خورشیدی

## ویژگی‌ها

- ✅ ثبت کامل مشخصات فنی اینورترها
- ✅ مدیریت انواع اینورتر (On-Grid, Off-Grid, Hybrid)
- ✅ ثبت مشخصات الکتریکی ورودی و خروجی
- ✅ مدیریت استانداردهای بین‌المللی
- ✅ سیستم تاییدیه آزمایشگاه
- ✅ بارگذاری و مدیریت دیتاشیت PDF
- ✅ تایید خودکار اتحادیه
- ✅ پشتیبانی از چندین پروتکل ارتباطی
- ✅ فرم پیشرفته با قابلیت پر کردن خودکار از آخرین رکورد

## نصب

### 1. اضافه کردن به composer.json

در فایل `composer.json` اصلی پروژه، بخش `repositories` و `autoload` را به‌روزرسانی کنید:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/inverter-catalog"
        }
    ],
    "require": {
        "behin/inverter-catalog": "@dev"
    },
    "autoload": {
        "psr-4": {
            "InverterCatalog\\": "packages/inverter-catalog/src/"
        }
    }
}
```

### 2. نصب پکیج

```bash
composer update
```

### 3. ثبت Service Provider

در فایل `config/app.php`، Service Provider را اضافه کنید:

```php
'providers' => [
    // ...
    InverterCatalog\InverterCatalogServiceProvider::class,
],
```

یا در Laravel 11+ در فایل `bootstrap/providers.php`:

```php
return [
    // ...
    InverterCatalog\InverterCatalogServiceProvider::class,
];
```

### 4. انتشار فایل‌های پکیج

```bash
php artisan vendor:publish --provider="InverterCatalog\InverterCatalogServiceProvider"
```

### 5. اجرای Migration

```bash
php artisan migrate
```

### 6. ایجاد لینک symbolic برای storage

```bash
php artisan storage:link
```

## استفاده

### مسیرها

پس از نصب، مسیرهای زیر در دسترس خواهند بود:

- `GET /admin/inverter-catalog` - لیست اینورترها
- `GET /admin/inverter-catalog/create` - فرم ایجاد اینورتر جدید
- `POST /admin/inverter-catalog/store` - ذخیره اینورتر جدید
- `GET /admin/inverter-catalog/{inverter}` - نمایش جزئیات اینورتر
- `GET /admin/inverter-catalog/{inverter}/edit` - فرم ویرایش اینورتر
- `PUT /admin/inverter-catalog/{inverter}` - به‌روزرسانی اینورتر
- `DELETE /admin/inverter-catalog/{inverter}` - حذف اینورتر
- `GET /admin/inverter-catalog/last-record` - دریافت آخرین رکورد (API)

### نمونه استفاده از Model

```php
use InverterCatalog\Models\InverterCatalog;

// دریافت همه اینورترها
$inverters = InverterCatalog::all();

// جستجوی اینورتر بر اساس برند
$inverters = InverterCatalog::where('brand', 'Longi')->get();

// فیلتر بر اساس نوع
$onGridInverters = InverterCatalog::where('inverter_type', 'On-Grid')->get();

// اینورترهای تایید شده توسط اتحادیه
$approvedInverters = InverterCatalog::where('lab_certified', true)
    ->whereNotNull('lab_name')
    ->whereNotNull('datasheet_path')
    ->get();

// دریافت استانداردها و آزمایشگاه‌های تایید شده
$standards = InverterCatalog::getAvailableStandards();
$labs = InverterCatalog::getApprovedLabs();
```

## ساختار دیتابیس

جدول `inverters_catalog` شامل فیلدهای زیر است:

### اطلاعات پایه
- `brand` - برند (مثل Longi, Trina)
- `manufacture` - نام شرکت سازنده
- `country_of_manufacture` - کشور تولید
- `model_name` - نام مدل
- `model_code` - کد مدل
- `inverter_type` - نوع اینورتر (On-Grid/Off-Grid/Hybrid)

### مشخصات توان
- `rated_power_kw` - توان نامی (کیلووات)
- `mppt_count` - تعداد MPPT
- `strings_per_mppt` - تعداد ورودی هر MPPT
- `max_pv_input_power` - حداکثر توان ورودی PV

### مشخصات الکتریکی - ورودی
- `max_dc_input_voltage` - حداکثر ولتاژ ورودی DC
- `max_input_current` - حداکثر جریان ورودی
- `mpp_voltage_range` - محدوده ولتاژ MPP

### مشخصات الکتریکی - خروجی
- `max_output_current` - حداکثر جریان خروجی
- `output_voltage` - ولتاژ خروجی AC
- `output_frequency` - فرکانس خروجی

### عملکرد
- `max_efficiency` - حداکثر راندمان (درصد)
- `thd` - Total Harmonic Distortion

### حفاظت و ویژگی‌ها
- `protection_level` - درجه حفاظت (IP65/IP66)
- `cooling_type` - روش خنک سازی (Natural/Fan/Liquid)
- `dc_switch` - کلید DC (boolean)
- `ac_switch` - کلید AC (boolean)
- `reverse_polarity_protection` - حفاظت پلاریته معکوس
- `display` - صفحه نمایشگر
- `anti_islanding_protection` - حفاظت ضد جزیره‌ای
- `leakage_current_protection` - حفاظت جریان نشتی
- `spd_type` - نوع SPD

### ارتباطات و استانداردها
- `communication_protocols` - پروتکل‌های ارتباطی (JSON array)
- `standards` - استانداردها (JSON array)
- `warranty_period` - مدت گارانتی

### مستندات و تاییدیه
- `datasheet_path` - مسیر فایل دیتاشیت PDF (اجباری)
- `notes` - توضیحات
- `lab_certified` - تاییدیه آزمایشگاه دارد؟
- `lab_name` - نام آزمایشگاه

## تنظیمات

فایل تنظیمات در `config/inverter-catalog.php` قرار دارد:

```php
return [
    'standards' => [
        'IEC 62109',
        'IEC 61727',
        // ...
    ],
    'approved_labs' => [
        'پژوهشگاه نیرو',
        'EPILL',
    ],
    'inverter_types' => [
        'On-Grid',
        'Off-Grid',
        'Hybrid',
    ],
    // ...
];
```

## تایید اتحادیه

اینورتر به صورت خودکار "تایید اتحادیه" می‌شود اگر:
1. تاییدیه آزمایشگاه داشته باشد (`lab_certified = true`)
2. نام آزمایشگاه مشخص شده باشد (`lab_name`)
3. فایل دیتاشیت بارگذاری شده باشد (`datasheet_path`)

## الزامات

- PHP >= 8.1
- Laravel >= 10.0
- پکیج `jalalian` برای تاریخ شمسی
- Storage link برای ذخیره فایل‌ها

## لایسنس

این پکیج تحت لایسنس MIT منتشر شده است.
