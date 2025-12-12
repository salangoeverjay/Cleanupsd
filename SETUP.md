# Cleanup Laravel - Project Setup Guide

This guide will walk you through setting up the Cleanup Laravel project on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher** ([Download PHP](https://www.php.net/downloads.php))
- **Composer** ([Download Composer](https://getcomposer.org/download/))
- **MySQL/MariaDB** or **SQLite** (for database)
- **Node.js & npm** (for frontend assets) - Optional
- **Git** (for version control)

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url>
cd cleanup-laravel-main
```

### 2. Install PHP Dependencies

```bash
composer install
```

This will install all Laravel dependencies defined in `composer.json`.

### 3. Configure Environment

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials:

#### For MySQL/MariaDB:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cleanup_laravel
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### For SQLite (Development):
```env
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, DB_DATABASE not needed for SQLite
```

If using SQLite, create the database file:
```bash
touch database/database.sqlite
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

This creates a unique encryption key for your application.

### 5. Configure Mail Settings

For email verification to work, configure your mail settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** For Gmail, you need to use an [App Password](https://support.google.com/accounts/answer/185833).

### 6. Run Database Migrations

Create all necessary database tables:

```bash
php artisan migrate
```

### 7. Seed the Database (Optional)

Seed the database with sample data:

```bash
php artisan db:seed
```

Or seed specific data:

```bash
php artisan db:seed --class=AddMapCoordinatesSeeder
```

### 8. Install Frontend Dependencies (Optional)

If you need to compile frontend assets:

```bash
npm install
npm run dev
```

For production:
```bash
npm run build
```

### 9. Create Storage Link

Link the public storage directory:

```bash
php artisan storage:link
```

### 10. Start the Development Server

```bash
php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

## Default Access

### Register New Users

Visit: `http://127.0.0.1:8000/register`

Choose your role:
- **Organizer** - Can create cleanup events
- **Volunteer** - Can join events and report trash collected

### Email Verification

After registration, check your email for the verification link. Click it to activate your account.

## Key Features Setup

### 1. Event Map Locations

When creating events as an organizer:
- Click on the interactive map to pin event location
- The map uses **OpenStreetMap** (free, no API key needed)
- Coordinates are automatically saved

### 2. Profile Setup

After logging in:
- Click your name in the top navigation
- Select "Edit Profile"
- Add your contact number and address

### 3. Trash Collection Reporting

As a volunteer:
- Join an event from the Events page
- Go to your dashboard
- Click "Report Trash Collected" on any joined event
- Enter the amount in kilograms

## Project Structure

```
cleanup-laravel/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/                # Eloquent models
│   ├── Mail/                  # Email templates
│   └── Notifications/         # Custom notifications
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   └── views/                 # Blade templates
│       ├── dashboard/         # Dashboard views
│       │   ├── organizer/     # Organizer-specific views
│       │   └── volunteer/     # Volunteer-specific views
│       ├── emails/            # Email templates
│       └── layouts/           # Layout templates
├── routes/
│   └── web.php                # Web routes
└── public/                    # Public assets
```

## Database Tables

### Main Tables
- `user` - User accounts
- `user_details` - User contact information
- `organizer` - Organizer profiles
- `volunteer` - Volunteer profiles
- `event` - Cleanup events
- `event_location` - Event locations with coordinates
- `event_participation` - Volunteer-event relationships
- `trash_collection_record` - Trash reports per volunteer per event
- `organizer_chart` - Monthly organizer statistics
- `volunteer_chart` - Monthly volunteer statistics
- `pending_users` - Unverified user registrations

## Common Commands

### Clear Application Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Reset Database (Warning: Deletes all data!)
```bash
php artisan migrate:fresh --seed
```

### Run Specific Migration
```bash
php artisan migrate --path=database/migrations/2025_12_12_000000_create_event_table.php
```

### Rollback Last Migration
```bash
php artisan migrate:rollback --step=1
```

## Troubleshooting

### Issue: "Permission denied" on storage folder

**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: "Class not found" errors

**Solution:**
```bash
composer dump-autoload
```

### Issue: Email verification not working

**Solution:**
- Check `.env` mail configuration
- Ensure `MAIL_FROM_ADDRESS` is set
- For Gmail, use App Password instead of regular password
- Check spam folder for verification emails

### Issue: Maps not showing

**Solution:**
- Ensure events have map coordinates in database
- Run: `php artisan db:seed --class=AddMapCoordinatesSeeder`
- Check browser console for JavaScript errors
- Verify Leaflet.js is loading (check Network tab)

### Issue: Database connection error

**Solution:**
- Verify database credentials in `.env`
- For MySQL: Ensure MySQL service is running
- For SQLite: Ensure `database/database.sqlite` file exists
- Run: `php artisan config:clear`

## Technology Stack

- **Backend:** Laravel 11.x
- **Database:** MySQL/SQLite
- **Frontend:** Blade Templates, Bootstrap 5, Tailwind CSS
- **Maps:** Leaflet.js with OpenStreetMap
- **Charts:** Chart.js
- **Icons:** Bootstrap Icons

## Development Workflow

1. Make changes to code
2. Clear caches if needed: `php artisan config:clear`
3. Run migrations if database changes: `php artisan migrate`
4. Test locally: `php artisan serve`
5. Commit changes: `git commit -m "Description"`

## Production Deployment

### Preparation

1. Set environment to production:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize application:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set proper permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

4. Configure web server (Apache/Nginx) to point to `public/` directory

## Support & Documentation

- **Laravel Documentation:** https://laravel.com/docs
- **Leaflet Documentation:** https://leafletjs.com/reference.html
- **Bootstrap Documentation:** https://getbootstrap.com/docs

## License

This project is open-source software licensed under the MIT license.

---

**Last Updated:** December 12, 2025  
**Laravel Version:** 11.x  
**PHP Version:** 8.2+
