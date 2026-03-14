@echo off
REM Database Backup Script for XAMPP
REM This script backs up your MySQL database to prevent data loss

echo ========================================
echo   Smart Supermarket - Database Backup
echo ========================================
echo.

REM Set your database credentials (from .env file)
set DB_HOST=127.0.0.1
set DB_PORT=3306
set DB_DATABASE=smart_supermarket
set DB_USERNAME=root
set DB_PASSWORD=

REM Create backups directory if it doesn't exist
if not exist "database\backups" mkdir "database\backups"

REM Generate backup filename with timestamp
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set BACKUP_DATE=%datetime:~0,8%-%datetime:~8,6%
set BACKUP_FILE=database\backups\backup_%BACKUP_DATE%.sql

echo Creating backup...
echo Database: %DB_DATABASE%
echo Backup file: %BACKUP_FILE%
echo.

REM Path to XAMPP mysqldump (adjust if your XAMPP is installed elsewhere)
set MYSQLDUMP_PATH=C:\xampp\mysql\bin\mysqldump.exe

REM Check if mysqldump exists
if not exist "%MYSQLDUMP_PATH%" (
    echo ERROR: mysqldump not found at %MYSQLDUMP_PATH%
    echo Please update MYSQLDUMP_PATH in this script to match your XAMPP installation
    pause
    exit /b 1
)

REM Create backup
"%MYSQLDUMP_PATH%" -h %DB_HOST% -P %DB_PORT% -u %DB_USERNAME% %DB_DATABASE% > "%BACKUP_FILE%" 2>&1

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo   SUCCESS! Database backed up
    echo ========================================
    echo.
    echo Backup saved to: %BACKUP_FILE%
    echo.
    echo IMPORTANT: Copy this file to a safe location
    echo outside of XAMPP folder before reinstalling!
    echo.
) else (
    echo.
    echo ========================================
    echo   ERROR: Backup failed
    echo ========================================
    echo.
    echo Please check:
    echo 1. XAMPP MySQL is running
    echo 2. Database credentials are correct
    echo 3. Database exists
    echo.
)

pause
