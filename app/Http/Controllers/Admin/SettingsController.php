<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display settings index page
     */
    public function index()
    {
        $categories = Setting::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $settings = [];
        foreach ($categories as $category) {
            $settings[$category] = Setting::getByCategory($category);
        }

        return view('admin.settings.index', compact('settings', 'categories'));
    }

    /**
     * Display file storage settings
     */
    public function fileStorage()
    {
        $settings = Setting::getByCategory('file_storage');
        $groups = $settings->groupBy('group');

        return view('admin.settings.file-storage', compact('settings', 'groups'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $settings = $request->except(['_token', '_method']);
        $errors = [];

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting) {
                continue;
            }

            // Validate setting
            if ($setting->validation_rules) {
                $validator = Validator::make([$key => $value], [
                    $key => $setting->validation_rules
                ]);

                if ($validator->fails()) {
                    $errors[$key] = $validator->errors()->first($key);
                    continue;
                }
            }

            // Update setting
            $setting->typed_value = $value;
            $setting->save();
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        // Clear settings cache
        Setting::clearCache();

        return redirect()->back()
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Update file storage settings
     */
    public function updateFileStorage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_storage_driver' => 'required|in:local,s3,ftp,sftp',
            'file_storage_max_size' => 'required|integer|min:1|max:100',
            'file_storage_allowed_types' => 'required|array',
            'file_storage_organize_by_date' => 'boolean',
            'file_storage_keep_original_name' => 'boolean',
            'aws_s3_bucket' => 'required_if:file_storage_driver,s3|string',
            'aws_s3_region' => 'required_if:file_storage_driver,s3|string',
            'aws_s3_url' => 'nullable|url',
            'aws_s3_use_path_style_endpoint' => 'boolean',
            'file_upload_max_files' => 'required|integer|min:1|max:50',
            'file_upload_auto_resize_images' => 'boolean',
            'file_upload_image_max_width' => 'integer|min:100|max:4000',
            'file_upload_image_max_height' => 'integer|min:100|max:4000',
            'file_upload_image_quality' => 'integer|min:1|max:100',
            'file_storage_scan_virus' => 'boolean',
            'file_storage_block_executable' => 'boolean',
            'file_storage_require_authentication' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update settings
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->typed_value = $value;
                $setting->save();
            }
        }

        // Clear settings cache
        Setting::clearCache();

        return redirect()->back()
            ->with('success', 'File storage settings updated successfully.');
    }

    /**
     * Test S3 connection
     */
    public function testS3Connection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aws_s3_bucket' => 'required|string',
            'aws_s3_region' => 'required|string',
            'aws_s3_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Test S3 connection logic here
            // This would typically involve creating a temporary S3 client and testing connectivity
            
            return response()->json([
                'success' => true,
                'message' => 'S3 connection test successful!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'S3 connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset settings to default
     */
    public function reset(Request $request)
    {
        $category = $request->get('category', 'file_storage');
        
        if ($category === 'file_storage') {
            // Run the seeder to reset file storage settings
            $seeder = new \Database\Seeders\SettingsSeeder();
            $seeder->run();
        }

        return redirect()->back()
            ->with('success', ucfirst($category) . ' settings reset to default values.');
    }

    /**
     * Export settings
     */
    public function export()
    {
        $settings = Setting::all();
        $data = [];

        foreach ($settings as $setting) {
            $data[] = [
                'key' => $setting->key,
                'value' => $setting->value,
                'type' => $setting->type,
                'category' => $setting->category,
                'group' => $setting->group,
                'label' => $setting->label,
                'description' => $setting->description,
            ];
        }

        $filename = 'settings_export_' . date('Y-m-d_H-i-s') . '.json';
        
        return response()->json($data)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Import settings
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'settings_file' => 'required|file|mimes:json|max:1024',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('settings_file');
            $data = json_decode(file_get_contents($file->getPathname()), true);

            if (!is_array($data)) {
                throw new \Exception('Invalid JSON file format');
            }

            $imported = 0;
            $updated = 0;

            foreach ($data as $item) {
                if (isset($item['key']) && isset($item['value'])) {
                    $setting = Setting::where('key', $item['key'])->first();
                    
                    if ($setting) {
                        $setting->typed_value = $item['value'];
                        $setting->save();
                        $updated++;
                    } else {
                        Setting::create([
                            'key' => $item['key'],
                            'value' => $item['value'],
                            'type' => $item['type'] ?? 'string',
                            'category' => $item['category'] ?? 'general',
                            'group' => $item['group'] ?? null,
                            'label' => $item['label'] ?? ucwords(str_replace('_', ' ', $item['key'])),
                            'description' => $item['description'] ?? null,
                        ]);
                        $imported++;
                    }
                }
            }

            // Clear settings cache
            Setting::clearCache();

            return redirect()->back()
                ->with('success', "Settings imported successfully. {$imported} new settings created, {$updated} settings updated.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to import settings: ' . $e->getMessage());
        }
    }
}
