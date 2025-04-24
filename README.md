# Hello CSE Test

## Versions
This project has been built with:
- Laravel 12
- PHP 8.4.1
- Composer 2.8.3

## Install

### If you have composer and PHP

Install composer dependencies:
```bash
composer install
```

### Via Docker

If you simply want to run the tests in the app, you can run (first run might be long): 

```bash
docker build -t laravel-hello-cse . && docker run --rm -v $(pwd):/app laravel-hellocse
```

## Feature used in the project

- Laravel Sanctum for authentication
- Policies for authorisations
- Phpunit for tests
- Service to separate responsibility
- Enum for Profil statuses
- Form Request to valide data
- Resources to format api response data.
- Factories to create 'Happy path' models
- Seeders have not been used
- etc.

## The project

All created routes can be listed:
```bash
php artisan route:list
```

To see middlewares added (like auth and policies):
```bash
 php artisan route:list -v
```

To run tests, make sur you have a fresh database (its using mysqli):
```bash
php artisan migrate:fresh
```

Then you can run your tests
```bash
 php artisan test
```


## Quality

### Models attributs

Models attributs and relation are updated via this command:

```bash
php artisan ide-helper:models -RW
```

### Fix PHP 

Laravel Pint is used to format PHP the "Laravel" way.

```bash
./vendor/bin/pint
```

### PHPStan

Level 6 is enough for a test, increase to 8 or 9 if this projet goes to production.

```bash
vendor/bin/phpstan analyse --memory-limit=512M -l 6 app
```
