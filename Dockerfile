# Sử dụng base image PHP-FPM
FROM php:8.2-fpm-alpine

# Cài đặt các extension PHP cần thiết cho Laravel
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    libpq-dev \
    libzip-dev \
    sqlite-dev \
    mysql-client \
    git \
    supervisor \
    && docker-php-ext-install pdo_mysql zip

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /var/www/html