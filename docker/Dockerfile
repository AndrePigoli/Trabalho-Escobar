FROM php:8.2-cli

ARG NODE_VERSION=18

RUN apt-get update \
    && apt-get install -y git unzip zip libzip-dev libicu-dev libpng-dev libonig-dev libxml2-dev mariadb-client curl gnupg ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql intl zip bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/start-andrecarros
RUN chmod +x /usr/local/bin/start-andrecarros

EXPOSE 8000

ENTRYPOINT ["start-andrecarros"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
