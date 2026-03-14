<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Services\QRCodeService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QRScanController extends Controller
{
    use ApiResponse;

    protected QRCodeService $qrCodeService;

    public function __construct(QRCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Scan QR code and retrieve product
     */
    public function scan(string $qrCode): JsonResponse
    {
        $startTime = microtime(true);

        try {
            $product = $this->qrCodeService->scanAndRetrieve($qrCode);

            if (!$product) {
                return $this->error('Invalid QR code or product not found', 404);
            }

            if (!$product->active) {
                return $this->error('This product is no longer available', 410);
            }

            $duration = microtime(true) - $startTime;

            return $this->success([
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => round($product->price, 2),
                    'image' => $product->image,
                    'category' => $product->category->name ?? null,
                    'stock_quantity' => $product->quantity,
                    'in_stock' => $product->quantity > 0,
                    'sku' => $product->sku,
                    'qr_code' => $product->qr_code,
                ],
                'scan_time' => round($duration * 1000, 2) . 'ms',
            ], 'Product scanned successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to scan QR code: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Validate QR code without retrieving product
     */
    public function validate(string $qrCode): JsonResponse
    {
        $isValid = $this->qrCodeService->verify($qrCode);

        return $this->success([
            'valid' => $isValid,
            'qr_code' => $qrCode,
        ]);
    }
}
