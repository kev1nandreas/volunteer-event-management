FROM php:8.4-fpm

# System deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpq-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install \
    pdo pdo_pgsql mbstring zip bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy only composer files for caching
COPY composer.json composer.lock ./

# Install dependencies without scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy full application
COPY . .

# Run post-autoload scripts now that artisan exists
RUN composer run-script post-autoload-dump

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]