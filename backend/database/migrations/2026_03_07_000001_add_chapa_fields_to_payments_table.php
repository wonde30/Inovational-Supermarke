<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add gateway column to specify payment gateway (e.g., 'chapa')
            $table->string('gateway')->default('chapa')->after('user_id');
            
            // Add currency column for multi-currency support
            $table->string('currency', 3)->default('ETB')->after('amount');
            
            // Add checkout URL for Chapa payment page
            $table->text('checkout_url')->nullable()->after('transaction_id');
            
            // Add webhook data to store complete webhook payload
            $table->json('webhook_data')->nullable()->after('gateway_response');
            
            // Add verified_at timestamp for payment verification
            $table->timestamp('verified_at')->nullable()->after('processed_at');
            
            // Add expires_at timestamp for payment expiration (30 minutes)
            $table->timestamp('expires_at')->nullable()->after('verified_at');
            
            // Update status enum to include 'expired' status
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'expired'])
                ->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn([
                'gateway',
                'currency',
                'checkout_url',
                'webhook_data',
                'verified_at',
                'expires_at',
            ]);
            
            // Revert status enum to original values
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])
                ->default('pending')
                ->change();
        });
    }
};
