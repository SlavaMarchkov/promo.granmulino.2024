#!/bin/bash

set -e

echo "Deploying..."

git pull origin develop

php83 artisan down

php83 composer.phar install --no-dev --prefer-dist --optimize-autoloader

php83 artisan promo:install

php83 artisan config:cache
php83 artisan event:cache
php83 artisan route:cache
php83 artisan view:cache

php83 artisan up

echo "Deploy done!"
