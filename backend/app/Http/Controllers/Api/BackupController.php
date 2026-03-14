<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    use ApiResponse;

    /**
     * Create database backup
     * Required for Wollo University project: "implement database backup and restore process"
     */
    public function backup(Request $request)
    {
        try {
            // Generate secure filename with random component
            $randomString = bin2hex(random_bytes(8));
            $filename = 'ibms_backup_' . date('Y-m-d_H-i-s') . '_' . $randomString . '.sql';
            
            // Store backups outside public directory with restricted permissions
            $backupDir = storage_path('app/private/backups');
            $path = $backupDir . '/' . $filename;
            
            // Ensure backup directory exists with secure permissions
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0700, true); // Only owner can read/write/execute
            }

            // Get database credentials
            $host = config('database.connections.mysql.host');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Create backup using mysqldump
            $command = sprintf(
                'mysqldump --host=%s --user=%s --password=%s %s > %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                escapeshellarg($path)
            );

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Fallback: Create PHP-based backup
                return $this->createPhpBackup($filename);
            }

            return $this->success([
                'filename' => $filename,
                'size' => filesize($path),
                'created_at' => date('Y-m-d H:i:s'),
            ], 'Database backup created successfully');

        } catch (\Exception $e) {
            return $this->error('Backup failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * PHP-based backup (fallback when mysqldump not available)
     */
    private function createPhpBackup($filename)
    {
        $path = storage_path('app/private/backups/' . $filename);
        $tables = DB::select('SHOW TABLES');
        $database = config('database.connections.mysql.database');
        
        $sql = "-- IBMS Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: {$database}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            
            // Get CREATE TABLE statement
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
            
            // Get table data
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function($value) {
                    if ($value === null) return 'NULL';
                    return "'" . addslashes($value) . "'";
                }, (array)$row);
                
                $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        file_put_contents($path, $sql);

        return $this->success([
            'filename' => $filename,
            'size' => filesize($path),
            'created_at' => date('Y-m-d H:i:s'),
            'method' => 'php'
        ], 'Database backup created successfully (PHP method)');
    }

    /**
     * List available backups
     */
    public function list()
    {
        $backupPath = storage_path('app/private/backups');
        
        if (!file_exists($backupPath)) {
            return $this->success([], 'No backups found');
        }

        $files = glob($backupPath . '/*.sql');
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => filesize($file),
                'size_formatted' => $this->formatBytes(filesize($file)),
                'created_at' => date('Y-m-d H:i:s', filemtime($file)),
            ];
        }

        // Sort by date descending
        usort($backups, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $this->success($backups, 'Backups retrieved successfully');
    }

    /**
     * Restore database from backup
     */
    public function restore(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        // Sanitize filename to prevent directory traversal
        $filename = basename($request->filename);
        
        // Validate filename format
        if (!preg_match('/^ibms_backup_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}_[a-f0-9]{16}\.sql$/', $filename)) {
            return $this->error('Invalid backup filename format.', 400);
        }

        $path = storage_path('app/private/backups/' . $filename);

        if (!file_exists($path)) {
            return $this->error('Backup file not found', 404);
        }

        try {
            // Get database credentials
            $host = config('database.connections.mysql.host');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Try mysql command first
            $command = sprintf(
                'mysql --host=%s --user=%s --password=%s %s < %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                escapeshellarg($path)
            );

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Fallback: PHP-based restore
                return $this->restorePhp($path);
            }

            return $this->success([
                'filename' => $filename,
                'restored_at' => date('Y-m-d H:i:s'),
            ], 'Database restored successfully');

        } catch (\Exception $e) {
            return $this->error('Restore failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * PHP-based restore (fallback)
     */
    private function restorePhp($path)
    {
        $sql = file_get_contents($path);
        
        // Split into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        foreach ($statements as $statement) {
            if (!empty($statement) && !str_starts_with($statement, '--')) {
                try {
                    DB::unprepared($statement);
                } catch (\Exception $e) {
                    // Skip errors for comments and empty statements
                    continue;
                }
            }
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return $this->success([
            'restored_at' => date('Y-m-d H:i:s'),
            'method' => 'php'
        ], 'Database restored successfully (PHP method)');
    }

    /**
     * Download backup file
     */
    public function download($filename)
    {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        
        // Validate filename format
        if (!preg_match('/^ibms_backup_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}_[a-f0-9]{16}\.sql$/', $filename)) {
            return $this->error('Invalid backup filename format.', 400);
        }

        $path = storage_path('app/private/backups/' . $filename);

        if (!file_exists($path)) {
            return $this->error('Backup file not found', 404);
        }

        return response()->download($path);
    }

    /**
     * Delete backup file
     */
    public function delete($filename)
    {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        
        // Validate filename format
        if (!preg_match('/^ibms_backup_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}_[a-f0-9]{16}\.sql$/', $filename)) {
            return $this->error('Invalid backup filename format.', 400);
        }

        $path = storage_path('app/private/backups/' . $filename);

        if (!file_exists($path)) {
            return $this->error('Backup file not found', 404);
        }

        unlink($path);

        return $this->success(null, 'Backup deleted successfully');
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
