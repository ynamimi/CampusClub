FROM php:8.1-fpm

# 1. Install minimum required packages
RUN apt-get update && apt-get install -y \
    nginx libpng-dev libzip-dev git \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

# 2. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Setup app directory
WORKDIR /var/www
COPY . .

# 4. Fix permissions (MOST CRITICAL STEP)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 777 storage/framework

# 5. Install dependencies
RUN composer install --no-dev --optimize-autoloader

# 6. Generate app key
RUN [ -f .env ] || cp .env.example .env \
    && php artisan key:generate --force

# 7. Simple Nginx config
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# 8. Start command
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
