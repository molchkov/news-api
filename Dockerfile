FROM php:8.3-fpm-alpine

RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash
RUN apk add --update linux-headers

RUN pecl install xdebug && docker-php-ext-enable xdebug;

COPY ./.docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

COPY ./ /var/www/news-api
WORKDIR /var/www/news-api

# Добавление Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000