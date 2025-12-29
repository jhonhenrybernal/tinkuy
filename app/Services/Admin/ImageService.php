<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload the image and return the file path.
     */
    public function uploadImage(UploadedFile $image, string $folder): string
    {
        $imagePath = $image->store($folder, 'public');

        return $imagePath;
    }

    public function deleteImage(string $imageUrl): bool
    {
        // Strip out 'storage/' from the image URL, if present
        $imagePath = str_replace('storage/', '', $imageUrl);

        // Delete the image from public disk
        return Storage::disk('public')->delete($imagePath);
    }
}
