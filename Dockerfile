FROM php:8.1.3-fpm-alpine

RUN docker-php-ext-install pdo_mysql
RUN apk add --no-cache libpng libpng-dev && docker-php-ext-install gd && apk del libpng-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
