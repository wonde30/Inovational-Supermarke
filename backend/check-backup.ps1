# Backup Verification Script
# Checks if your backup is valid and shows information

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Backup Verification Tool" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$backupDir = "database\backups"

# Check if backups directory exists
if (-not (Test-Path $backupDir)) {
    Write-Host "❌ No backups found!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Run backup-database.ps1 to create your first backup." -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# Get all backup files
$backups = Get-ChildItem -Path $backupDir -Filter "*.sql" | Sort-Object LastWriteTime -Descending

if ($backups.Count -eq 0) {
    Write-Host "❌ No backup files found in $backupDir" -ForegroundColor Red
    Write-Host ""
    Write-Host "Run backup-database.ps1 to create your first backup." -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host "✅ Found $($backups.Count) backup(s)" -ForegroundColor Green
Write-Host ""
Write-Host "Backup Files:" -ForegroundColor Yellow
Write-Host "============================================" -ForegroundColor Cyan

foreach ($backup in $backups) {
    $size = [math]::Round($backup.Length / 1KB, 2)
    $age = (Get-Date) - $backup.LastWriteTime
    
    Write-Host ""
    Write-Host "📄 $($backup.Name)" -ForegroundColor Cyan
    Write-Host "   Size: $size KB" -ForegroundColor White
    Write-Host "   Date: $($backup.LastWriteTime.ToString('yyyy-MM-dd HH:mm:ss'))" -ForegroundColor White
    Write-Host "   Age: $([math]::Round($age.TotalDays, 1)) days old" -ForegroundColor White
    
    # Check if backup is valid (not empty)
    if ($backup.Length -gt 1000) {
        Write-Host "   Status: ✅ Valid" -ForegroundColor Green
    } elseif ($backup.Length -gt 0) {
        Write-Host "   Status: ⚠️ Suspicious (very small)" -ForegroundColor Yellow
    } else {
        Write-Host "   Status: ❌ Empty (invalid)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Show latest backup info
$latest = $backups[0]
$latestSize = [math]::Round($latest.Length / 1KB, 2)

Write-Host "Latest Backup:" -ForegroundColor Yellow
Write-Host "  File: $($latest.Name)" -ForegroundColor Cyan
Write-Host "  Size: $latestSize KB" -ForegroundColor Cyan
Write-Host "  Date: $($latest.LastWriteTime.ToString('yyyy-MM-dd HH:mm:ss'))" -ForegroundColor Cyan
Write-Host ""

# Recommendations
Write-Host "💡 Recommendations:" -ForegroundColor Yellow
Write-Host ""

$latestAge = (Get-Date) - $latest.LastWriteTime

if ($latestAge.TotalDays -gt 7) {
    Write-Host "⚠️  Your latest backup is $([math]::Round($latestAge.TotalDays, 1)) days old" -ForegroundColor Yellow
    Write-Host "   Consider creating a fresh backup!" -ForegroundColor Yellow
} else {
    Write-Host "✅ Your backup is recent (less than 7 days old)" -ForegroundColor Green
}

if ($latest.Length -lt 10000) {
    Write-Host "⚠️  Backup file seems small" -ForegroundColor Yellow
    Write-Host "   Make sure your database has data" -ForegroundColor Yellow
} else {
    Write-Host "✅ Backup file size looks good" -ForegroundColor Green
}

if ($backups.Count -lt 3) {
    Write-Host "💡 Consider keeping multiple backups for safety" -ForegroundColor Cyan
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "To create a new backup, run: .\backup-database.ps1" -ForegroundColor Cyan
Write-Host "To restore a backup, run: .\restore-database.ps1" -ForegroundColor Cyan
Write-Host ""

Read-Host "Press Enter to exit"
