# Use uma imagem base do PHP 8.3 (Laravel 12 exigirá >= 8.2)
FROM php:8.3-cli

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências do sistema
# - libsqlite3-dev: Essencial para o pdo_sqlite
# - git, unzip, zip: Para o Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libsqlite3-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP comuns do Laravel + SQLite
RUN docker-php-ext-install pdo pdo_sqlite zip bcmath

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permite que o composer rode como root (necessário em alguns builds)
ENV COMPOSER_ALLOW_SUPERUSER=1

# O 'command' do docker-compose.yml cuidará de iniciar o servidor
