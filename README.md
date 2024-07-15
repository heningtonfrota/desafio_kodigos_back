# Desafio Kodigos - Backend

Este repositório contém a aplicação backend desenvolvida em Laravel para o desafio da Kodigos, utilizando o banco de dados PostgreSQL.

## Pré-requisitos

Antes de começar, certifique-se de ter o Docker e Docker Compose instalados na sua máquina.

## Passo a Passo

### 1. Clonar o repositório

Clone este repositório na sua máquina local usando o comando:

```bash
git clone https://github.com/heningtonfrota/desafio_kodigos_back.git
```

### 2. Navegar até a pasta do projeto

Entre na pasta do projeto recém clonada:

```bash
cd desafio_kodigos_back
```

### 3. Configurar o ambiente

Copie o arquivo .env.example para .env:

```bash
cp .env.example .env
```

### 4. Configurar o banco de dados

No arquivo .env, utilize as seguintes configurações:

```bash
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=desafio_database
DB_USERNAME=desafio_user
DB_PASSWORD=desafio_password
```

### 5. Subir os containers do Docker

Suba os containers da aplicação usando o Docker Compose:

```bash
docker compose up -d
```

### 6. Acessar o container do aplicativo

Entre no container Docker da aplicação:

```bash
docker compose exec app bash
```

### 7. Baixar as dependncias da aplicação Laravel

Dentro do container, execute o comando para baixar as dependencias do Laravel:

```bash
composer install
```

### 8. Gerar a chave da aplicação Laravel

Dentro do container, execute o comando para gerar a chave do Laravel:

```bash
php artisan key:generate
```

### 9. Migrar e popular o banco de dados

Ainda dentro do container, execute o comando para criar as tabelas e popular o banco de dados:

```bash
php artisan migrate --seed
```

### 10. Acessar a aplicação

Após subir os containers, a aplicação estará disponível em http://localhost:10000/api/version para conferir.
