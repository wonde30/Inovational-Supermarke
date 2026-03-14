<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MigrateStorekeeperUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:migrate-storekeeper 
                            {--dry-run : Show what would be changed without making changes}
                            {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate users with storekeeper role to manager role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        // Find all storekeeper users
        $storekeepers = User::where('role', 'storekeeper')->get();

        if ($storekeepers->isEmpty()) {
            $this->info('✅ No storekeeper users found. Migration not needed.');
            return 0;
        }

        $this->info("Found {$storekeepers->count()} storekeeper user(s):");
        
        // Display users that will be affected
        $this->table(
            ['ID', 'Name', 'Email', 'Current Role', 'New Role'],
            $storekeepers->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    'manager'
                ];
            })
        );

        if ($dryRun) {
            $this->warn('🔍 DRY RUN: No changes were made. Remove --dry-run to execute migration.');
            return 0;
        }

        // Confirm before proceeding
        if (!$force && !$this->confirm('Do you want to migrate these users from storekeeper to manager role?')) {
            $this->info('Migration cancelled.');
            return 0;
        }

        // Perform the migration
        $updated = User::where('role', 'storekeeper')->update(['role' => 'manager']);

        $this->info("✅ Successfully migrated {$updated} user(s) from storekeeper to manager role.");
        
        // Verify the migration
        $remainingStorekeepers = User::where('role', 'storekeeper')->count();
        if ($remainingStorekeepers === 0) {
            $this->info('✅ Migration completed successfully. No storekeeper users remain.');
        } else {
            $this->error("⚠️  Warning: {$remainingStorekeepers} storekeeper user(s) still exist.");
        }

        return 0;
    }
}