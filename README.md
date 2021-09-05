
# Barrigudinha Backoffice

## Setup

Antes de começar, garanta que você tem instalado na sua máquina:
- Git
- Docker Engine e o Docker Compose

- Baixe o repositório: `git clone git@github.com:gabrielgomes94/barrigudinha-backoffice.git`-
- Acesse o repositório: `cd barrigudinha-backoffice`

- Monte e suba os containers
```
docker-compose build
docker-compose up -d 
```

- Prepare os bancos de dados:
```
docker-compose exec db bash
psql -U barrigudinha_user
\l      # comando para listar todas as bases de dados presentes

DROP DATABASE IF EXISTS barrigudinha_dev;
DROP DATABASE IF EXISTS barrigudinha_test;

CREATE DATABASE barrigudinha_dev;
GRANT ALL PRIVILEGES ON DATABASE barrigudinha_dev TO barrigudinha_user;

CREATE DATABASE barrigudinha_test;
GRANT ALL PRIVILEGES ON DATABASE barrigudinha_test TO barrigudinha_user;
 
```

- Instale as dependências: `docker-compose exec app composer install`

- Copie o arquivo .env: `cp .env.example .env`
- Prepare o ambiente para desenvolvimento: `docker-compose exec app composer setup-dev`
- Entre no `tinker` e crie um token de API para seu usuário:
```
docker-compose exec app php artisan tinker
$user = User::first();
$user->createToken('token')->plainTextToken; // retorna o token do usuário
```
- E posteriormente, adicione esse token no .env:
```
API_KEY=token
```

- Configure o arquivo `/etc/hosts` da seguinte maneira:
```
127.0.0.1       barrigudinha.test
```

- Acesse a aplicação em: 
```
barrigudinha.test:8000
```
