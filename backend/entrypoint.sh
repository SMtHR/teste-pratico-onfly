#!/bin/sh

# Sai imediatamente se um comando falhar
set -e

# Garante que as permissões de storage estão corretas
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Copia .env se não existir
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Gera a chave da aplicação se ela não estiver definida
php artisan key:generate

# Cria o arquivo do banco de dados SQLite se não existir
touch database/database.sqlite

# Roda as migrações e seeds.
# Este comando é seguro para ser executado múltiplas vezes se necessário.
php artisan migrate:fresh --force
php artisan db:seed --class=AdminSeeder

# Gera o segredo do JWT
php artisan jwt:secret --force

echo "Ambiente de backend pronto. Iniciando o servidor..."

# Executa o comando principal passado para o contêiner (o CMD do Dockerfile ou o 'command' do compose)
exec "$@"
