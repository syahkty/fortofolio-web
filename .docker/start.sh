#!/bin/sh

set -e

# Jalankan migrasi dan linking storage
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
php artisan migrate --force

# Jalankan supervisor untuk mengelola Nginx dan PHP-FPM
exec /usr/bin/supervisord -c /etc/supervisord.conf