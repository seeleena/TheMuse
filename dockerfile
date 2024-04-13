FROM php:8.0-apache

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql


RUN a2enmod rewrite

EXPOSE 80