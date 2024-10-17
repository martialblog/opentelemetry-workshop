# Example TODO App

## Setup

```
composer install

.env.example .env
php artisan key:generate

php artisan migrate --force

php artisan app:create-user foo@dev.internal foo@dev.internal
Created user foo@bar.com with password:

php artisan serve --port=5002
```
