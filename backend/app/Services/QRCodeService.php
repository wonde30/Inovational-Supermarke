<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class QRCodeService
{
    /**
     * Generate a unique QR code for a product
     */
    public function generateForProduct(Product $product): string
    {
        // Generate a unique QR code using product ID and random string
        $qrCode = 'SM-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(6));
        
        // Add signature for security
        $signature = $this->generateSignature($product->id);
        
        return $qrCode . '-' . $signature;
    }

    /**
     * Verify QR code signature
     */
    public function verify(string $qrCode): bool
    {
        $parts = explode('-', $qrCode);
        
        if (count($parts) < 4) {
            return false;
        }

        $productId = (int) $parts[1];
        $signature = end($parts);
        
        return hash_equals($this->generateSignature($productId), $signature);
    }

    /**
     * Extract product ID from QR code
     */
    public function extractProductId(string $qrCode): ?int
    {
        $parts = explode('-', $qrCode);
        
        if (count($parts) < 2) {
            return null;
        }

        return (int) $parts[1];
    }

    /**
     * Generate signature for security
     */
    private function generateSignature(int $productId): string
    {
        return substr(hash_hmac('sha256', (string) $productId, config('app.key')), 0, 6);
    }

    /**
     * Scan QR code and retrieve product
     */
    public function scanAndRetrieve(string $qrCode): ?Product
    {
        // Verify QR code
        if (!$this->verify($qrCode)) {
            return null;
        }

        // Extract product ID
        $productId = $this->extractProductId($qrCode);
        
        if (!$productId) {
            return null;
        }

        // Find product
        $product = Product::with('category')->find($productId);
        
        if ($product) {
            // Update scan statistics
            $product->increment('scan_count');
            $product->update(['last_scanned_at' => now()]);
        }

        return $product;
    }

    /**
     * Generate QR codes for all products without one
     */
    public function generateForAllProducts(): int
    {
        $products = Product::whereNull('qr_code')->get();
        $count = 0;

        foreach ($products as $product) {
            $qrCode = $this->generateForProduct($product);
            $product->update(['qr_code' => $qrCode]);
            $count++;
        }

        return $count;
    }
}
