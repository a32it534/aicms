# 🤖 AI CMS

**سیستم مدیریت محتوای هوشمند با Laravel و GapGPT**

AI CMS یک سیستم مدیریت محتوای آموزشی است که با استفاده از **Laravel** و **GapGPT API** امکان تولید، مدیریت و سازمان‌دهی محتوای متنی و آموزشی را فراهم می‌کند.

## ✨ امکانات

* 🤖 تولید محتوا با هوش مصنوعی GapGPT
* 📚 مدیریت محتوای آموزشی
* 📝 تولید مقاله و مطالب متنی
* 📖 ایجاد و مدیریت درس‌های آموزشی
* 👤 مدیریت کاربران
* 📊 پنل مدیریت
* 🔐 احراز هویت و مدیریت دسترسی
* 🌐 رابط کاربری فارسی و RTL
* 📅 پشتیبانی از تاریخ شمسی
* 🗄️ استفاده از MySQL
* ⚡ Laravel 12


## 🧠 GapGPT

ارتباط با GapGPT از طریق Backend Laravel انجام می‌شود و کلید API در سمت سرور نگهداری می‌شود.

تنظیمات موردنیاز در فایل `.env`:

```env
GAPGPT_API_KEY=your_api_key
GAPGPT_BASE_URL=https://api.gapgpt.app/v1
GAPGPT_MODEL=gpt-4o
```

> کلید API را در Frontend، GitHub یا فایل‌های عمومی قرار ندهید.

## 🛠️ تکنولوژی‌ها

* PHP
* Laravel 12
* MySQL
* Blade
* Tailwind CSS
* JavaScript
* Vite
* GapGPT API

## ⚙️ نصب و اجرا

Repository را دریافت کنید:

```bash
git clone https://github.com/a32it534/laravel-ai-cms.git.git
cd laravel-ai-cms.git
```

نصب وابستگی‌ها:

```bash
composer install
npm install
```

ایجاد فایل محیطی:

```cmd
copy .env.example .env
```

ایجاد کلید Laravel:

```bash
php artisan key:generate
```

سپس اطلاعات دیتابیس و GapGPT را در `.env` وارد کنید.

اجرای Migration:

```bash
php artisan migrate
```

اجرای پروژه:

```bash
php artisan serve
```

اجرای Frontend:

```bash
npm run dev
```

## 🗄️ Database

پروژه از MySQL استفاده می‌کند.

نمونه تنظیمات:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_cms
DB_USERNAME=root
DB_PASSWORD=
```

## 👤 Admin

برای ایجاد کاربر مدیر:

```bash
php artisan db:seed --class=AdminUserSeeder
```

Seeder در مسیر زیر قرار دارد:

```text
database/seeders/AdminUserSeeder.php
```

پس از ورود، اطلاعات پیش‌فرض مدیر را تغییر دهید.

## 📅 تاریخ شمسی

برای پشتیبانی از تاریخ شمسی می‌توانید از پکیج زیر استفاده کنید:

```bash
composer require morilog/jalali
```

## 🗺️ Roadmap

* [x] Laravel CMS
* [x] اتصال به GapGPT
* [x] مدیریت محتوای آموزشی
## 📌 وضعیت پروژه

این پروژه در حال توسعه است و قابلیت‌های جدید هوش مصنوعی به مرور به آن اضافه می‌شوند.

## 📄 License

MIT License
