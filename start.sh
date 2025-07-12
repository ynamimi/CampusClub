#!/bin/bash
# Fix permissions (critical for Render)
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start services
php-fpm -D
nginx -g "daemon off;"
