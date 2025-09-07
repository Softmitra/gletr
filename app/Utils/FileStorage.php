<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class FileStorage
{
    /**
     * Allowed file types and their configurations
     */
    const ALLOWED_TYPES = [
        'image' => [
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
            'max_size' => 2048, // 2MB
            'mime_types' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
        ],
        'document' => [
            'extensions' => ['pdf', 'doc', 'docx', 'txt', 'rtf'],
            'max_size' => 5120, // 5MB
            'mime_types' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain', 'application/rtf'],
        ],
        'spreadsheet' => [
            'extensions' => ['xls', 'xlsx', 'csv'],
            'max_size' => 5120, // 5MB
            'mime_types' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'],
        ],
        'archive' => [
            'extensions' => ['zip', 'rar', '7z', 'tar', 'gz'],
            'max_size' => 10240, // 10MB
            'mime_types' => ['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar', 'application/gzip'],
        ],
        'video' => [
            'extensions' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'],
            'max_size' => 51200, // 50MB
            'mime_types' => ['video/mp4', 'video/x-msvideo', 'video/quicktime', 'video/x-ms-wmv', 'video/x-flv', 'video/webm'],
        ],
        'audio' => [
            'extensions' => ['mp3', 'wav', 'ogg', 'aac', 'flac'],
            'max_size' => 10240, // 10MB
            'mime_types' => ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/aac', 'audio/flac'],
        ],
    ];

    /**
     * Default storage disk
     */
    protected $disk;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->disk = config('filesystems.default', 'local');
    }

    /**
     * Store a file
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $type
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function store(UploadedFile $file, string $directory = 'uploads', string $type = 'document', array $options = [])
    {
        try {
            // Validate file
            $this->validateFile($file, $type);

            // Generate unique filename
            $filename = $this->generateFilename($file, $options);

            // Determine storage path
            $path = $this->buildPath($directory, $filename);

            // Store file
            $storedPath = Storage::disk($this->disk)->putFileAs(
                dirname($path),
                $file,
                basename($path)
            );

            if (!$storedPath) {
                throw new Exception('Failed to store file');
            }

            // Get file URL
            $url = $this->getUrl($storedPath);

            // Return file information
            return [
                'success' => true,
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $storedPath,
                'url' => $url,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'disk' => $this->disk,
                'type' => $type,
            ];

        } catch (Exception $e) {
            Log::error('File storage error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'type' => $type,
                'directory' => $directory,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Store multiple files
     *
     * @param array $files
     * @param string $directory
     * @param string $type
     * @param array $options
     * @return array
     */
    public function storeMultiple(array $files, string $directory = 'uploads', string $type = 'document', array $options = [])
    {
        $results = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $results[] = $this->store($file, $directory, $type, $options);
            }
        }

        return $results;
    }

    /**
     * Delete a file
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        try {
            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->delete($path);
            }
            return true;
        } catch (Exception $e) {
            Log::error('File deletion error: ' . $e->getMessage(), ['path' => $path]);
            return false;
        }
    }

    /**
     * Delete multiple files
     *
     * @param array $paths
     * @return array
     */
    public function deleteMultiple(array $paths): array
    {
        $results = [];

        foreach ($paths as $path) {
            $results[$path] = $this->delete($path);
        }

        return $results;
    }

    /**
     * Get file URL
     *
     * @param string $path
     * @return string
     */
    public function getUrl(string $path): string
    {
        if ($this->disk === 's3') {
            return Storage::disk($this->disk)->url($path);
        }

        return asset('storage/' . $path);
    }

    /**
     * Check if file exists
     *
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Get file size
     *
     * @param string $path
     * @return int
     */
    public function getSize(string $path): int
    {
        return Storage::disk($this->disk)->size($path);
    }

    /**
     * Get file mime type
     *
     * @param string $path
     * @return string
     */
    public function getMimeType(string $path): string
    {
        return Storage::disk($this->disk)->mimeType($path);
    }

    /**
     * Copy file to another location
     *
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function copy(string $from, string $to): bool
    {
        try {
            return Storage::disk($this->disk)->copy($from, $to);
        } catch (Exception $e) {
            Log::error('File copy error: ' . $e->getMessage(), ['from' => $from, 'to' => $to]);
            return false;
        }
    }

    /**
     * Move file to another location
     *
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function move(string $from, string $to): bool
    {
        try {
            return Storage::disk($this->disk)->move($from, $to);
        } catch (Exception $e) {
            Log::error('File move error: ' . $e->getMessage(), ['from' => $from, 'to' => $to]);
            return false;
        }
    }

    /**
     * Validate file
     *
     * @param UploadedFile $file
     * @param string $type
     * @throws Exception
     */
    protected function validateFile(UploadedFile $file, string $type): void
    {
        if (!isset(self::ALLOWED_TYPES[$type])) {
            throw new Exception("Invalid file type: {$type}");
        }

        $config = self::ALLOWED_TYPES[$type];
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        // Check extension
        if (!in_array($extension, $config['extensions'])) {
            throw new Exception("File extension '{$extension}' is not allowed for type '{$type}'");
        }

        // Check mime type
        if (!in_array($mimeType, $config['mime_types'])) {
            throw new Exception("File mime type '{$mimeType}' is not allowed for type '{$type}'");
        }

        // Check file size (convert KB to bytes)
        $maxSize = $config['max_size'] * 1024;
        if ($size > $maxSize) {
            throw new Exception("File size exceeds maximum allowed size of " . $this->formatBytes($maxSize));
        }
    }

    /**
     * Generate unique filename
     *
     * @param UploadedFile $file
     * @param array $options
     * @return string
     */
    protected function generateFilename(UploadedFile $file, array $options = []): string
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Use custom prefix if provided
        $prefix = $options['prefix'] ?? '';
        
        // Use custom suffix if provided
        $suffix = $options['suffix'] ?? '';

        // Generate unique identifier
        $uniqueId = Str::random(16);

        // Build filename
        $filename = trim($prefix . '_' . $originalName . '_' . $uniqueId . $suffix, '_');
        
        // Sanitize filename
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
        
        return $filename . '.' . $extension;
    }

    /**
     * Build storage path
     *
     * @param string $directory
     * @param string $filename
     * @return string
     */
    protected function buildPath(string $directory, string $filename): string
    {
        $directory = trim($directory, '/');
        return $directory . '/' . $filename;
    }

    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get allowed file types
     *
     * @return array
     */
    public static function getAllowedTypes(): array
    {
        return self::ALLOWED_TYPES;
    }

    /**
     * Get allowed extensions for a type
     *
     * @param string $type
     * @return array
     */
    public static function getAllowedExtensions(string $type): array
    {
        return self::ALLOWED_TYPES[$type]['extensions'] ?? [];
    }

    /**
     * Get max file size for a type
     *
     * @param string $type
     * @return int
     */
    public static function getMaxFileSize(string $type): int
    {
        return self::ALLOWED_TYPES[$type]['max_size'] ?? 0;
    }

    /**
     * Check if file type is allowed
     *
     * @param string $extension
     * @param string $type
     * @return bool
     */
    public static function isAllowedExtension(string $extension, string $type): bool
    {
        return in_array(strtolower($extension), self::getAllowedExtensions($type));
    }

    /**
     * Set storage disk
     *
     * @param string $disk
     * @return self
     */
    public function setDisk(string $disk): self
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * Get current storage disk
     *
     * @return string
     */
    public function getDisk(): string
    {
        return $this->disk;
    }
}
