# Step 1: Use the official PHP image with FPM (FastCGI Process Manager)
FROM php:8.1-fpm

# Step 2: Install dependencies required for Laravel to work (like GD, MySQL, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Step 3: Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Step 4: Set the working directory inside the container
WORKDIR /var/www

# Step 5: Copy composer files (composer.json and composer.lock)
COPY composer.json composer.lock ./

# Step 6: Install PHP dependencies
RUN composer install --no-autoloader --no-scripts

# Step 7: Copy the rest of your application files to the container
COPY . .

# Step 8: Generate the Laravel autoloader
RUN composer dump-autoload --optimize

# Step 9: Set permissions for the Laravel app
RUN chown -R www-data:www-data /var/www

# Expose port 80 for the container to communicate
EXPOSE 80

# Step 10: Start PHP-FPM to run the application
CMD ["php-fpm"]
