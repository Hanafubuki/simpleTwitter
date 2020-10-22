# Simple Twitter


## Table of Contents
- **[Introduction](#introduction)**
- **[Technologies](#technologies)**
- **[Setup](#setup)**
- **[Tests](#tests)**
- **[Project Structure](#project-structure)**
- **[Requirements Achieved](#requirements-achieved)**
- **[Things I would like to do](#improvements)**


## Introduction
Cloud-based backend service that emulates functionality similar to Twitter's Tweeting feature.


## Technologies
- PHP 7.3.1
- Laravel 8
- MySQL 8.0.2


## Setup
To run this project:
1. Clone this project: git clone https://github.com/Hanafubuki/simpleTwitter.git
2. cd simpleTwitter
3. Make a copy of .env.example file and create a new file: .env
4. Create a database named "linkx" inside your MySQL Database *
5. composer run-script first-initialization
6. php artisan serve

*In case you don't have MySQL/PHP installed, I recommend using XAMPP for a quick setup.


## Tests
### Add dummy data to DB
php artisan db:seed

### Run HTTP tests
php artisan test


## Project Structure
Used Laravel's official package [Passport](https://laravel.com/docs/8.x/passport) for user authentication.
Check if user has authorization to access the APIs with verification in the routes.
PSR-4: Autoloads factories, seeders and tests and, added autoload for helper functions.
Used DRY principles.

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


## Requirements Achieved
* Architectural design diagram of the solution
* Minimal backend design that achieves two things:
    * Any user can create a public message
    * Any user can read all messages


## Improvements (Things I would like to do)
Create service/action classes instead of just one controller class for user and tweet, to consider scalability.


## Sources
- **[Assignment](https://github.com/progress-tech-assignments/msg-rw-Hanafubuki/blob/master/README_assignment.md)**
- **[Laravel Documentation](https://laravel.com/docs)**
