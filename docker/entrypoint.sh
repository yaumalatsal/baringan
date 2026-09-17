#!/bin/sh
set -e
cd /var/www

# Ensure the SQLite database exists and is writable
touch database/database.sqlite
chmod 666 database/database.sqlite

# Ensure storage is writable
chown -R www-data:www-data storage bootstrap/cache database/database.sqlite

# Generate APP_KEY if not set in environment
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force 2>/dev/null || true
fi

# Run package discovery (skipped during build with --no-scripts)
php artisan package:discover --ansi 2>/dev/null || true

# Run migrations
php artisan migrate --force 2>/dev/null || true

# Clear and cache config for production
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

echo "==> baringan ready"
exec "$@"
