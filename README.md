## Event Sourcing with Laravel

Questo repository contiene la live demo presentata al talk omonimo presentato al Laravel Day 2023

## Getting started 
### Clona il progetto 
`git clone https://github.com/cnastasi/event-sourcing-with-laravel.git`

### Installa le dipendenze
`composer install`

### Configura il tuo .env
Se avete PHP 8.2 installato in locale, il modo più semplice è usera un db sqlite

Creiamo il database sqlite
`touch storage/database.sqlite`

Dentro il tuo .env
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/assoluto/del/database/database.sqlite
```

Eseguire le migration
`php artisan migrate`
