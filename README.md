## Documentação
###Endpoints
##### Stores
```bash
/store/create
```
Cadastra uma store no banco de dados<br/>
Regras de entrada:
* name (string, obrigatório): Nome da nova loja;
* cpf (string, obrigatório): CPF do usuário que criou a loja;
* cnpj (string, obrigatório): CNPJ da loja;
* email (string, obrigatório): Email do usuário que criou a loja; 
* password (string, obrigatório): Senha;
* password_confirmation (string, obrigatório): Confirmação de senha;
* balance (float, não obrigatório): saldo inicial.
<br/>
<br/>
Exemplo:
```json
{
  "name" : "Store Name",
  "cpf" : "12312312312",
  "cnpj" : "12345676912345",
  "email" : "store@mail.com",
  "password" : "Abc@1234",
  "password_confirmation" : "Abc@1234",
  "balance" : 100
}
```

Saída (objeto Store):
* cnpj (string): CNPJ da loja criada;
* user_id (int): Id do usuário dono da loja;
* id (int): Id da loja;
* user (array): Lista de informações sobre o usuário atrelado a loja;
* user.id (int): Id do usuário;
* user.isStore (boolean): Informa se o usuário é atrelado a uma loja;
* user.name (string): Nome do usuário;
* user.cpf (string): CPF do usuário;
* user.email (string): Email  do usuário;
* user.balance (float): Saldo atual do usuário;
* user.created_at (datetime): Criação do usuário;
* user.updated_at (datetime): Ultima atualização da informações.
<br/>
<br/>
Exemplo:
```json
{
  "cnpj": "12345676912345",
  "user_id": 3,
  "id": 2,
  "user": {
    "id": 3,
    "isStore": 1,
    "name": "Store Name",
    "cpf": "12312312312",
    "email": "store@mail.com",
    "balance": 100,
    "created_at": "2021-06-08T15:45:20.000000Z",
    "updated_at": "2021-06-08T15:45:20.000000Z"
  }
}
```

```bash
/store/create
```
Cadastra uma store no banco de dados<br/>


Saída (Lista objeto stores):
```json
[
  {
    "id": 1,
    "cnpj": "12345678912345",
    "user_id": 1,
    "created_at": null,
    "updated_at": null,
    "user": {
      "id": 1,
      "isStore": true,
      "name": "Store 1",
      "cpf": "12312312300",
      "email": "store@mail.com",
      "balance": 105.5,
      "created_at": "2021-06-08T15:36:16.000000Z",
      "updated_at": "2021-06-08T15:44:03.000000Z"
    }
  },
  {
    "id": 2,
    "cnpj": "12345676900000",
    "user_id": 3,
    "created_at": null,
    "updated_at": null,
    "user": {
      "id": 3,
      "isStore": true,
      "name": "Store 2",
      "cpf": "12312332100",
      "email": "store2@mail.com",
      "balance": 100,
      "created_at": "2021-06-08T15:45:20.000000Z",
      "updated_at": "2021-06-08T15:45:20.000000Z"
    }
  }
]
```
##### Users

##### Transactions

## Instação

para realizar o deploy é necessário ter instalado no seu local o [docker](https://www.docker.com/get-started) e o [docker-compose](https://docs.docker.com/compose/install/) e seguir os seguintes passos:
> 1. acesse a pasta do sistema e copie o arquivo .env de exemplo

```bash
$ cp .env.example .env
```

> 2. dê permissão de execução ao arquivo bin na raiz do projeto

```bash
$ chmod u+x bin 
```

> 3. Iniciar os containers PHP + MySql

```bash
$ ./bin up -d
```

> 4. Baixe as bibliotecas necessárias

```bash
$ ./bin composer update
```

> 5. Construa o banco de dados

```bash
$ ./bin artisan migrate
```

Realizado esses passos sem erros, o projeto deverá estar rodando no seu [localhost](http://localhost/).

Caso queira rodar os testes, execute o comando
```bash
$ ./bin phpunit
```

Para derrubar o servidor, execute o comando
```bash
$ ./bin down
```
