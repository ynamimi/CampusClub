FROM php:8.1-fpm

# Install system dependencies with cleanup
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip git nginx && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Optimized layer caching for dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --optimize-autoloader

# Copy application code
COPY . .

# Environment setup
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache

# Critical optimization steps
RUN composer dump-autoload --optimize && \
    php artisan key:generate --force && \
    php artisan storage:link && \
    php artisan optimize && \
    php artisan config:clear && \
    php artisan config:cache

# Nginx configuration
RUN mkdir -p /etc/nginx/sites-available && \
    mkdir -p /etc/nginx/sites-enabled && \
    rm -rf /etc/nginx/conf.d/default.conf

COPY nginx/default.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default &&

# PHP-FPM configuration
RUN sed -i 's/^listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/zz-docker.conf

# Logging setup
RUN touch storage/logs/laravel.log && \
    chown www-data:www-data storage/logs/laravel.log && \
    ln -sf /dev/stdout storage/logs/laravel.log

EXPOSE 8080

COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
