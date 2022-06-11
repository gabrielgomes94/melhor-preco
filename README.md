
# Barrigudinha Backoffice

## Setup

Antes de começar, garanta que você tem instalado na sua máquina:
- Git
- Docker Engine e o Docker Compose

- Baixe o repositório: `git clone git@github.com:gabrielgomes94/melhor-preco.git`-
- Acesse o repositório: `cd melhor-preco`

- Monte e suba os containers
```
docker-compose build
docker-compose up -d 
```

- Prepare os bancos de dados:
```
docker-compose exec db bash
psql -U melhorpreco_user
\l      # comando para listar todas as bases de dados presentes

DROP DATABASE IF EXISTS melhorpreco_dev;
DROP DATABASE IF EXISTS melhorpreco_test;

CREATE DATABASE melhorpreco_dev;
GRANT ALL PRIVILEGES ON DATABASE melhorpreco_dev TO barrigudinha_user;

CREATE DATABASE melhorpreco_test;
GRANT ALL PRIVILEGES ON DATABASE melhorpreco_test TO barrigudinha_user;
 
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
127.0.0.1       melhorpreco.test
```

- Acesse a aplicação em: 
```
melhorpreco.test:8000
```
