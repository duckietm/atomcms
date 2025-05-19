FROM dunglas/frankenphp

# Install extensions and dependencies
RUN install-php-extensions \
    pdo_mysql \
    redis \
    zip \
    gd \
    bcmath \
    exif \
    opcache \
    pcntl \
    sockets \
    intl

# Configure PHP
COPY ./docker/frankenphp/conf.d/app.ini /usr/local/etc/php/conf.d/app.ini

# Set permissions
RUN mkdir -p /app/storage /app/bootstrap/cache && \
    chown -R www-data:www-data /app && \
    chmod -R 775 /app/storage /app/bootstrap/cache

WORKDIR /app
