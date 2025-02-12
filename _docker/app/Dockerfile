FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install bcmath gd zip pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PHP_IDE_CONFIG="serverName=localhost"

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_docker/app/zzz-xdebug.ini /usr/local/etc/php/conf.d/20-xdebug.ini

RUN mkdir -p /var/www/storage/framework/{sessions,views,cache} && chmod -R 777 /var/www/storage
RUN chmod -R 777 /var/www/storage
WORKDIR /var/www
