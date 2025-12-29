<?php

namespace App\Repositories\Admin\Brand;

use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    public function getAll()
    {
        return Brand::all();
    }

    public function find($id)
    {
        return Brand::findOrFail($id);
    }

    public function store($data)
    {
        return Brand::create([
            'slug' => $data['slug'],
            'logo_url' => $data['logo_url'],
            'status' => $data['status'],
        ]);
    }

    public function update($id, array $data)
    {
        $brand = Brand::findOrFail($id);
        $brand->update($data);

        return $brand;
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        return $brand->delete();
    }
}
