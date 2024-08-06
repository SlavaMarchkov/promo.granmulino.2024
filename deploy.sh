#!/bin/bash

set -e

echo "Deploying..."

git pull origin develop

php82 artisan down

php82 composer.phar install --no-dev --prefer-dist --optimize-autoloader

php82 artisan promo:install

php82 artisan config:cache
php82 artisan event:cache
php82 artisan route:cache
php82 artisan view:cache

php82 artisan up

echo "Deploy done!"
