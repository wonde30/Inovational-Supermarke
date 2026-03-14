# Database Backup Script for XAMPP (PowerShell)
# This script backs up your MySQL database to prevent data loss

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Smart Supermarket - Database Backup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Set your database credentials (from .env file)
$DB_HOST = "127.0.0.1"
$DB_PORT = "3306"
$DB_DATABASE = "smart_supermarket"
$DB_USERNAME = "root"
$DB_PASSWORD = ""

# Create backups directory if it doesn't exist
$backupDir = "database\backups"
if (-not (Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir | Out-Null
}

# Generate backup filename with timestamp
$timestamp = Get-Date -Format "yyyyMMdd-HHmmss"
$backupFile = "$backupDir\backup_$timestamp.sql"

Write-Host "Creating backup..." -ForegroundColor Yellow
Write-Host "Database: $DB_DATABASE"
Write-Host "Backup file: $backupFile"
Write-Host ""

# Path to XAMPP mysqldump (adjust if your XAMPP is installed elsewhere)
$mysqldumpPath = "C:\xampp\mysql\bin\mysqldump.exe"

# Check if mysqldump exists
if (-not (Test-Path $mysqldumpPath)) {
    Write-Host "ERROR: mysqldump not found at $mysqldumpPath" -ForegroundColor Red
    Write-Host "Please update mysqldumpPath in this script to match your XAMPP installation" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

# Create backup
try {
    if ($DB_PASSWORD -eq "") {
        & $mysqldumpPath -h $DB_HOST -P $DB_PORT -u $DB_USERNAME $DB_DATABASE | Out-File -FilePath $backupFile -Encoding UTF8
    } else {
        & $mysqldumpPath -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE | Out-File -FilePath $backupFile -Encoding UTF8
    }
    
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  SUCCESS! Database backed up" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Backup saved to: $backupFile" -ForegroundColor Green
    Write-Host ""
    Write-Host "IMPORTANT: Copy this file to a safe location" -ForegroundColor Yellow
    Write-Host "outside of XAMPP folder before reinstalling!" -ForegroundColor Yellow
    Write-Host ""
    
    # Show file size
    $fileSize = (Get-Item $backupFile).Length / 1KB
    Write-Host "Backup size: $([math]::Round($fileSize, 2)) KB" -ForegroundColor Cyan
    
} catch {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "  ERROR: Backup failed" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please check:" -ForegroundColor Yellow
    Write-Host "1. XAMPP MySQL is running" -ForegroundColor Yellow
    Write-Host "2. Database credentials are correct" -ForegroundColor Yellow
    Write-Host "3. Database exists" -ForegroundColor Yellow
    Write-Host ""
}

Read-Host "Press Enter to exit"
