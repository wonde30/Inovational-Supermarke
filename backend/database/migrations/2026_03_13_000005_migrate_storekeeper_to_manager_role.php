<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all users with 'storekeeper' role to 'manager' role
        DB::table('users')
            ->where('role', 'storekeeper')
            ->update(['role' => 'manager']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse migration: change manager back to storekeeper
        // Note: This will change ALL managers to storekeeper, which may not be desired
        // Only use this if you're sure about the rollback
        DB::table('users')
            ->where('role', 'manager')
            ->update(['role' => 'storekeeper']);
    }
};