#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -d node_modules ]; then
    npm install
fi

if [ ! -d public/build ]; then
npm run build
fi

php artisan key:generate --force --ansi || true

if [ "${DB_CONNECTION}" != "sqlite" ]; then
    echo "Aguardando banco de dados para executar as migrations..."
    until php artisan migrate --force --no-interaction; do
        echo "Banco indisponível, tentando novamente em 5 segundos..."
        sleep 5
    done
fi

exec "$@"
