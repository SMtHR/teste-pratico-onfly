# ✈️ App Fullstack Onfly

Aplicação desenvolvida com Vue 3 (e Vuetify) e Laravel 12

---

## Instruções para testar a aplicação

- Clone o projeto do repositório

```
git clone https://github.com/SMtHR/teste-pratico-onfly.git
```

- Abra a pasta raiz do projeto
- Abra um terminal e aplique o comando:

```
docker compose up -d --build
```

O arquivo `compose.yaml` instalará todas as dependências, configurará o ambiente e subirá os containeres automaticamente.

- Aguarde até que os containeres terminem de montar e estejam 100% operantes.

---

### 🔹Front-end

- Acesse a aplicação através da url _http://localhost:5179_
- A API cria um usuário "Admin" automaticamente. Para entrar com esta conta, acesse a aplicação com as credenciais:

  > Email: admin@admin.com
  > Senha: adminpassw

Obs.: Para testar com um usuário que não tenha privilégios de administrador, registre um novo usuário através do botão "Registrar" na tela de login.

- Para fins de teste, os botões de aprovar e cancelar pedidos estão disponíveis mesmo para usuários não administradores.

### 🔹 Back-end

- A API é acessível através da url _http://localhost:8000_.
- Para executar os testes, acesse o container através do aplicativo Docker Desktop, vá na aba "Exec" e rode o comando:

```
php artisan test
```

- Caso o comando não rode dentro do container, abra o diretório do backend e rode o mesmo comando em um terminal.

---

#### Informações adicionais

- O banco de dados é o SQLite, padrão do Laravel. Por isso, não é necessária nenhuma configuração adicional.
- Existem três formas de filtrar os pedidos por "Status" na aplicação:

  - Organizando os itens ao clicar no header "Status" na tabela de pedidos.
  - Pesquisando o status desejado no campo "Pesquise aqui" acima da tabela (Este campo pode ser usado para pesquisar qualquer outra propriedade dos pedidos, não somente o Status).
  - Utilizando queries strings na URI:

    - Não foi possível incorporar está funcionalidade no front-end do projeto, mas há funcionalidade semelhante fornecida pela biblioteca utilizada, como descrito acima. A funcionalidade em si está implementada na API e pode ser testada enviando queries strings na URI.

    - Utilizando o Postman ou softwares similares, insira seu token de autenticação JWT, que se encontrará no Local Storage do seu navegador após o login, no cabeçalho da requisição e teste as seguintes URIs de exemplo:

      > Obs.: Tenha certeza de que existam pedidos condizentes com as condições presentes nestas URIs. Ajuste os parâmetros como achar necessário.

      - `http://localhost:8000/api/pedidos?status=solicitado`
      - `http://localhost:8000/api/pedidos?status=aprovado`
      - `http://localhost:8000/api/pedidos?status=cancelado`
      - `http://localhost:8000/api/pedidos?status=solicitado&destino=Curitiba`
        Busca por pedidos com datas de ida e volta entre:
      - `http://localhost:8000/api/pedidos?dt_ida=2025-10-25&dt_volta=2025-11-28`
        Busca por pedidos criados entre as datas:
      - `http://localhost:8000/api/pedidos?dt_inicial=2025-10-25&dt_final=2025-11-28`
        <br>

    - Minha ideia era utilizar esta funcionalidade para filtrar os pedidos a partir do clique nos contadores ao lado da tabela, atualizando a tabela de acordo. Infelizmente, como a biblioteca fornecia funcionalidade semelhante, optei por deixar essa implementação por último, mas não consegui realizá-la em tempo hábil.
