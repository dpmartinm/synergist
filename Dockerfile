FROM php:7.3-alpine as start

RUN apk update && apk add --no-cache --virtual .build-deps \
    autoconf \
    zip \
    libzip-dev \
    readline


RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer && \
    chmod +x /usr/bin/composer

FROM start AS build

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader
