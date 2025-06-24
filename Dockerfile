# Stage 1: Install dependensi backend (Composer)
FROM composer:2 as vendor

WORKDIR /app
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Install dependensi frontend (NPM) dan build aset
FROM node:20 as assets

WORKDIR /app
COPY package.json package.json
COPY package-lock.json package-lock.json
RUN npm install
COPY . .
RUN npm run build

# Stage 3: Membuat image final
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apk --no-cache add nginx supervisor curl libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev
RUN docker-php-ext-install pdo pdo_mysql zip pcntl exif gd

# Copy file aplikasi dari direktori lokal ke dalam container
COPY . /var/www/html

# Copy dependensi dari stage sebelumnya
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=assets /app/public/build/ /var/www/html/public/build/

# Copy konfigurasi Nginx dan Supervisor
COPY .docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY .docker/supervisor/supervisord.conf /etc/supervisord.conf

# Set izin folder
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 untuk Nginx
EXPOSE 80

# Jalankan start-up script
ENTRYPOINT ["/var/www/html/.docker/start.sh"]