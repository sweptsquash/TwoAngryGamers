# syntax=docker/dockerfile:experimental

FROM composer:latest as build

FROM php:8.0-apache as base

RUN apt-get update && apt-get install -y \
    g++ \
    ssh \
    git \
    vim \
    zip \
    wget \
    make \
    unzip \
    ffmpeg \
    dialog \
    locales \
    libtool \
    optipng \
    autoconf \
    pngquant \
    gifsicle \
    ssl-cert \
    jpegoptim \
    apt-utils \
    libssl-dev \
    libzip-dev \
    libpng-dev \
    libxpm-dev \
    zlib1g-dev \
    libwebp-dev \
    libonig-dev \
    ca-certificates \
    build-essential \
    libfreetype6-dev \
    libmagickwand-dev \
    libjpeg62-turbo-dev
RUN apt-get clean

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN wget -P /etc/ssl/certs https://curl.haxx.se/ca/cacert.pem

RUN sed -n 's/^;date\.timezone[[:space:]]=.*$/date.timezone="UTC"/' "$PHP_INI_DIR/php.ini"
RUN sed -n "s/^;curl\.cainfo[[:space:]]=.*$/curl.cainfo=\/etc\/ssl\/certs\/cacert.pem/" "$PHP_INI_DIR/php.ini"
RUN sed -n "s/^;openssl\.cafile=.*$/openssl.cafile=\/etc\/ssl\/certs\/cacert.pem/" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-configure gd \
        --with-webp \
        --with-freetype \
        --with-jpeg \
        --with-xpm

RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo_mysql zip exif pcntl

RUN export COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite headers brotli ssl
RUN service apache2 restart

EXPOSE 80
EXPOSE 443

FROM base
RUN mkdir -m 777 /var/www/twoangrygamers.test
WORKDIR /var/www/twoangrygamers.test
COPY --chown=www-data:www-data . .
