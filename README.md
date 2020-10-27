# Simple Twitter
<p><img src="SystemArchitecture2.png" width="600"></p>

## Table of Contents
- **[Introduction](#introduction)**
- **[Technologies](#technologies)**
- **[Setup](#setup)**
- **[APIs](#apis)**
- **[Tests](#tests)**
- **[Project Structure](#project-structure)**
- **[Requirements Achieved](#requirements-achieved)**
- **[Things I would like to do](#things-i-would-like-to-do)**


## Introduction
Cloud-based backend service that emulates functionality similar to Twitter's Tweeting feature. Has a simple and basic frontend implementation to show the functionality.

[AWS deployment](http://twitter-linkx.ap-northeast-1.elasticbeanstalk.com/)


## Technologies
- VueJs 2.6.12
- PHP 7.3.1
- Laravel 8
- MySQL 8.0.2


## Setup
To run this project:
1. Clone this project.
2. cd simpleTwitter
3. Make a copy of .env.example file and create a new file: .env
4. Create a database named "linkx" inside your MySQL Database *
5. composer run-script first-initialization
6. php artisan serve
7. You can go to localhost:8000 to see the frontend

*In case you don't have MySQL/PHP installed, I recommend using XAMPP for a quick setup.

## APIs
Check below the list of endpoints:
* https://documenter.getpostman.com/view/11082955/TVYDfKf4

## Tests
### Add dummy data to DB
php artisan db:seed

### Run HTTP tests
php artisan test


## Project Structure
<p><img src="ClassDiagram2.png" width="600"></p>

Used Laravel's official package [Passport](https://laravel.com/docs/8.x/passport) and header-based Token Bearer authentication scheme for user authentification.

Created verification in the routes to check if user has authorization to access the APIs.

PSR-4: Autoloads factories, seeders and tests and, added autoload for helper functions.

Used DRY principles.

Files created:

### Models
User: app/Models/User.php

Tweet: app/Models/Tweet.php

### Controllers
Authorization Controller: app/Http/Controllers/AuthsController.php

User Controller: app/Http/Controllers/UsersController.php

Tweet Controller: app/Http/Controllers/TweetsController.php

### Middlewares
Transform json automatically in return methods: app/Http/Middleware/ForceJsonResponse.php

Accept CORS: app/Http/Middleware/ForceJsonResponse.php

### Helpers
Error messages: app/Helpers/errorHelper.php

User: app/Helpers/userHelper.php

### Routes
API: routes/api.php

### Tests, Factories, Seeder
database/factories

database/seeders

tests/Feature

### Frontend code
VueJs code can be found here: resources/js


## Requirements Achieved
* Architectural design diagram of the solution
* Minimal backend design that achieves two things:
    * Any user can create a public message
    * Any user can read all messages


## Things I would like to do
Create more functionalitites of the twitter (likes, comments, attachments).

Create service/action classes instead of just one controller class for user and tweet, to consider scalability. Inside of app/Http, I would create a folder called Services and would add a class for each of the controller to add the service/action functions. Inside of each function, I would add the code to create/update the database information.


Improve frontend to apply all functionalities, creating a User Settings page to edit the user information. I would also add the functionallity to edit and delete tweets. Each user would also have their own profile page displaying all of their tweets.


## Sources
- **[Assignment](README_assignment.md)**
- **[Laravel Documentation](https://laravel.com/docs)**
