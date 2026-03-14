<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Advanced IBMS Features Migration
     * - Batch/Expiry tracking for pharmacies
     * - Audit logs for fraud prevention
     * - Soft deletes for data protection
     * - Enhanced product tracking
     */
    public function up(): void
    {
        // Add advanced fields to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('batch_number')->nullable()->after('image');
            $table->date('expiry_date')->nullable()->after('batch_number');
            $table->date('manufacture_date')->nullable()->after('expiry_date');
            $table->enum('movement_type', ['fast', 'medium', 'slow'])->default('medium')->after('manufacture_date');
            $table->integer('lead_time_days')->default(7)->after('movement_type'); // Supplier lead time
            $table->softDeletes(); // Soft delete for data protection
        });

        // Add soft deletes to sales
        Schema::table('sales', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('status');
            $table->string('customer_name')->nullable()->after('notes');
            $table->softDeletes();
        });

        // Create audit_logs table for fraud prevention
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // create, update, delete, login, logout, etc.
            $table->string('model_type'); // Product, Sale, User, etc.
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['model_type', 'model_id']);
            $table->index('action');
        });

        // Create stock_alerts table for low stock notifications
        Schema::create('stock_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('alert_type', ['low_stock', 'out_of_stock', 'expiring_soon', 'expired']);
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // Create daily_summaries table for reporting
        Schema::create('daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->date('summary_date')->unique();
            $table->decimal('total_sales', 14, 2)->default(0);
            $table->integer('transaction_count')->default(0);
            $table->decimal('total_cost', 14, 2)->default(0);
            $table->decimal('gross_profit', 14, 2)->default(0);
            $table->decimal('cash_sales', 14, 2)->default(0);
            $table->decimal('credit_sales', 14, 2)->default(0);
            $table->integer('products_sold')->default(0);
            $table->json('top_products')->nullable();
            $table->json('cashier_performance')->nullable();
            $table->timestamps();
        });

        // Add phone to users for SMS alerts
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->boolean('sms_alerts')->default(false)->after('phone');
        });

        // Add category-based reorder settings
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('default_reorder_level')->default(10)->after('description');
            $table->integer('default_lead_time')->default(7)->after('default_reorder_level');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['batch_number', 'expiry_date', 'manufacture_date', 'movement_type', 'lead_time_days', 'deleted_at']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['notes', 'customer_name', 'deleted_at']);
        });

        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('stock_alerts');
        Schema::dropIfExists('daily_summaries');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'sms_alerts']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['default_reorder_level', 'default_lead_time']);
        });
    }
};
