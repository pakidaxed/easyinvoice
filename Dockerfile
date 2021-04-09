FROM php:8-fpm-alpine

RUN apk update \
    && apk add --no-cache composer make icu-dev autoconf g++ \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apk del --purge autoconf g++ make
