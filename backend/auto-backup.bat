@echo off
REM Automatic Daily Backup Script
REM Add this to Windows Task Scheduler to run daily

echo ========================================
echo   Auto Backup - %date% %time%
echo ========================================

REM Set your database credentials
set DB_HOST=127.0.0.1
set DB_PORT=3306
set DB_DATABASE=smart_supermarket
set DB_USERNAME=root
set DB_PASSWORD=

REM Create backups directory
if not exist "database\backups" mkdir "database\backups"

REM Generate backup filename with date
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set BACKUP_DATE=%datetime:~0,8%-%datetime:~8,6%
set BACKUP_FILE=database\backups\auto_backup_%BACKUP_DATE%.sql

REM Path to XAMPP mysqldump
set MYSQLDUMP_PATH=C:\xampp\mysql\bin\mysqldump.exe

REM Create backup
"%MYSQLDUMP_PATH%" -h %DB_HOST% -P %DB_PORT% -u %DB_USERNAME% %DB_DATABASE% > "%BACKUP_FILE%" 2>&1

if %ERRORLEVEL% EQU 0 (
    echo Backup successful: %BACKUP_FILE%
    
    REM Delete backups older than 30 days
    forfiles /p "database\backups" /m *.sql /d -30 /c "cmd /c del @path" 2>nul
) else (
    echo Backup failed!
)

REM Log to file
echo %date% %time% - Backup completed >> database\backups\backup.log
