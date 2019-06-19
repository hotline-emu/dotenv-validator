FROM composer:1.8 AS composer
FROM php:7.3-alpine AS base

# Install dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /dotenv-validator
WORKDIR /dotenv-validator
RUN composer install \
    --no-progress \
    --no-suggest \
    --no-dev
