FROM php:8.2.12-apache

# Install base dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev zlib1g-dev libpng-dev libxml2-dev libonig-dev nano git unzip 

# Install everything ELGG needs 
# This refers to the requirements at https://learn.elgg.org/en/stable/intro/install.html#requirements
RUN docker-php-ext-install gd pdo xml mbstring intl pdo_mysql

# Enable mod rewrite 
RUN a2enmod rewrite


# Install composer into the docker image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Download base ELGG into the image
ADD ./elgg-5.1.5.tar /var/www/html/


# Indicate that the elgg-config path is persistent
VOLUME [ "/var/www/html/elgg-config/" ]


# Copy Dr Ragbir-Shripat's elgg plugin
COPY ./mod/core /var/www/html/mod/core


# Copy Dr Ragbir-Shripat's database 
COPY ./sql /sql

EXPOSE 80