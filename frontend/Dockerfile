FROM node:20-alpine

WORKDIR /app

# Otimização de cache: Copia apenas os arquivos de dependência primeiro
COPY package*.json ./

# Instala as dependências
RUN npm install

# Copia o restante do código da aplicação
COPY . .

# Expõe a porta do servidor de desenvolvimento
EXPOSE 5173
