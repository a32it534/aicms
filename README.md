# 🤖 AI CMS

**AI-powered Content Management System built with Laravel and GapGPT.**

یک سیستم مدیریت محتوای هوشمند برای تولید، مدیریت و سازمان‌دهی محتوای آموزشی با استفاده از **هوش مصنوعی GapGPT**.

این پروژه با هدف ساده‌سازی فرآیند تولید محتوای آموزشی، مقاله، درس و مطالب متنی طراحی شده است و از **GapGPT API** برای قابلیت‌های هوش مصنوعی استفاده می‌کند.

## ✨ Features

* 🤖 تولید محتوای هوشمند با **GapGPT**
* 🧠 استفاده از **GapGPT API** برای تولید و پردازش محتوا
* 📚 مدیریت محتوای آموزشی
* 📝 تولید مقاله و محتوای متنی با کمک AI
* 📖 تولید و مدیریت درس‌های آموزشی
* 👤 مدیریت کاربران
* 📊 پنل مدیریت
* 🔐 احراز هویت و مدیریت دسترسی
* 🌐 پشتیبانی از زبان فارسی و رابط کاربری RTL
* ⚡ ساخته‌شده با Laravel 12
* 🎨 استفاده از Tailwind CSS
* 🗄️ پشتیبانی از MySQL
* 🧩 معماری قابل توسعه برای اضافه کردن قابلیت‌های جدید AI

## 🧠 AI Provider

این پروژه از **GapGPT** به عنوان سرویس هوش مصنوعی استفاده می‌کند.

```text
Application
     │
     ▼
Laravel Backend
     │
     ▼
GapGPT API
     │
     ▼
AI Generated Content
```

API Key مربوط به GapGPT باید در فایل `.env` قرار گیرد و نباید در Frontend یا Repository عمومی GitHub قرار داده شود.

### GapGPT Environment Variables

تنظیمات اتصال به GapGPT از طریق متغیرهای محیطی انجام می‌شود:

```env
GAPGPT_API_KEY=your_gapgpt_api_key
GAPGPT_BASE_URL=https://api.gapgpt.app/v1
GAPGPT_MODEL=gpt-4o
```

| Variable          | Description                       |
| ----------------- | --------------------------------- |
| `GAPGPT_API_KEY`  | کلید دسترسی به GapGPT API         |
| `GAPGPT_BASE_URL` | آدرس پایه API سرویس GapGPT        |
| `GAPGPT_MODEL`    | مدل مورد استفاده برای تولید محتوا |

> مقدار واقعی `GAPGPT_API_KEY` را در GitHub قرار ندهید.

## 🛠️ Technologies

* PHP
* Laravel 12
* MySQL
* Tailwind CSS
* Vite
* GapGPT API
* Blade
* JavaScript

## ⚙️ Environment Configuration

این پروژه از فایل `.env` برای نگهداری تنظیمات برنامه، دیتابیس، GapGPT، Session، Queue، Cache و تنظیمات امنیتی استفاده می‌کند.

پس از ایجاد فایل `.env`، تنظیمات موردنیاز را وارد کنید.

### Application

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
```

برای محیط توسعه می‌توان از:

```env
APP_ENV=local
APP_DEBUG=true
```

استفاده کرد.

در محیط Production توصیه می‌شود:

```env
APP_ENV=production
APP_DEBUG=false
```

تنظیم شود.

### 🗄️ Database

پروژه از MySQL استفاده می‌کند.

Database پیش‌فرض:

```text
ai_cms
```

تنظیمات نمونه:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_cms
DB_USERNAME=root
DB_PASSWORD=
```

پس از ایجاد Database، Migrationها را اجرا کنید:

```bash
php artisan migrate
```

### 🤖 GapGPT

برای فعال‌سازی قابلیت‌های هوش مصنوعی:

```env
GAPGPT_API_KEY=your_gapgpt_api_key
GAPGPT_BASE_URL=https://api.gapgpt.app/v1
GAPGPT_MODEL=gpt-4o
```

**توجه:** API Key فقط باید در Backend Laravel استفاده شود.

کلید API را:

* در Frontend قرار ندهید.
* داخل JavaScript قرار ندهید.
* داخل GitHub قرار ندهید.
* داخل README قرار ندهید.
* داخل Screenshotها نمایش ندهید.

### 👤 Admin Security

برای محدود کردن IPهای مجاز برای بخش مدیریت:

```env
ADMIN_ALLOWED_IPS=127.0.0.1,::1
```

برای اضافه کردن چند IP:

```env
ADMIN_ALLOWED_IPS=127.0.0.1,::1,YOUR_LOCAL_IP
```

