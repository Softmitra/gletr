<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:cleanup {--days=14 : Number of days to keep logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up log files older than specified days (default: 14 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $logPath = storage_path('logs');
        
        if (!File::exists($logPath)) {
            $this->error("Log directory does not exist: {$logPath}");
            return 1;
        }

        $cutoffDate = Carbon::now()->subDays($days);
        $deletedFiles = [];
        $totalSize = 0;

        $this->info("Cleaning up log files older than {$days} days (before {$cutoffDate->format('Y-m-d')})...");

        // Get all log files
        $logFiles = File::glob($logPath . '/*.log*');
        
        foreach ($logFiles as $file) {
            $fileTime = Carbon::createFromTimestamp(File::lastModified($file));
            
            // Skip if file is newer than cutoff date
            if ($fileTime->gt($cutoffDate)) {
                continue;
            }
            
            // Skip current day's log file
            $filename = basename($file);
            $today = Carbon::now()->format('Y-m-d');
            if (str_contains($filename, $today)) {
                continue;
            }
            
            // Calculate file size before deletion
            $fileSize = File::size($file);
            $totalSize += $fileSize;
            
            // Delete the file
            if (File::delete($file)) {
                $deletedFiles[] = [
                    'name' => $filename,
                    'size' => $this->formatBytes($fileSize),
                    'date' => $fileTime->format('Y-m-d H:i:s')
                ];
                
                $this->line("Deleted: {$filename} ({$this->formatBytes($fileSize)}) - {$fileTime->format('Y-m-d')}");
            } else {
                $this->error("Failed to delete: {$filename}");
            }
        }

        // Summary
        $deletedCount = count($deletedFiles);
        $totalSizeFormatted = $this->formatBytes($totalSize);
        
        if ($deletedCount > 0) {
            $this->info("\n✅ Cleanup completed!");
            $this->info("📁 Deleted {$deletedCount} log file(s)");
            $this->info("💾 Freed up {$totalSizeFormatted} of disk space");
            
            // Log the cleanup activity
            Log::info("Log cleanup completed", [
                'deleted_files' => $deletedCount,
                'total_size_freed' => $totalSizeFormatted,
                'cutoff_date' => $cutoffDate->format('Y-m-d'),
                'files' => array_column($deletedFiles, 'name')
            ]);
        } else {
            $this->info("✨ No old log files found to clean up.");
        }

        return 0;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
