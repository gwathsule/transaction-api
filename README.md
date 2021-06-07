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

Realizado esses passos sem erros, o projeto deverá estar rodando no seu [localhost](http://localhost/).

Caso queira rodar os testes, execute o comando
```bash
$ ./bin phpunit
```

Para derrubar o servidor, execute o comando
```bash
$ ./bin down
```
