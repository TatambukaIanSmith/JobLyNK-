# Database Setup Instructions for XAMPP

## Quick Setup Guide

### Step 1: Create Database in phpMyAdmin

1. Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin`)
2. Click on **"New"** in the left sidebar
3. Enter database name: `joblynk` (or any name you prefer)
4. Select **Collation**: `utf8mb4_unicode_ci`
5. Click **"Create"**

### Step 2: Import the SQL Schema

1. Select your newly created database from the left sidebar
2. Click on the **"Import"** tab at the top
3. Click **"Choose File"** button
4. Select the file: `database_schema.sql` from your project root
5. Click **"Go"** at the bottom

### Step 3: Update Laravel .env File

Update your `.env` file in the project root:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=joblynk
DB_USERNAME=root
DB_PASSWORD=
```

(Leave `DB_PASSWORD` empty if you haven't set a MySQL password in XAMPP)

### Step 4: Test the Connection

Run this command to test:
```bash
php artisan migrate:status
```

## Database Tables Created

The schema includes the following tables:

1. **users** - User accounts (workers, employers, admins)
2. **categories** - Job categories (pre-populated with 8 categories)
3. **job_postings** - Job listings posted by employers
4. **applications** - Applications submitted by workers
5. **messages** - Messages between users
6. **payments** - Payment records
7. **sessions** - Laravel session storage
8. **password_reset_tokens** - Password reset tokens
9. **cache** - Laravel cache storage
10. **jobs** - Laravel queue system (DO NOT MODIFY)

## Sample Data Included

- **8 Categories** pre-populated
- **2 Test Users**:
  - Worker: `test@example.com` / password: `password`
  - Employer: `employer@example.com` / password: `password`

## Troubleshooting

### If you get "Access denied" error:
- Check your MySQL username/password in `.env`
- Default XAMPP MySQL username is `root` with no password

### If foreign key constraints fail:
- Make sure you're using InnoDB engine (included in the SQL)
- Check that all tables were created successfully

### If you need to reset the database:
1. Drop all tables in phpMyAdmin
2. Re-import the `database_schema.sql` file

## Next Steps

After setting up the database:
1. Run `php artisan migrate:status` to verify
2. Start implementing the job posting functionality
3. Update controllers to use the database models

