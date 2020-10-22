# Simple Twitter


## Table of Contents
- **[Introduction](#introduction)**
- **[Technologies](#technologies)**
- **[Setup](#setup)**
- **[Tests](#tests)**
- **[Project Structure](#project-structure)**
- **[Requirements Achieved](#requirements-achieved)**
- **[Requirements not completed](#requirements-not-completed)**
- **[Things I would like to do](#improvements)**


## Introduction
Cloud-based backend service that emulates functionality similar to Twitter's Tweeting feature. 


## Technologies
- PHP 7.3.1
- Laravel 8
- MySQL 8.0.2


## Setup
To run this project:
1. Clone this project: git https://github.com/Hanafubuki/simpleTwitter.git
2. cd simpleTwitter
3. composer install
4. npm install && npm run dev
5. Create a database named "twitter" inside your MySQL Database *
5. php artisan migrate

* In case you don't have MySQL/PHP installed, I recommend using XAMPP for a quick setup.


## Tests
### Add dummy data to DB
php artisan db:seed

### Run HTTP tests
php artisan test




## Project Structure
### Models


### Middlewares
Transform json automatically in return methods: app/Http/Middleware/ForceJsonResponse.php

Accept CORS: app/Http/Middleware/ForceJsonResponse.php

### Helpers
Error messages: app/Helpers/errorHelper.php

User: app/Helpers/userHelper.php

### Tests, Factories, Seeder
database/factories

database/seeders

tests/Feature

## Laravel

- **[Documentation](https://laravel.com/docs)**
