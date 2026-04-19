@echo off
echo ========================================
echo   JOB-lyNK Automatic Report Scheduler
echo ========================================
echo.
echo Starting Laravel Scheduler...
echo Reports will be generated automatically every Sunday at 11:59 PM
echo.
echo Press Ctrl+C to stop the scheduler
echo ========================================
echo.

php artisan schedule:work
