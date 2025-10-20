#!/bin/sh

set -e

chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate

touch database/database.sqlite

php artisan migrate:fresh --force
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=PedidoSeeder

php artisan jwt:secret --force

echo "Ambiente de backend pronto. Iniciando o servidor..."

exec "$@"
