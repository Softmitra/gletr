<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CustomLogViewerController extends Controller
{
    protected $logPath;

    public function __construct()
    {
        $this->logPath = storage_path('logs');
    }

    /**
     * Display the log viewer interface
     */
    public function index(Request $request)
    {
        $files = $this->getLogFiles();
        $selectedFile = $request->get('file', $this->getLatestLogFile());
        $logs = [];
        $stats = ['total' => 0, 'error' => 0, 'warning' => 0, 'info' => 0, 'debug' => 0];

        if ($selectedFile && File::exists($this->logPath . '/' . $selectedFile)) {
            $logs = $this->parseLogFile($selectedFile, $request);
            $stats = $this->getLogStats($selectedFile);
        }

        return view('admin.logs.index', compact('files', 'selectedFile', 'logs', 'stats'));
    }

    /**
     * Get all log files
     */
    protected function getLogFiles()
    {
        $files = [];
        
        if (File::exists($this->logPath)) {
            $logFiles = File::files($this->logPath);
            
            foreach ($logFiles as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'log') {
                    $filename = $file->getFilename();
                    $files[] = [
                        'name' => $filename,
                        'size' => $this->formatBytes($file->getSize()),
                        'modified' => Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s'),
                        'path' => $file->getPathname()
                    ];
                }
            }
        }

        // Sort by modification time (newest first)
        usort($files, function($a, $b) {
            return strtotime($b['modified']) - strtotime($a['modified']);
        });

        return $files;
    }

    /**
     * Get the latest log file
     */
    protected function getLatestLogFile()
    {
        $files = $this->getLogFiles();
        return !empty($files) ? $files[0]['name'] : null;
    }

    /**
     * Parse log file and extract entries
     */
    protected function parseLogFile($filename, Request $request)
    {
        $filePath = $this->logPath . '/' . $filename;
        
        if (!File::exists($filePath)) {
            return [];
        }

        $content = File::get($filePath);
        $lines = explode("\n", $content);
        $logs = [];
        $currentLog = null;

        foreach ($lines as $line) {
            if (empty(trim($line))) continue;

            // Check if line starts with timestamp pattern
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $matches)) {
                // Save previous log entry
                if ($currentLog) {
                    $logs[] = $currentLog;
                }

                // Start new log entry
                $currentLog = $this->parseLogLine($line);
            } else {
                // Continuation of previous log entry
                if ($currentLog) {
                    $currentLog['message'] .= "\n" . $line;
                }
            }
        }

        // Add the last log entry
        if ($currentLog) {
            $logs[] = $currentLog;
        }

        // Apply filters
        $logs = $this->applyFilters($logs, $request);

        // Sort by timestamp (newest first)
        usort($logs, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        // Pagination
        $perPage = $request->get('per_page', 50);
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;

        return [
            'data' => array_slice($logs, $offset, $perPage),
            'total' => count($logs),
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil(count($logs) / $perPage)
        ];
    }

    /**
     * Parse individual log line
     */
    protected function parseLogLine($line)
    {
        $pattern = '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/';
        
        if (preg_match($pattern, $line, $matches)) {
            return [
                'timestamp' => $matches[1],
                'environment' => $matches[2],
                'level' => strtoupper($matches[3]),
                'message' => $matches[4],
                'formatted_time' => Carbon::parse($matches[1])->format('M d, Y H:i:s'),
                'level_class' => $this->getLevelClass($matches[3])
            ];
        }

        return [
            'timestamp' => date('Y-m-d H:i:s'),
            'environment' => 'local',
            'level' => 'INFO',
            'message' => $line,
            'formatted_time' => date('M d, Y H:i:s'),
            'level_class' => 'info'
        ];
    }

    /**
     * Get CSS class for log level
     */
    protected function getLevelClass($level)
    {
        $classes = [
            'emergency' => 'danger',
            'alert' => 'danger',
            'critical' => 'danger',
            'error' => 'danger',
            'warning' => 'warning',
            'notice' => 'info',
            'info' => 'info',
            'debug' => 'secondary'
        ];

        return $classes[strtolower($level)] ?? 'secondary';
    }

    /**
     * Apply filters to logs
     */
    protected function applyFilters($logs, Request $request)
    {
        $level = $request->get('level');
        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        if ($level && $level !== 'all') {
            $logs = array_filter($logs, function($log) use ($level) {
                return strtolower($log['level']) === strtolower($level);
            });
        }

        if ($search) {
            $logs = array_filter($logs, function($log) use ($search) {
                return stripos($log['message'], $search) !== false;
            });
        }

        if ($dateFrom) {
            $logs = array_filter($logs, function($log) use ($dateFrom) {
                return strtotime($log['timestamp']) >= strtotime($dateFrom);
            });
        }

        if ($dateTo) {
            $logs = array_filter($logs, function($log) use ($dateTo) {
                return strtotime($log['timestamp']) <= strtotime($dateTo . ' 23:59:59');
            });
        }

        return array_values($logs);
    }

    /**
     * Get log statistics
     */
    protected function getLogStats($filename)
    {
        $filePath = $this->logPath . '/' . $filename;
        
        if (!File::exists($filePath)) {
            return ['total' => 0, 'error' => 0, 'warning' => 0, 'info' => 0, 'debug' => 0];
        }

        $content = File::get($filePath);
        $stats = ['total' => 0, 'error' => 0, 'warning' => 0, 'info' => 0, 'debug' => 0];

        // Count occurrences of each log level
        $stats['error'] = substr_count(strtolower($content), '.error:');
        $stats['warning'] = substr_count(strtolower($content), '.warning:');
        $stats['info'] = substr_count(strtolower($content), '.info:');
        $stats['debug'] = substr_count(strtolower($content), '.debug:');
        $stats['total'] = $stats['error'] + $stats['warning'] + $stats['info'] + $stats['debug'];

        return $stats;
    }

    /**
     * Download log file
     */
    public function download(Request $request)
    {
        $filename = $request->get('file');
        $filePath = $this->logPath . '/' . $filename;

        if (!File::exists($filePath) || !$this->isValidLogFile($filename)) {
            abort(404, 'Log file not found');
        }

        return response()->download($filePath);
    }

    /**
     * Delete log file
     */
    public function delete(Request $request)
    {
        $filename = $request->get('file');
        $filePath = $this->logPath . '/' . $filename;

        if (!File::exists($filePath) || !$this->isValidLogFile($filename)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }

        File::delete($filePath);

        return response()->json(['message' => 'Log file deleted successfully']);
    }

    /**
     * Clear all logs
     */
    public function clear()
    {
        $files = File::files($this->logPath);
        $deleted = 0;

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'log') {
                File::delete($file);
                $deleted++;
            }
        }

        return response()->json(['message' => "Deleted {$deleted} log files"]);
    }

    /**
     * Validate log file
     */
    protected function isValidLogFile($filename)
    {
        return pathinfo($filename, PATHINFO_EXTENSION) === 'log' && 
               !str_contains($filename, '..') && 
               !str_contains($filename, '/');
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
