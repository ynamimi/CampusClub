#!/bin/bash

# Clear cached files
composer install --no-dev --optimize-autoloader
php artisan optimize
php artisan route:cache
php artisan view:cache

# Start PHP-FPM with error logging
php-fpm -D -y /usr/local/etc/php-fpm.conf -F -R 2>&1 | tee -a storage/logs/php-fpm.log &

# Wait for PHP-FPM to start
sleep 5  # Adjust this as needed

# Start Nginx in foreground
nginx -g "daemon off; error_log /dev/stderr;"
