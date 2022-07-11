## Descrição do Projeto

RentIngCarz - Leitura de API Futebol

### 🛠 Tecnologias

As seguintes ferramentas foram usadas na construção do projeto:

- [Laravel v7.30.4](https://laravel.com/docs/7.x)
- [PHP 7.4.3](https://www.php.net/downloads.php#v7.4.3)
- [MySql:5.7](https://www.mysql.com/)

Modelo Fazendo em Linux Ubunto 20.4

## Começando

Clone o repositório do projeto:

Caso você use HTTPS:

git clone https://github.com/dompossebon/rentingcarz.git

---------------------------------------------------------

Após a clonagem, entre no diretório da aplicação:

cd rentingcarz

docker-compose build rentingcarz-app

docker-compose up -d

Na raiz do projeto localize e Duplique o arquivo .env.example e em seguida renomeie-o para .env usando o comando:

cp .env.example .env

em seguida execute o comandos abaixo:

docker-compose exec rentingcarz-app composer install

---------------------------------------------------------

Então rode o comando:

- docker-compose exec rentingcarz-app php artisan key:generate

então siga digitando os comandos...

- docker-compose exec rentingcarz-app php artisan cache:clear

- docker-compose exec rentingcarz-app php artisan config:clear

- docker-compose exec rentingcarz-app php artisan migrate

- http://localhost:8000

---------------------------------------------------------

## COLOCANDO O SERVIDOR LARAVEL EM AÇÃO

## Construído com
Laravel - O framework PHP para artesãos da Web

## by Possebon
## Contato dompossebon@gmail.com

:+1: ## By Possebon
