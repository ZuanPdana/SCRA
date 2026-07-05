# SCRA-Nightly

## Project Description

SCRA-Nightly is a web-based Classroom Rental Management System designed for universities to manage classroom reservations efficiently. It helps reduce manual scheduling work, prevent booking conflicts, and improve coordination between students, lecturers, staff, and administrators.

The system allows:

- Students to submit classroom reservation requests
- Lecturers or staff to verify reservations
- Administrators to manage classrooms, users, reservations, reports, and activity logs

The main objective of the system is to provide a structured, transparent, and reliable classroom booking workflow for academic environments.

This project also includes an optional IoT integration module for future automatic classroom door control. However, the application works fully without any IoT device.

## Key Features

- User authentication 🔐
- Role-based access control
- Classroom management
- Classroom reservation
- Reservation approval workflow
- Reservation history
- Classroom schedule management
- Activity logging
- Admin dashboard
- Responsive interface
- Optional IoT door integration

## Technology Stack

**Backend**
- Laravel 11
- PHP 8.2+

**Frontend**
- Blade
- Tailwind CSS

**Admin Panel**
- Filament 3

**Database**
- MySQL

**Authentication**
- Laravel Authentication

**Architecture**
- MVC

## User Roles

### Admin
- Manage classrooms
- Manage users
- Manage reservations
- View activity logs
- Generate reports

### Lecturer / Staff
- Review reservation requests
- Approve or reject reservations
- View classroom schedules

### Student
- Browse classrooms
- Check availability
- Submit reservation requests
- View reservation history
- Manage profile

## System Workflow

Student submits reservation  
↓  
Staff reviews request  
↓  
Reservation approved or rejected  
↓  
Student receives reservation status  
↓  
Reservation history is stored

## Future Development

- IoT automatic door access
- QR Code check-in
- Email notifications
- Calendar integration
- Mobile application
- Advanced reporting
- API integration

## License

This project is licensed under the MIT License.

## Author

**Developer:** Your Name  
**GitHub:** https://github.com/ZuanPdana/SCRA  

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
