# راهنمای نصب و راه‌اندازی پکیج‌های جدید

این راهنما برای نصب و راه‌اندازی تمام پکیج‌های جدید (مانند inverter-catalog) در سرور production است.

## روش اول: استفاده از Route خودکار (توصیه می‌شود)

### گام 1: آپلود فایل‌ها
ابتدا تمام فایل‌های پکیج جدید را به سرور آپلود کنید.

### گام 2: اجرای Composer
از طریق SSH یا terminal سرور، یک‌بار این دستور را اجرا کنید:

```bash
cd /path/to/project
composer dump-autoload
```

یا اگر composer به صورت local نصب است:

```bash
php composer.phar dump-autoload
```

### گام 3: اجرای Setup
حالا از مرورگر این آدرس را باز کنید:

```
https://solar.altfuel.ir/setup-packages
```

این روت به صورت خودکار انجام می‌دهد:
- ✅ پاک‌سازی تمام cache ها
- ✅ اجرای migrations جدید
- ✅ ایجاد storage link
- ✅ بهینه‌سازی برای production
- ✅ نمایش لیست routes جدید

---

## روش دوم: Manual از Terminal

اگر به SSH دسترسی دارید، می‌توانید دستورات را به صورت دستی اجرا کنید:

```bash
# رفتن به مسیر پروژه
cd /path/to/project

# بارگذاری مجدد autoload
composer dump-autoload

# پاک‌سازی cache ها
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# اجرای migrations
php artisan migrate --force

# ایجاد storage link (اگر وجود ندارد)
php artisan storage:link

# بهینه‌سازی
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## نصب پکیج Inverter Catalog

پس از اجرای مراحل بالا، پکیج inverter-catalog در این مسیرها در دسترس است:

### مسیرهای Admin
```
/admin/inverter-catalog          → لیست اینورترها
/admin/inverter-catalog/create   → افزودن اینورتر جدید
/admin/inverter-catalog/{id}     → مشاهده جزئیات
/admin/inverter-catalog/{id}/edit → ویرایش اینورتر
```

### API Endpoint
```
/admin/inverter-catalog/last-record → دریافت آخرین رکورد (JSON)
```

---

## عیب‌یابی مشکلات رایج

### خطا: Class 'InverterCatalog\...' not found

**راه حل:** دستور `composer dump-autoload` را اجرا نکرده‌اید.

```bash
composer dump-autoload
```

### خطا: SQLSTATE[42S02]: Base table or view not found

**راه حل:** migration اجرا نشده است.

```bash
php artisan migrate --force
```

یا از route استفاده کنید:
```
https://solar.altfuel.ir/setup-packages
```

### خطا: The file "..." does not exist

**راه حل:** storage link ایجاد نشده است.

```bash
php artisan storage:link
```

### View ها یا Route ها کار نمی‌کنند

**راه حل:** cache را پاک کنید.

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

یا:
```
https://solar.altfuel.ir/setup-packages
```

---

## چک‌لیست نصب پکیج جدید

برای اضافه کردن هر پکیج جدید:

- [ ] پوشه پکیج را در `packages/` قرار دهید
- [ ] در `composer.json` اصلی، namespace را در `autoload.psr-4` اضافه کنید
- [ ] در `bootstrap/providers.php`، ServiceProvider را اضافه کنید
- [ ] دستور `composer dump-autoload` را اجرا کنید
- [ ] آدرس `/setup-packages` را در مرورگر باز کنید
- [ ] تست کنید که routes و views کار می‌کنند

---

## فایل‌های تغییر یافته

برای نصب پکیج inverter-catalog، این فایل‌ها تغییر کردند:

1. `composer.json` → اضافه شدن namespace `InverterCatalog`
2. `bootstrap/providers.php` → اضافه شدن `InverterCatalogServiceProvider`
3. `routes/web.php` → اضافه شدن route `/setup-packages`

---

## پشتیبانی و سوالات

در صورت بروز مشکل:

1. خروجی route `/setup-packages` را بررسی کنید
2. لاگ Laravel را چک کنید: `storage/logs/laravel.log`
3. از browser console خطاها را بررسی کنید

---

## نکات امنیتی

⚠️ **مهم:** پس از نصب موفق، می‌توانید route `/setup-packages` را غیرفعال کنید یا middleware احراز هویت به آن اضافه کنید:

```php
Route::get('setup-packages', function(){
    // ...
})->middleware(['auth', 'admin']); // فقط ادمین دسترسی داشته باشد
```

یا به طور کامل حذف کنید (در production توصیه می‌شود).
