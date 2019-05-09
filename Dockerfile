FROM php:apache

RUN apt-get update \
 && apt-get install -y libpq-dev libzip-dev \
 && docker-php-ext-install pdo_pgsql zip

COPY --from=composer /usr/bin/composer /usr/bin/composer
