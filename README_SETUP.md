# Health and Wellness Program Tracker

A comprehensive web application for managing health and wellness programs with features for participants, coordinators, and administrators.

## Features

### For Participants

-   Browse and register for wellness programs
-   Track attendance at program sessions
-   Monitor personal health progress
-   View program schedules and details
-   Update health goals and personal notes

### For Program Coordinators

-   Create and manage wellness programs
-   Schedule and manage program sessions
-   Track participant attendance
-   Record and update participant progress metrics
-   Generate attendance and progress reports
-   Remove participants when necessary

### For System Administrators

-   Manage user accounts and roles
-   Configure system settings
-   View audit logs of all system activities
-   Monitor program statistics
-   Generate comprehensive reports

## Technology Stack

-   **Backend**: Laravel 11 (PHP 8.2+)
-   **Frontend**: HTML5, CSS3, Bootstrap 5.3
-   **Database**: MySQL/PostgreSQL
-   **Icons**: Font Awesome 6.4

## Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   MySQL/PostgreSQL
-   Node.js & NPM (optional, for asset compilation)

### Setup Steps

1. **Clone the repository**

    ```bash
    cd HW
    ```

2. **Install PHP dependencies**

    ```powershell
    composer install
    ```

3. **Environment Configuration**

    ```powershell
    Copy-Item .env.example .env
    ```

4. **Generate Application Key**

    ```powershell
    php artisan key:generate
    ```

5. **Configure Database**
   Edit `.env` file and set your database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=wellness_tracker
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. **Run Migrations**

    ```powershell
    php artisan migrate
    ```

7. **Seed Database with Sample Data**

    ```powershell
    php artisan db:seed
    ```

8. **Start Development Server**

    ```powershell
    php artisan serve
    ```

9. **Access the Application**
   Open your browser and navigate to: `http://localhost:8000`

## Default Login Credentials

After seeding the database, you can use these credentials:

### Administrator

-   Email: `admin@wellness.com`
-   Password: `password`

### Program Coordinator

-   Email: `coordinator1@wellness.com`
-   Password: `password`

### Participant

-   Email: `participant1@wellness.com`
-   Password: `password`

## Business Rules Implemented

### Participant Rules

✅ Can register for available programs
✅ Cannot register after enrollment deadline
✅ Can view registered programs and schedules
✅ Must check in for session attendance
✅ Can update health goals and progress notes
✅ Cannot delete past attendance records
✅ Limited to maximum number of active programs (configurable)

### Coordinator Rules

✅ Can create and manage programs
✅ Can update program schedules and sessions
✅ Must track attendance for each session
✅ Can enter and update progress metrics
✅ Can remove participants with valid reasons
✅ Can export attendance and progress reports

### Administrator Rules

✅ Can manage user accounts and assign roles
✅ Can set system configuration rules
✅ Can update wellness categories and metric templates
✅ Full access to system audit logs

### System-Level Rules

✅ Prevents overbooking by enforcing capacity limits
✅ Attendance tied to specific sessions and times
✅ Progress updates include date, value, and recorder
✅ Export functionality for reports
✅ Complete audit logging for all changes

## Project Structure

```
HW/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ParticipantController.php
│   │   │   ├── CoordinatorController.php
│   │   │   └── AdminController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Program.php
│       ├── Registration.php
│       ├── Session.php
│       ├── Attendance.php
│       ├── ProgressMetric.php
│       ├── AuditLog.php
│       └── SystemSetting.php
├── database/
│   ├── migrations/
│   │   ├── 2024_12_16_000003_add_role_to_users_table.php
│   │   ├── 2024_12_16_000004_create_programs_table.php
│   │   ├── 2024_12_16_000005_create_registrations_table.php
│   │   ├── 2024_12_16_000006_create_sessions_table.php
│   │   ├── 2024_12_16_000007_create_attendance_table.php
│   │   ├── 2024_12_16_000008_create_progress_metrics_table.php
│   │   ├── 2024_12_16_000009_create_audit_logs_table.php
│   │   └── 2024_12_16_000010_create_system_settings_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   │   └── custom.css
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── participant/
│       ├── coordinator/
│       └── admin/
└── routes/
    └── web.php
```

## Features Overview

### Modern UI/UX

-   Custom CSS with gradient backgrounds
-   Smooth animations and transitions
-   Responsive design for all devices
-   Intuitive navigation
-   Professional color scheme

### Security Features

-   Role-based access control
-   Password hashing
-   CSRF protection
-   Session management
-   Audit logging

### Database Design

-   Normalized database structure
-   Foreign key constraints
-   Proper indexing
-   Audit trail for all changes

## Development

### Clear Cache

```powershell
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Run Tests

```powershell
php artisan test
```

## Support

For issues or questions, please contact the development team.

## License

This project is proprietary and confidential.

---

**Made with ❤️ for Health & Wellness**
