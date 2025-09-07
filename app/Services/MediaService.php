<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService
{
    /**
     * Get the configured storage disk
     */
    public function getStorageDisk(): string
    {
        return setting('storage_driver', 'local');
    }

    /**
     * Upload product image
     */
    public function uploadProductImage(UploadedFile $file, Product $product): string
    {
        $disk = $this->getStorageDisk();
        
        if ($disk === 's3') {
            return $this->uploadToS3($file, $product);
        }
        
        return $this->uploadToLocal($file, $product);
    }

    /**
     * Upload to S3
     */
    private function uploadToS3(UploadedFile $file, Product $product): string
    {
        $path = "products/{$product->id}/" . Str::uuid() . '.' . $file->extension();
        
        Storage::disk('s3')->put($path, file_get_contents($file), 'public');
        
        return Storage::disk('s3')->url($path);
    }

    /**
     * Upload to local storage
     */
    private function uploadToLocal(UploadedFile $file, Product $product): string
    {
        $path = $file->store("products/{$product->id}", 'public');
        
        return Storage::disk('public')->url($path);
    }

    /**
     * Attach multiple images to a product using Spatie Media Library
     */
    public function attachImages(Product $product, array $images): array
    {
        $uploadedImages = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $media = $product->addMediaFromRequest('image')
                    ->usingFileName(Str::uuid() . '.' . $image->extension())
                    ->toMediaCollection('images');
                
                $uploadedImages[] = $media;
            }
        }

        return $uploadedImages;
    }

    /**
     * Update product images
     */
    public function updateImages(Product $product, array $images): array
    {
        // Clear existing images
        $product->clearMediaCollection('images');
        
        // Add new images
        return $this->attachImages($product, $images);
    }

    /**
     * Generate responsive image conversions
     */
    public function generateImageConversions(Media $media): void
    {
        $media->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->quality(90)
            ->performOnCollections('images');

        $media->addMediaConversion('medium')
            ->width(600)
            ->height(600)
            ->quality(85)
            ->performOnCollections('images');

        $media->addMediaConversion('large')
            ->width(1200)
            ->height(1200)
            ->quality(80)
            ->performOnCollections('images');
    }

    /**
     * Get image URL with conversion
     */
    public function getImageUrl(Product $product, string $conversion = ''): ?string
    {
        $media = $product->getFirstMedia('images');
        
        if (!$media) {
            return null;
        }

        return $conversion 
            ? $media->getUrl($conversion)
            : $media->getUrl();
    }

    /**
     * Get all product images with conversions
     */
    public function getProductImages(Product $product): array
    {
        $images = [];
        
        foreach ($product->getMedia('images') as $media) {
            $images[] = [
                'id' => $media->id,
                'original' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
                'medium' => $media->getUrl('medium'),
                'large' => $media->getUrl('large'),
                'alt' => $media->getCustomProperty('alt', $product->name),
                'caption' => $media->getCustomProperty('caption', ''),
            ];
        }

        return $images;
    }

    /**
     * Delete product image
     */
    public function deleteImage(Product $product, int $mediaId): bool
    {
        $media = $product->getMedia('images')->find($mediaId);
        
        if ($media) {
            $media->delete();
            return true;
        }

        return false;
    }

    /**
     * Set image as featured
     */
    public function setFeaturedImage(Product $product, int $mediaId): bool
    {
        // Clear existing featured flag
        $product->getMedia('images')->each(function ($media) {
            $media->setCustomProperty('featured', false);
            $media->save();
        });

        // Set new featured image
        $media = $product->getMedia('images')->find($mediaId);
        if ($media) {
            $media->setCustomProperty('featured', true);
            $media->save();
            return true;
        }

        return false;
    }

    /**
     * Get featured image
     */
    public function getFeaturedImage(Product $product): ?Media
    {
        return $product->getMedia('images')
            ->filter(function ($media) {
                return $media->getCustomProperty('featured', false);
            })
            ->first() ?? $product->getFirstMedia('images');
    }

    /**
     * Optimize image before upload
     */
    public function optimizeImage(UploadedFile $file): UploadedFile
    {
        // Basic validation
        $this->validateImage($file);
        
        // You can add image optimization logic here
        // Using packages like Intervention Image or Spatie Image Optimizer
        
        return $file;
    }

    /**
     * Validate uploaded image
     */
    private function validateImage(UploadedFile $file): void
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file->getMimeType(), $allowedTypes)) {
            throw new \InvalidArgumentException('Invalid image type. Only JPEG, PNG, and WebP are allowed.');
        }

        if ($file->getSize() > $maxSize) {
            throw new \InvalidArgumentException('Image size too large. Maximum 5MB allowed.');
        }
    }

    /**
     * Generate image alt text
     */
    public function generateAltText(Product $product, int $index = 0): string
    {
        $baseText = $product->name;
        
        if ($index > 0) {
            $baseText .= " - Image " . ($index + 1);
        }
        
        // Add relevant product attributes
        if ($product->metal_type && $product->purity) {
            $baseText .= " - {$product->purity} {$product->metal_type}";
        }
        
        return $baseText;
    }
}
