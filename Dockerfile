FROM php:8.2-fpm

# Install PHP extension dan tools
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /var/www

# Git safe directory (hindari error "dubious ownership")
RUN git config --global --add safe.directory /var/www

# Copy project (tidak perlu vendor di sini, pakai volume)
COPY . .

# Jangan composer install saat build, karena folder vendor akan tertimpa bind mount
# RUN composer install ← ini dihapus

# Set permission aman (storage dan bootstrap/cache)
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache