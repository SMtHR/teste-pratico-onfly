# ✈️ App Fullstack Onfly

Aplicação desenvolvida com Vue 3 (e Vuetify) e Laravel 12

---

## Instruções para testar a aplicação

- Clone o projeto do repositório: xxxxx
- Abra a pasta raiz do projeto
- Abra um terminal e aplique o comando:

```
docker compose up -d --build
```

O arquivo `compose.yaml` instalará todas as dependências, configurará o ambiente e subirá os containeres automaticamente.

- Aguarde até que os containeres terminem de montar

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

---

#### Informações adicionais

- O banco de dados é o SQLite, padrão do Laravel. Por isso, não é necessária nenhuma configuração adicional.
- Existem três formas de filtrar os pedidos por "Status" na aplicação:
  - Organizando os itens ao clicar no header "Status" na tabela de pedidos.
  - Pesquisando o status desejado no campo "Pesquise aqui" acima da tabela (Este campo pode ser usado para pesquisar qualquer outra propriedade dos pedidos, não somente o Status).
  - Utilizando queries strings na url:
    - Não foi possível incorporar está funcionalidade no escopo do front-end do projeto devido a funcionalidades semelhantes que a biblioteca utilizada fornece. Entretanto, a funcionalidade está implementada na API e pode ser testada enviando queries strings na URL.
    - Exemplos para teste:
      `http://localhost:8000/api/pedidos?status=solicitado`
      `http://localhost:8000/api/pedidos?status=aprovado`
      `http://localhost:8000/api/pedidos?status=cancelado`
      `http://localhost:8000/api/pedidos?status=solicitado&destino=Curitiba`
      Busca por pedidos com datas de ida e volta entre:
      `http://localhost:8000/api/pedidos?dt_ida=2025-10-25&dt_volta=2025-11-28`
      Busca por pedidos criados entre as datas:
      `http://localhost:8000/api/pedidos?dt_inicial=2025-10-25&dt_final=2025-11-28`
