# SCRA-Nightly

## Project Title

SCRA-Nightly

---

## Project Description

SCRA-Nightly is a web-based Classroom Rental Management System for universities that helps manage classroom reservations efficiently. It is designed to reduce manual scheduling, prevent double bookings, and streamline the reservation process across students, lecturers, staff, and administrators.

The system allows:

- Students to submit classroom reservation requests
- Lecturers or staff to verify reservations
- Administrators to manage classrooms, users, reservations, reports, and activity logs

The main objective of the system is to provide a structured, transparent, and reliable classroom booking workflow for academic environments.

This project also includes an optional IoT integration module for future automatic classroom door control. However, the application works perfectly without any IoT device.

---

## Features

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

---

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

---

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

---

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

---

## Screenshots

Store all screenshots in `docs/images/`.

### Login Page

![Login Page](docs/images/login-page.png)

Description:  
User login page.

---

### Student Dashboard

![Student Dashboard](docs/images/student-dashboard.png)

Description:  
Student dashboard after login.

---

### Admin Dashboard

![Admin Dashboard](docs/images/admin-dashboard.png)

Description:  
Administrator dashboard displaying system statistics.

---

### Classroom List

![Classroom List](docs/images/classroom-list.png)

Description:  
Available classrooms displayed to users.

---

### Classroom Details

![Classroom Details](docs/images/classroom-details.png)

Description:  
Detailed information about a selected classroom.

---

### Reservation Form

![Reservation Form](docs/images/reservation-form.png)

Description:  
Form for creating a classroom reservation.

---

### Reservation History

![Reservation History](docs/images/reservation-history.png)

Description:  
User reservation history.

---

### Reservation Verification

![Reservation Verification](docs/images/reservation-verification.png)

Description:  
Staff approval and rejection page.

---

### Classroom Management

![Classroom Management](docs/images/classroom-management.png)

Description:  
Admin page for managing classrooms.

---

### User Management

![User Management](docs/images/user-management.png)

Description:  
Admin page for managing users.

---

### Activity Logs

![Activity Logs](docs/images/activity-logs.png)

Description:  
Admin page showing activity logs.

---

### Reports

![Reports](docs/images/reports.png)

Description:  
Reservation reports and statistics.

---

## Repository Structure

```text
docs/
└── images/
    ├── login-page.png
    ├── student-dashboard.png
    ├── admin-dashboard.png
    ├── classroom-list.png
    ├── classroom-details.png
    ├── reservation-form.png
    ├── reservation-history.png
    ├── reservation-verification.png
    ├── classroom-management.png
    ├── user-management.png
    ├── activity-logs.png
    └── reports.png
```

---

## Future Development

- IoT automatic door access
- QR Code check-in
- Email notifications
- Calendar integration
- Mobile application
- Advanced reporting
- API integration

---

## License

This project is licensed under the MIT License.

---

## Author

**Developer:** Your Name  
**GitHub:** https://github.com/ZuanPdana/SCRA  
**Email:** your-email@example.com

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