IPها باید با کاما از یکدیگر جدا شوند.

### 💾 Session

تنظیمات Session:

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

### ⚡ Queue

پروژه از Database Queue پشتیبانی می‌کند:

```env
QUEUE_CONNECTION=database
```

برای اجرای Queue Worker:

```bash
php artisan queue:work
```

### 🗃️ Cache

Cache پروژه با Database مدیریت می‌شود:

```env
CACHE_STORE=database
```

### 📁 File Storage

تنظیمات ذخیره فایل:

```env
FILESYSTEM_DISK=local
```

### 📧 Mail

در محیط توسعه، Mail به صورت Log ذخیره می‌شود:

```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
```

### 🎨 Vite

نام برنامه برای Frontend:

```env
VITE_APP_NAME="${APP_NAME}"
```

## 🔐 Security

فایل `.env` شامل اطلاعات حساس پروژه است.

**هرگز فایل `.env` واقعی را در GitHub قرار ندهید.**

اطلاعات حساس شامل موارد زیر هستند:

```text
APP_KEY
GAPGPT_API_KEY
DB_PASSWORD
MAIL_PASSWORD
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
```

به جای `.env` از `.env.example` استفاده کنید.

نمونه:

```env
APP_NAME=AI-CMS
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_cms
DB_USERNAME=root
DB_PASSWORD=

GAPGPT_API_KEY=your_gapgpt_api_key
GAPGPT_BASE_URL=https://api.gapgpt.app/v1
GAPGPT_MODEL=gpt-4o

ADMIN_ALLOWED_IPS=127.0.0.1,::1
```

## 🚀 Installation

ابتدا Repository را Clone کنید:

```bash
git clone https://github.com/a32it534/aicms.git
cd aicms
```

سپس وابستگی‌های PHP را نصب کنید:

```bash
composer install
```

وابستگی‌های Frontend را نصب کنید:

```bash
npm install
```

فایل تنظیمات محیطی را ایجاد کنید:

```bash
cp .env.example .env
```

در Windows می‌توانید از این دستور استفاده کنید:

```cmd
copy .env.example .env
```

کلید Laravel را ایجاد کنید:

```bash
php artisan key:generate
```

اطلاعات دیتابیس و تنظیمات GapGPT را در `.env` وارد کنید.

سپس Migrationها را اجرا کنید:

```bash
php artisan migrate
```

برای اجرای پروژه:

```bash
php artisan serve
```

برای اجرای Frontend:

```bash
npm run dev
```

## 🔑 GapGPT Configuration

کلید API مربوط به GapGPT را در فایل `.env` قرار دهید:

```env
GAPGPT_API_KEY=your_api_key
```

سپس تنظیمات API را مشخص کنید:

```env
GAPGPT_BASE_URL=https://api.gapgpt.app/v1
GAPGPT_MODEL=gpt-4o
```

**نکته امنیتی:** فایل `.env` را در GitHub قرار ندهید و API Key را داخل کد Frontend هاردکد نکنید.

## 🎯 Project Goal

هدف AI CMS ایجاد یک محیط یکپارچه برای تولید و مدیریت محتوای آموزشی با کمک هوش مصنوعی است.

کاربر می‌تواند محتوای موردنظر خود را تعریف کرده و سیستم با استفاده از **GapGPT** در فرآیند تولید محتوا به او کمک کند.

معماری پروژه به گونه‌ای طراحی شده است که قابلیت‌های هوش مصنوعی از طریق Backend Laravel مدیریت شوند و API Key سرویس GapGPT در سمت سرور باقی بماند.

## 🏗️ Architecture

```text
                    ┌──────────────────┐
                    │      User        │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │   AI CMS / UI    │
                    │ Laravel + Blade  │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │ Laravel Backend  │
                    │ AI Services      │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │    GapGPT API    │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │ AI Generated     │
                    │ Content          │
                    └──────────────────┘
```

## 🗺️ Roadmap

* [x] Laravel CMS Foundation
* [x] GapGPT Integration
* [ ] Advanced AI Content Generation
* [ ] Automatic Book Generation
* [ ] AI-generated Quizzes
* [ ] AI-generated Exercises
* [ ] Export to PDF
* [ ] Export to Word
* [ ] SEO Content Assistant
* [ ] Advanced AI Prompt Management
* [ ] AI Content Templates
* [ ] Advanced Content Editor
* [ ] AI-assisted Educational Book Creation

## 📌 Project Status

این پروژه در حال توسعه است و قابلیت‌های جدید هوش مصنوعی و مدیریت محتوا به مرور به آن اضافه خواهند شد.

## 📄 License

This project is open-source and available under the MIT License.
