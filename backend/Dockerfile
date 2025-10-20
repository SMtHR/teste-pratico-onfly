# Estágio 1: Builder - Instala dependências
FROM php:8.3-cli as builder

WORKDIR /var/www/html

# Instala dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libsqlite3-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_sqlite zip bcmath

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Otimização de cache: Copia apenas os arquivos de dependência primeiro
COPY composer.json composer.lock ./

# Instala as dependências do Composer sem rodar scripts
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Copia o restante do código da aplicação
COPY . .

# Gera o autoloader do Composer
RUN composer dump-autoload --optimize


# Estágio 2: Final - Imagem otimizada para execução
FROM php:8.3-cli

WORKDIR /var/www/html

# Instala apenas as extensões PHP necessárias para rodar a aplicação
RUN apt-get update && apt-get install -y libsqlite3-dev libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_sqlite zip bcmath

# Copia o código e as dependências do estágio de build
COPY --from=builder /var/www/html .
COPY --from=builder /usr/bin/composer /usr/bin/composer

# Copia e dá permissão de execução para o script de entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expõe a porta que o artisan serve usará
EXPOSE 8000

