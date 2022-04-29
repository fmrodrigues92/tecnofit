## Requerimentos
- PHP 8.1

## Instalação
- composer install
- cp .env.example .env
- criar banco de dados collation utf8mb4_unicode_ci
- atualizar variaveis de ambiente no arquivo .env com o usuário, senha e nome da base de dados.
- php artisan db:migrate
- php artisan db:seed
- php artisan serve

## Utilização

Um servidor será executado no localhost:8000, a rota para acesso a api é:
- http://localhost:8000/api/ranking/{movement_id}