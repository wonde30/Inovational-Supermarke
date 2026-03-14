# Database Restore Script for XAMPP (PowerShell)
# This script restores your MySQL database from a backup file

Write-Host "========================================" -ForegroundColor Cyan
Write-Host " Smart Supermarket - Database Restore" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Set your database credentials (from .env file)
$DB_HOST = "127.0.0.1"
$DB_PORT = "3306"
$DB_DATABASE = "smart_supermarket"
$DB_USERNAME = "root"
$DB_PASSWORD = ""

# Check if backups directory exists
$backupDir = "database\backups"
if (-not (Test-Path $backupDir)) {
    Write-Host "ERROR: No backups directory found!" -ForegroundColor Red
    Write-Host "Please run backup-database.ps1 first to create a backup." -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# List available backups
Write-Host "Available backups:" -ForegroundColor Yellow
Write-Host ""
Get-ChildItem -Path $backupDir -Filter "*.sql" | ForEach-Object {
    $size = [math]::Round($_.Length / 1KB, 2)
    Write-Host "  $($_.Name) - $size KB - $($_.LastWriteTime)" -ForegroundColor Cyan
}
Write-Host ""

# Ask for backup file name
$backupFileName = Read-Host "Enter backup filename (e.g., backup_20260311-123456.sql)"

$backupFilePath = Join-Path $backupDir $backupFileName

# Check if file exists
if (-not (Test-Path $backupFilePath)) {
    Write-Host "ERROR: Backup file not found!" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host ""
Write-Host "WARNING: This will replace your current database!" -ForegroundColor Yellow
Write-Host "Database: $DB_DATABASE" -ForegroundColor Yellow
Write-Host "Backup file: $backupFileName" -ForegroundColor Yellow
Write-Host ""
$confirm = Read-Host "Are you sure you want to continue? (yes/no)"

if ($confirm -ne "yes") {
    Write-Host "Restore cancelled." -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 0
}

# Path to XAMPP mysql (adjust if your XAMPP is installed elsewhere)
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"

# Check if mysql exists
if (-not (Test-Path $mysqlPath)) {
    Write-Host "ERROR: mysql not found at $mysqlPath" -ForegroundColor Red
    Write-Host "Please update mysqlPath in this script to match your XAMPP installation" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host ""
Write-Host "Restoring database..." -ForegroundColor Yellow

try {
    # Drop and recreate database
    $dropCreateCmd = "DROP DATABASE IF EXISTS $DB_DATABASE; CREATE DATABASE $DB_DATABASE;"
    
    if ($DB_PASSWORD -eq "") {
        & $mysqlPath -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -e $dropCreateCmd
    } else {
        & $mysqlPath -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD -e $dropCreateCmd
    }
    
    # Restore from backup
    if ($DB_PASSWORD -eq "") {
        Get-Content $backupFilePath | & $mysqlPath -h $DB_HOST -P $DB_PORT -u $DB_USERNAME $DB_DATABASE
    } else {
        Get-Content $backupFilePath | & $mysqlPath -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE
    }
    
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  SUCCESS! Database restored" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Your database has been restored from: $backupFileName" -ForegroundColor Green
    Write-Host ""
    
} catch {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "  ERROR: Restore failed" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please check:" -ForegroundColor Yellow
    Write-Host "1. XAMPP MySQL is running" -ForegroundColor Yellow
    Write-Host "2. Database credentials are correct" -ForegroundColor Yellow
    Write-Host "3. Backup file is valid" -ForegroundColor Yellow
    Write-Host ""
}

Read-Host "Press Enter to exit"
