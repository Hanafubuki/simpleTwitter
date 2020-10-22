
## Installation
composer install

php artisan migrate



## Tests
#### Add dummy data to DB
php artisan db:seed

#### Run HTTP tests
php artisan test



## About Project

### Added extra data:
#### Middlewares
Transform json automatically in return methods: app/Http/Middleware/ForceJsonResponse.php
Accept CORS: app/Http/Middleware/ForceJsonResponse.php

#### Helpers
Error messages: app/Helpers/errorHelper.php
User: app/Helpers/userHelper.php

#### Tests, Factories, Seeder
database/factories
database/factories
database/seeders
tests/Feature

## Laravel

- **[Documentation](https://laravel.com/docs)**
