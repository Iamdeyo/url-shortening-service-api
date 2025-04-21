#!/usr/bin/env bash

echo "Running composer"
cd /var/www/html
composer global require hirak/prestissimo
composer install --no-dev

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations and seeding data..."
php artisan migrate --force --seed
