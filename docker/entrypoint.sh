#!/bin/bash
set -e

echo "Running Laravel setup..."

php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ ! -f /var/www/html/.env ]; then
    echo "Creating .env file..."
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate
fi

php artisan storage:link 2>/dev/null || true

if [ "$1" != "queue" ]; then
    php artisan migrate --force
fi

exec "$@"
