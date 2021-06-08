## 1. DOCUMENTAÇÃO
### 1.1 Endpoints
#### 1.1.1 Stores

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

--------------------------

```bash
/store/list
```
Lista as stores cadastradas no banco de dados<br/>
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


#### 1.1.2 Users

```bash
/user/create
```
Cadastra um usuário comum no banco de dados

Regras de entrada:
* name (string, obrigatório): Nome do usuário;
* cpf (string, obrigatório): CPF do usuário;
* email (string, obrigatório): Email do usuário; 
* password (string, obrigatório): Senha;
* password_confirmation (string, obrigatório): Confirmação de senha;
* balance (float, não obrigatório): saldo inicial.


Exemplo:

```json
{
  "name" : "Customer Name",
  "cpf" : "11111111111",
  "email" : "customer@mail.com",
  "password" : "Abc@1234",
  "password_confirmation" : "Abc@1234",
  "balance" : 100
}
```

Saída (objeto User):
* id (int): Id do usuário;
* isStore (boolean): Informa se o usuário é atrelado a uma loja;
* name (string): Nome do usuário;
* cpf (string): CPF do usuário;
* email (string): Email  do usuário;
* balance (float): Saldo atual do usuário;
* created_at (datetime): Criação do usuário;
* updated_at (datetime): Ultima atualização da informações.


Exemplo:

```json
{
  "name": "Customer Name",
  "cpf": "11111111111",
  "email": "customer@mail.com",
  "balance": 100,
  "isStore": false,
  "updated_at": "2021-06-08T15:45:42.000000Z",
  "created_at": "2021-06-08T15:45:42.000000Z",
  "id": 4
}
```
---------------------

```bash
/user/list
```
Lista os usuários normails cadastrados no banco de dados

Saída (Lista objeto User):

```json
[
  {
    "id": 2,
    "isStore": false,
    "name": "Customer 1",
    "cpf": "11111111111",
    "email": "customer@mail.com",
    "balance": 114.5,
    "created_at": "2021-06-08T15:37:13.000000Z",
    "updated_at": "2021-06-08T15:46:45.000000Z"
  },
  {
    "id": 4,
    "isStore": false,
    "name": "Customer 2",
    "cpf": "11111111112",
    "email": "customer2@mail.com",
    "balance": 80,
    "created_at": "2021-06-08T15:45:42.000000Z",
    "updated_at": "2021-06-08T15:46:45.000000Z"
  }
]
```

##### Transactions
```bash
/transaction/create
```
Cria uma transação entre usuários

Regras de entrada:
* value (float, obrigatório): Valor da transação;
* payer (int, obrigatório): Id do usuário que irá pagar;
* payee (int, obrigatório): Id do usuário que irá receber; 


Exemplo:

```json
{
  "value" : 20,
  "payer" : 4,
  "payee" : 2
}
```

Saída (objeto Transaction):
* amount (float): montante da transação
* payee_id (int): Id do usuário que recebeu o pagamento;
* payer_id (int): Id do usuário que efetuou o pagamento;
* notified (boolean): Informa se o usuário que recebeu o pagamento foi notificado;
* updated_at (datetime): Última data de atualização da transação;
* created_at (datetime): Data de atualização da transação;
* id (int): Id da transação;
* payer (array): usuário que efetuou o pagamento;
* payee (array): usuário que recebeu o pagamento;
* payer.id (int): Id do usuário;
* payer.isStore (boolean): Informa se o usuário é atrelado a uma loja;
* payer.name (string): Nome do usuário;
* payer.cpf (string): CPF do usuário;
* payer.email (string): Email  do usuário;
* payer.balance (float): Saldo atual do usuário;
* payer.created_at (datetime): Criação do usuário;
* payer.updated_at (datetime): Ultima atualização da informações.
* payee.id (int): Id do usuário;
* payee.isStore (boolean): Informa se o usuário é atrelado a uma loja;
* payee.name (string): Nome do usuário;
* payee.cpf (string): CPF do usuário;
* payee.email (string): Email  do usuário;
* payee.balance (float): Saldo atual do usuário;
* payee.created_at (datetime): Criação do usuário;
* payee.updated_at (datetime): Ultima atualização da informações.


Exemplo:

```json
{
  "amount": 20,
  "payee_id": 2,
  "payer_id": 4,
  "notified": true,
  "updated_at": "2021-06-08T15:46:45.000000Z",
  "created_at": "2021-06-08T15:46:45.000000Z",
  "id": 2,
  "payee": {
    "id": 2,
    "isStore": 0,
    "name": "Customer 1",
    "cpf": "11111111111",
    "email": "customer@mail.com",
    "balance": "114.50",
    "created_at": "2021-06-08T15:37:13.000000Z",
    "updated_at": "2021-06-08T15:46:45.000000Z"
  },
  "payer": {
    "id": 4,
    "isStore": 0,
    "name": "Customer 2",
    "cpf": "11111111112",
    "email": "customer2@mail.com",
    "balance": "80.00",
    "created_at": "2021-06-08T15:45:42.000000Z",
    "updated_at": "2021-06-08T15:46:45.000000Z"
  }
}
```
---------------------

```bash
/transaction/list
```
Lista as transações no banco de dados

Saída (Lista objeto Transação):

```json
[
  {
    "id": 1,
    "amount": 5.5,
    "notified": 1,
    "payer_id": 2,
    "payee_id": 1,
    "created_at": "2021-06-08T15:44:03.000000Z",
    "updated_at": "2021-06-08T15:44:03.000000Z",
    "payee": {
      "id": 1,
      "isStore": 1,
      "name": "Store 1",
      "cpf": "12895515700",
      "email": "store@mail.com",
      "balance": "105.50",
      "created_at": "2021-06-08T15:36:16.000000Z",
      "updated_at": "2021-06-08T15:44:03.000000Z"
    },
    "payer": {
      "id": 2,
      "isStore": 0,
      "name": "Customer 1",
      "cpf": "11111111111",
      "email": "customer@mail.com",
      "balance": "114.50",
      "created_at": "2021-06-08T15:37:13.000000Z",
      "updated_at": "2021-06-08T15:46:45.000000Z"
    }
  },
  {
    "id": 2,
    "amount": 20,
    "notified": 1,
    "payer_id": 4,
    "payee_id": 2,
    "created_at": "2021-06-08T15:46:45.000000Z",
    "updated_at": "2021-06-08T15:46:45.000000Z",
    "payee": {
      "id": 2,
      "isStore": 0,
      "name": "Customer 1",
      "cpf": "11111111111",
      "email": "customer@mail.com",
      "balance": "114.50",
      "created_at": "2021-06-08T15:37:13.000000Z",
      "updated_at": "2021-06-08T15:46:45.000000Z"
    },
    "payer": {
      "id": 4,
      "isStore": 0,
      "name": "Customer 2",
      "cpf": "11111111112",
      "email": "customer2@mail.com",
      "balance": "80.00",
      "created_at": "2021-06-08T15:45:42.000000Z",
      "updated_at": "2021-06-08T15:46:45.000000Z"
    }
  }
]
```

## 2 INSTALAÇÃO

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
