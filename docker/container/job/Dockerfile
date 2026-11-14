FROM php:8.5

ENV TZ Asia/Tokyo

# 基本パッケージ & PHP 拡張
RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev libicu-dev \
  && docker-php-ext-install zip pdo_mysql intl \
  && docker-php-ext-enable intl

# systemd
RUN apt-get install -y systemd systemd-sysv procps

# PECL 拡張
RUN pecl install apcu redis \
  && docker-php-ext-enable apcu redis

# finaly
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www
RUN ln -s source rg
