#!/bin/sh
set -e

# Jalankan cache untuk optimasi di produksi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Buat symbolic link untuk storage
# Perintah ini aman untuk dijalankan berkali-kali
php artisan storage:link

# Jalankan migrasi database
# Opsi --force diperlukan agar migrasi berjalan tanpa konfirmasi di lingkungan produksi
php artisan migrate --force

# Jalankan perintah utama yang diberikan oleh Dockerfile (misalnya, php-fpm)
exec "$@"