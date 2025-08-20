# Stage 1: Install dependensi backend (Composer)
FROM composer:2.7 AS vendor

WORKDIR /app
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --ignore-platform-reqs

# Stage 2: Install dependensi frontend (NPM) dan build aset
FROM node:20-alpine AS assets

WORKDIR /app
COPY package.json package.json
COPY package-lock.json package-lock.json
RUN npm install
COPY . .
RUN npm run build

# Stage 3: Membuat image final yang disederhanakan untuk Render
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install ekstensi PHP yang umum untuk Laravel
# Kita tidak perlu Nginx atau Supervisor di sini
RUN apk add --no-cache libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-install pdo pdo_mysql zip pcntl exif gd

# Copy semua file aplikasi dari direktori lokal
COPY . /var/www/html

# Copy dependensi dari stage-stage sebelumnya
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=assets /app/public/ /var/www/html/public/

# Atur izin folder yang benar untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port yang akan digunakan oleh artisan serve
EXPOSE 8000

# Perintah utama untuk menjalankan aplikasi
# Perintah ini akan menggunakan port dinamis dari Render ($PORT)
CMD php artisan serve --host=0.0.0.0 --port=$PORT