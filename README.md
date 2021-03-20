
# Barrigudinha Backoffice

## Setup

Antes de começar, garanta que você tem instalado na sua máquina:
- Git
- Docker Engine e o Docker Compose

- Baixe o repositório: `git clone git@github.com:gabrielgomes94/barrigudinha-backoffice.git`-

- Monte e suba os containers
```
docker-compose build
docker-compose up -d 
```

- Instale as dependências: `composer install`

- Gere a chave do Laravel: `php artisan key:generate`

- Rode as migrações: `php artisan migrate`

- Rode o seed: `php artisan db:seed`

- Configure o arquivo `/etc/hosts` da seguinte maneira:
```
127.0.0.1       barrigudinha.test
```

- Acesse a aplicação em: 
```
barrigudinha.test:8000
```
