<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Upload an image file, convert to WebP format if supported, and return public relative path.
     */
    public static function uploadImage(UploadedFile $file, string $folder = 'uploads', int $quality = 85): string
    {
        $filename = Str::random(20) . '.webp';
        $path = "{$folder}/{$filename}";

        // Attempt WebP conversion using GD if available
        if (function_exists('imagecreatefromstring') && function_exists('imagewebp')) {
            try {
                $image = @imagecreatefromstring(file_get_contents($file->getRealPath()));
                if ($image !== false) {
                    ob_start();
                    imagewebp($image, null, $quality);
                    $webpData = ob_get_clean();
                    imagedestroy($image);

                    Storage::disk('public')->put($path, $webpData);
                    return 'storage/' . $path;
                }
            } catch (\Exception $e) {
                \Log::warning('WebP conversion fallback triggered: ' . $e->getMessage());
            }
        }

        // Standard upload fallback
        $storedPath = $file->storeAs($folder, Str::random(20) . '.' . $file->getClientOriginalExtension(), 'public');
        return 'storage/' . $storedPath;
    }

    /**
     * Delete an existing media file from storage disk safely.
     */
    public static function deleteFile(?string $relativePath): bool
    {
        if (empty($relativePath)) {
            return false;
        }

        $path = str_replace('storage/', '', $relativePath);
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
