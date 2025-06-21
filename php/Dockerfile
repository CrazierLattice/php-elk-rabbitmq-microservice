FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    librabbitmq-dev \
    && docker-php-ext-install pdo pdo_mysql zip sockets

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./src /var/www/html

WORKDIR /var/www/html

RUN composer install

RUN pecl install amqp && docker-php-ext-enable amqp