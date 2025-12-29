<?php

namespace App\Repositories\Admin\Banner;

use App\Models\Banner;
use App\Models\BannerTranslation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class BannerRepository implements BannerRepositoryInterface
{
    // Get all banners with translations
    public function getAllBanners(): Collection
    {
        return Banner::with('translations')->orderBy('created_at', 'desc')->get();
    }

    // Get a banner by its ID
    public function getBannerById(int $id): Banner
    {
        return Banner::findOrFail($id);
    }

    // Create a new banner
    public function createBanner(array $data): Banner
    {
        return Banner::create([
            'type' => $data['type'],
        ]);
    }

    // Update the banner
    public function updateBanner(Banner $banner, array $data): Banner
    {
        $banner->type = $data['type'];
        $banner->save();

        return $banner;
    }

    // Delete a banner
    public function deleteBanner(Banner $banner): bool
    {
        // Delete associated images if they exist
        $translations = BannerTranslation::where('banner_id', $banner->id)->get();
        foreach ($translations as $translation) {
            if ($translation->image_url && Storage::exists($translation->image_url)) {
                Storage::delete($translation->image_url);
            }
        }

        // Delete translations
        BannerTranslation::where('banner_id', $banner->id)->delete();

        // Delete the banner
        return $banner->delete();
    }
}
