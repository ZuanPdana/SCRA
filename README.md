# SCARA Alfa

SCARA Alfa is a Laravel 13 application with Filament.

## Requirements

- PHP 8.3 or later
- Composer 2+
- Node.js 22+ and npm
- MySQL 8+ or another supported Laravel database

Official docs:

- https://laravel.com/docs/13.x/installation
- https://laravel.com/docs/13.x/database
- https://laravel.com/docs/13.x/seeding

## Install

```bash
git clone <repository-url>
cd scara-alfa
composer install
npm install
cp .env.example .env
php artisan key:generate
```

For local development, Laravel recommends:

```bash
composer run dev
```

This starts the app server, queue worker, and Vite dev server.

## Configure the database

This project uses MySQL by default in `.env.example`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scra_classroom
DB_USERNAME=root
DB_PASSWORD=
```

Create the database before running migrations:

```sql
CREATE DATABASE scra_classroom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Update the same values in `.env` if your username, password, or database name are different.

## Migrate

Run all database migrations:

```bash
php artisan migrate
```

If you want to rebuild the database from scratch:

```bash
php artisan migrate:fresh
```

## Seed

The default seeder runs:

- `RoleSeeder`
- `UserSeeder`
- `ClassroomSeeder`

Seed the database:

```bash
php artisan db:seed
```

Reset and seed in one command:

```bash
php artisan migrate:fresh --seed
```

## Run locally

```bash
php artisan serve
```

In another terminal, if you are not using `composer run dev`, start Vite manually:

```bash
npm run dev
```

## Production build

```bash
npm run build
php artisan optimize
```
