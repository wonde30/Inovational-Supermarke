<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('qr_code')->unique()->nullable()->after('sku');
            $table->string('barcode')->nullable()->after('qr_code');
            $table->integer('scan_count')->default(0)->after('barcode');
            $table->timestamp('last_scanned_at')->nullable()->after('scan_count');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'barcode', 'scan_count', 'last_scanned_at']);
        });
    }
};
