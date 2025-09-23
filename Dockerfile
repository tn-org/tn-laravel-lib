# ./Dockerfile
FROM php:8.4-cli-alpine

# よく使う拡張（必要に応じて増減）
RUN apk add --no-cache git unzip icu-dev libzip-dev oniguruma-dev \
    postgresql-dev make autoconf gcc g++ bash \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl zip pcntl bcmath pdo_pgsql

# Composer を同梱
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

ENV COMPOSER_CACHE_DIR=/tmp/cache

CMD ["bash"] 
