FROM php:8.2-apache

# نصب اکستنشن‌های مورد نیاز لاراول
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# فعال‌سازی mod_rewrite در آپاچی
RUN a2enmod rewrite

# تنظیم دایرکتوری ریشه آپاچی روی پوشه public لاراول
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# کپی کامپوزر
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# کپی سورس پروژه
WORKDIR /var/www/html
COPY . .

# نصب وابستگی‌های PHP
RUN composer install --no-dev --optimize-autoloader

# تنظیم دسترسی‌های پوشه storage و لاگ‌ها
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# دستور راه‌اندازی و اجرای مایگریشن
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && apache2-foreground
