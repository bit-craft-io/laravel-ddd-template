FROM php:8.5-fpm

## config container
ENV TZ Asia/Tokyo

#COPY php.ini /usr/local/etc/php/
RUN apt-get update \
  && apt-get install -y unzip zlib1g-dev mariadb-client vim libzip-dev \
  && docker-php-ext-install zip pdo_mysql \
  && apt-get install -y libicu-dev

## install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

## install php-extention
RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install redis && docker-php-ext-enable redis

## install xhprof
RUN pecl install xhprof && docker-php-ext-enable xhprof \
    && mkdir -p /var/log/xhprof \
    && chmod 777 /var/log/xhprof
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN apt-get install -y graphviz

## dependencies for protobuf (bcmath for big int support, intl for general compatibility)
RUN docker-php-ext-install intl && docker-php-ext-enable intl
RUN docker-php-ext-install bcmath

## install systemd
RUN apt-get install -y systemd systemd-sysv

# WORKDIR /var/www/source
