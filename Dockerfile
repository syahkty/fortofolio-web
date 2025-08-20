# Stage 1: Install dependensi backend (Composer)
FROM composer:2.7 AS vendor

WORKDIR /app
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --ignore-platform-reqs

# Stage 2: Install dependensi frontend (NPM) dan build aset
# Gunakan alpine agar lebih ringan
FROM node:20-alpine AS assets

WORKDIR /app

# Salin folder vendor dari stage sebelumnya SEBELUM menjalankan npm install
# INI ADALAH KUNCI PERBAIKANNYA
COPY --from=vendor /app/vendor/ /app/vendor/

# Lanjutkan proses seperti biasa
COPY package.json package.json
COPY package-lock.json package-lock.json
RUN npm install

COPY . .
RUN npm run build


# Stage 3: Membuat image final
# (Bagian ini tidak perlu diubah, masih sama)
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-install pdo pdo_mysql zip pcntl exif gd

COPY . /var/www/html

COPY --from=vendor /app/vendor/ /var/www/html/vendor/
# Ganti path public dari stage assets untuk menyalin semuanya
COPY --from=assets /app/public/ /var/www/html/public/

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=$PORT