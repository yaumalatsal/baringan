# syntax=docker.io/docker/dockerfile:1

# ---- Stage 1: frontend assets ----
FROM node:24-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci 2>/dev/null || npm install --no-audit --no-fund
COPY . .
RUN npm run build

# ---- Stage 2: PHP application ----
FROM php:8.2-fpm

# Build deps: git for composer, libzip for Laravel, gd for images
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl libpng-dev libjpeg-dev libfreetype-dev libonig-dev libxml2-dev libzip-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=frontend /app/public/build ./public/build

WORKDIR /var/www

# Application code first (for caching, we copy deps + code together for Laravel)
COPY . .

# Install dependencies (skip scripts; package discovery runs at runtime)
RUN composer install --no-interaction --no-progress --prefer-dist --no-scripts --no-dev

# Frontend assets from stage 1
COPY --from=frontend /app/public/build ./public/build

# SQLite database
RUN touch database/database.sqlite && chmod 666 database/database.sqlite

# Storage permissions
RUN chown -R www-data:www-data storage bootstrap/cache database/database.sqlite

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]
