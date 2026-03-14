<?php

namespace App\Console\Commands;

use App\Services\QRCodeService;
use Illuminate\Console\Command;

class GenerateQRCodes extends Command
{
    protected $signature = 'qr:generate {--force : Regenerate QR codes for all products}';
    protected $description = 'Generate QR codes for products';

    public function handle(QRCodeService $qrCodeService): int
    {
        $this->info('Generating QR codes for products...');

        $count = $qrCodeService->generateForAllProducts();

        $this->info("✅ Generated {$count} QR codes successfully!");

        return Command::SUCCESS;
    }
}
