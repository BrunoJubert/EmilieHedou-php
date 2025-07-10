FROM php:8.1-apache

RUN a2enmod rewrite \
    && docker-php-ext-install mysqli
