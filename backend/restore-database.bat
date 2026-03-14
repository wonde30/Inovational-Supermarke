@echo off
REM Database Restore Script for XAMPP
REM This script restores your MySQL database from a backup file

echo ========================================
echo  Smart Supermarket - Database Restore
echo ========================================
echo.

REM Set your database credentials (from .env file)
set DB_HOST=127.0.0.1
set DB_PORT=3306
set DB_DATABASE=smart_supermarket
set DB_USERNAME=root
set DB_PASSWORD=

REM Check if backups directory exists
if not exist "database\backups" (
    echo ERROR: No backups directory found!
    echo Please run backup-database.bat first to create a backup.
    pause
    exit /b 1
)

REM List available backups
echo Available backups:
echo.
dir /b "database\backups\*.sql"
echo.

REM Ask for backup file name
set /p BACKUP_FILE="Enter backup filename (e.g., backup_20260311-123456.sql): "

REM Check if file exists
if not exist "database\backups\%BACKUP_FILE%" (
    echo ERROR: Backup file not found!
    pause
    exit /b 1
)

echo.
echo WARNING: This will replace your current database!
echo Database: %DB_DATABASE%
echo Backup file: %BACKUP_FILE%
echo.
set /p CONFIRM="Are you sure you want to continue? (yes/no): "

if /i not "%CONFIRM%"=="yes" (
    echo Restore cancelled.
    pause
    exit /b 0
)

REM Path to XAMPP mysql (adjust if your XAMPP is installed elsewhere)
set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe

REM Check if mysql exists
if not exist "%MYSQL_PATH%" (
    echo ERROR: mysql not found at %MYSQL_PATH%
    echo Please update MYSQL_PATH in this script to match your XAMPP installation
    pause
    exit /b 1
)

echo.
echo Restoring database...

REM Drop and recreate database
"%MYSQL_PATH%" -h %DB_HOST% -P %DB_PORT% -u %DB_USERNAME% -e "DROP DATABASE IF EXISTS %DB_DATABASE%; CREATE DATABASE %DB_DATABASE%;" 2>&1

REM Restore from backup
"%MYSQL_PATH%" -h %DB_HOST% -P %DB_PORT% -u %DB_USERNAME% %DB_DATABASE% < "database\backups\%BACKUP_FILE%" 2>&1

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo   SUCCESS! Database restored
    echo ========================================
    echo.
    echo Your database has been restored from: %BACKUP_FILE%
    echo.
) else (
    echo.
    echo ========================================
    echo   ERROR: Restore failed
    echo ========================================
    echo.
    echo Please check:
    echo 1. XAMPP MySQL is running
    echo 2. Database credentials are correct
    echo 3. Backup file is valid
    echo.
)

pause
