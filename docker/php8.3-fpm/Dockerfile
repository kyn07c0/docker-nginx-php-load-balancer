FROM php:8.3-fpm-alpine

ENV TZ=Europe/Moscow

# Install alpine packages
RUN apk update && apk add --no-cache \
    postgresql-dev \
    zip \
    unzip \
    icu-data-full \
    pcre-dev \
    $PHPIZE_DEPS

# Install packeges from PECL
RUN pecl install redis && docker-php-ext-enable redis
