FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# 1. First copy only what's needed for composer install
COPY composer.json composer.lock ./

# 2. Install dependencies
RUN composer install --no-autoloader --no-scripts --no-dev

# 3. Copy the rest of the application
COPY . .

# 4. Set up environment
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# 5. Generate autoload and optimize
RUN composer dump-autoload --optimize && \
    php artisan optimize:clear && \
    php artisan key:generate && \
    php artisan optimize

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Configure Nginx
RUN mkdir -p /etc/nginx/sites-available && \
    mkdir -p /etc/nginx/sites-enabled

COPY nginx/default.conf /etc/nginx/sites-available/default
RUN rm -f /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Configure PHP-FPM
RUN sed -i 's/^listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/zz-docker.conf

EXPOSE 8080

COPY start.sh /start.sh
RUN chmod +x /start.sh
# Add these right before CMD
RUN php artisan storage:link && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Ensure this exists for logging
RUN touch /var/www/storage/logs/laravel.log && \
    chown www-data:www-data /var/www/storage/logs/laravel.log
CMD ["/start.sh"]
