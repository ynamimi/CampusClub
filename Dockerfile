FROM php:8.1-fpm

# Install dependencies including zip
RUN apt-get update && apt-get install -y \
    nginx libpng-dev libzip-dev git \
    unzip zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && apt-get clean

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate key
RUN [ -f .env ] || cp .env.example .env \
    && php artisan key:generate --force

# Nginx config
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

RUN ls -la /var/www/public && \
    ls -la /var/www/public/index.php
    
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
