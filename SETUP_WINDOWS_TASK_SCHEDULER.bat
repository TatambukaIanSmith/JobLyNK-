@echo off
echo ========================================
echo   Setup Windows Task Scheduler
echo   for JOB-lyNK Automatic Reports
echo ========================================
echo.
echo This will create a Windows Task that runs every minute
echo to check if any scheduled tasks (like weekly reports) need to run.
echo.
echo Current directory: %CD%
echo.
pause

REM Create the task
schtasks /create /tn "JOB-lyNK-Scheduler" /tr "php %CD%\artisan schedule:run" /sc minute /mo 1 /ru "%USERNAME%" /f

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo   SUCCESS!
    echo ========================================
    echo.
    echo The Windows Task has been created successfully.
    echo.
    echo Task Name: JOB-lyNK-Scheduler
    echo Runs: Every minute
    echo Command: php artisan schedule:run
    echo.
    echo Your weekly reports will now be generated automatically
    echo every Sunday at 11:59 PM without any manual intervention.
    echo.
    echo To view the task:
    echo   - Open Task Scheduler (taskschd.msc)
    echo   - Look for "JOB-lyNK-Scheduler"
    echo.
    echo To remove the task later, run:
    echo   schtasks /delete /tn "JOB-lyNK-Scheduler" /f
    echo.
) else (
    echo.
    echo ========================================
    echo   ERROR!
    echo ========================================
    echo.
    echo Failed to create the task.
    echo Please run this script as Administrator.
    echo.
    echo Right-click this file and select "Run as administrator"
    echo.
)

pause
