# راه‌اندازی لوکال با Docker

## پیش‌نیازها
- Docker Desktop نصب باشه: https://www.docker.com/products/docker-desktop/
- Git

---

## مراحل راه‌اندازی

### ۱. کپی کردن فایل env
```bash
copy .env.docker .env
```

### ۲. بالا آوردن کانتینرها
```bash
docker-compose up -d --build
```
(اولین بار کمی طول می‌کشه چون image رو build می‌کنه)

### ۳. Generate کردن APP_KEY
```bash
docker exec solar_app php artisan key:generate
```

### ۴. اجرای Migrations
```bash
docker exec solar_app php artisan migrate
```

### ۵. Build کردن assets (CSS/JS)
```bash
docker-compose --profile dev run --rm node
```
یا اگه Node رو لوکال داری:
```bash
npm install && npm run build
```

### ۶. باز کردن مرورگر
آدرس: http://localhost:8080

---

## دستورات پرکاربرد

```bash
# ورود به shell کانتینر PHP
docker exec -it solar_app bash

# اجرای artisan commands
docker exec solar_app php artisan <command>

# مشاهده لاگ‌ها
docker-compose logs -f app

# خاموش کردن
docker-compose down

# خاموش کردن + حذف دیتابیس
docker-compose down -v
```

---

## دیتابیس
- Host (از داخل کانتینر): `db`
- Host (از لوکال/TablePlus/DBeaver): `127.0.0.1`
- Port: `3306`
- Database: `solar_local`
- Username: `solar_user`
- Password: `solar_pass`
