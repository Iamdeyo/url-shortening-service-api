#!/usr/bin/env bash

echo "Running composer"
cd /var/www/html
composer install --no-dev --optimize-autoloader

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

# Keep the container running
exec "php-fpm"