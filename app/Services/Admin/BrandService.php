<?php

namespace App\Services\Admin;

use App\Repositories\Admin\Brand\BrandRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands()
    {
        return $this->brandRepository->getAll();
    }

    public function store($data)
    {
        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                if (empty($data['slug'])) {
                    $data['slug'] = Str::slug($translation['name']);
                }
            }
        }

        if (isset($data['logo_url']) && $data['logo_url'] instanceof \Illuminate\Http\UploadedFile) {
            $logoPath = $data['logo_url']->store('brands/logos', 'public');
        } else {
            $logoPath = null;
        }

        $status = $data['status'] ?? 'active';

        $brandData = [
            'slug' => $data['slug'],
            'logo_url' => $logoPath,
            'status' => $status,
        ];

        $brand = $this->brandRepository->store($brandData);

        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                $brand->translations()->create([
                    'locale' => $locale,
                    'name' => $translation['name'],
                    'description' => $translation['description'] ?? null,
                ]);
            }
        }

        return $brand;
    }

    public function updateBrand($id, $data)
    {
        $brand = $this->brandRepository->find($id);

        if (isset($data['logo_url']) && $data['logo_url'] instanceof \Illuminate\Http\UploadedFile) {
            if ($brand->logo_url && Storage::exists('public/'.$brand->logo_url)) {
                Storage::delete('public/'.$brand->logo_url);
            }

            $logoPath = $data['logo_url']->store('brands/logos', 'public');
            $brand->logo_url = $logoPath;
        }

        if (empty($data['slug'])) {
            $brand->slug = Str::slug($data['translations']['en']['name'] ?? 'default'); // Default to 'default' if no name provided
        }

        $brand->status = $data['status'] ?? 'active';

        $brand->save();

        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                $brandTranslation = $brand->translations()->where('locale', $locale)->first();

                if ($brandTranslation) {
                    $brandTranslation->update([
                        'name' => $translation['name'],
                        'description' => $translation['description'] ?? null,
                    ]);
                } else {
                    $brand->translations()->create([
                        'locale' => $locale,
                        'name' => $translation['name'],
                        'description' => $translation['description'] ?? null,
                    ]);
                }
            }
        }

        return $brand;
    }

    public function deleteBrand($id)
    {
        $brand = $this->brandRepository->find($id);

        if ($brand->logo_url && Storage::exists('public/'.$brand->logo_url)) {
            Storage::delete('public/'.$brand->logo_url);
        }

        $brand->translations()->delete();

        return $brand->delete();
    }

    public function getBrandById($id)
    {
        return $this->brandRepository->find($id);
    }

    public function createBrand(array $data)
    {
        return $this->brandRepository->create($data);
    }
}
