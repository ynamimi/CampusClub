#!/bin/bash
# Clear cached files
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Start PHP-FPM with error logging
php-fpm -D -y /usr/local/etc/php-fpm.conf -F -R 2>&1 | tee -a storage/logs/php-fpm.log &

# Start Nginx in foreground
nginx -g "daemon off; error_log /dev/stderr;"
