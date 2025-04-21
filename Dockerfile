FROM richarvey/nginx-php-fpm:1.7.2

WORKDIR /var/www/html

# Copy app files
COPY . .

# Install composer dependencies during build
RUN composer install --no-dev --optimize-autoloader

# Cache Laravel config & routes
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force --seed

# Image config
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 0
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1
