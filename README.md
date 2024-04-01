# BOOK COLLECTION API (CRUD)

## Used Technologies:
- Laravel 10
- Docker
- nginx:1.25.3
- php 8.2
- MySQL 8.0
- Composer
- Postman (for testing)

## Laravel Features and Patterns:
- Routes
- Models
- Controllers
- Services
- Jobs
- Requests
- Repositories

## Інсталяція:

### clone git repository
```bash
git https://github.com/PryanikRainbow/book-selection.git
```

### install environment
```bash
cd docker-compose up -d
```
### copy .env file
```bash
cp .env.example .env
```

### artisan commands are available in the php container
```bash
composer docker exec -it bs-php /bin/bash

### run migrations
```bash
php artisan migrate
```
