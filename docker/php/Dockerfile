FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    g++ \
    git \
    libicu-dev \
    libpq-dev \
    zip \
    libzip-dev  \
    zip \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \

RUN docker-php-ext-enable apcu
RUN docker-php-ext-install zip \
    && docker-php-ext-configure zip
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

ADD php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html