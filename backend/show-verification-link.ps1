# Show the latest email verification link from logs
Write-Host "=== Latest Email Verification Link ===" -ForegroundColor Green
Write-Host ""

$logContent = Get-Content "storage/logs/laravel.log" -Tail 200 | Out-String

# Extract verification URL
if ($logContent -match 'http://localhost:8000/api/v1/auth/verify-email/(\d+)/([a-f0-9]+)') {
    $verificationUrl = $matches[0]
    Write-Host "Verification Link Found:" -ForegroundColor Yellow
    Write-Host $verificationUrl -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Copy this link and paste it in your browser to verify your email!" -ForegroundColor Green
} else {
    Write-Host "No verification link found in recent logs." -ForegroundColor Red
    Write-Host "Please register first, then run this script again." -ForegroundColor Yellow
}

Write-Host ""
