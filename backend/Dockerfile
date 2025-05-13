FROM dunglas/frankenphp

ENV SERVER_NAME=":8001"
ENV OCTANE_PORT=8001

WORKDIR /app

COPY . /app

RUN apt update && apt install -y zip libzip-dev libsodium-dev \
    && docker-php-ext-install zip pcntl pdo pdo_mysql sodium \
    && docker-php-ext-enable zip pcntl pdo pdo_mysql sodium

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8001

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]

