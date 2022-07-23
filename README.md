# Astronomer News Feed API

### Project Setup

1. install the dependencies

```shell
composer install
```

2. Copy `.env.example` to `.env`

```shell
cp .env.example .env
```

3. Generate application key

```shell
php artisan key:generate
```

4. Start the webserver

```shell
php artisan serve
```

## Database Migration and Seeding

Open your `.env` file and change the DATABASE options. You can start with SQLite by following these steps

1. Create a new MySQL database named `post_service`

2. you can run both migrations and seeders together by simply running the following command

```shell
php artisan migrate:fresh --seed
```

### API Postman Collection
You may import the API Postman collection with this link: https://www.getpostman.com/collections/9afa740b9c103b2a0f07


### Admin Account

The default admin user is **admin@astronomerguy.project** and the default password is **astronomer_guy**.


### Default Role for New Users

The `user` role is assigned to them when a new user is created.
