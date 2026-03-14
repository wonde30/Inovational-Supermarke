<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Link Orders to Sales
     * 
     * Real-World Flow:
     * - Customer places ORDER (online) → pending
     * - Staff processes ORDER → processing
     * - ORDER completed → Creates SALE record → sale_id linked
     * 
     * This creates the relationship between:
     * - Orders (customer-facing requests)
     * - Sales (business/accounting records)
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('sale_id')->nullable()->after('status')->constrained('sales')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropColumn('sale_id');
        });
    }
};
