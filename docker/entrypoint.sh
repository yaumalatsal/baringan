#!/bin/sh
set -e
cd /var/www

# Ensure the SQLite database exists and is writable
touch database/database.sqlite
chmod 666 database/database.sqlite

# Ensure storage is writable
chown -R www-data:www-data storage bootstrap/cache

# Generate APP_KEY if not set in the environment
if ! grep -q "^APP_KEY=" .env 2>/dev/null || grep -q "^APP_KEY=$" .env 2>/dev/null; then
    php artisan key:generate --force 2>/dev/null || true
fi

# Run migrations
php artisan migrate --force 2>/dev/null || true

echo "==> baringan ready"
exec "$@"
