FROM php:8.1-fpm-alpine


RUN apk add --no-cache postgresql-dev \
    libxml2-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer/composer /usr/bin/composer /usr/bin/composer