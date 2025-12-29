<?php

namespace App\Services\Vendor;

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
        $imagePath = str_replace('storage/', '', $imageUrl);

        return Storage::disk('public')->delete($imagePath);
    }
}
