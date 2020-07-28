#!/usr/bin/env bash
cd /var/www/core.giftype.com
git pull
composer install
php artisan migrate
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan route:cache
php artisan config:cache
