<?php

namespace App\Repositories\Admin\Category;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function store($data)
    {
        $slug = \Str::slug($data['name']);

        $category = $this->create([
            'slug' => $slug,
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'] ?? true,
            'parent_category_id' => $data['parent_category_id'] ?? null,
        ]);

        return $category;
    }

    public function update($id, array $data)
    {
        $category = $this->find($id);
        $slug = \Str::slug($data['name']);

        $category->update([
            'slug' => $slug,
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'] ?? true,
            'parent_category_id' => $data['parent_category_id'] ?? null,
        ]);

        return $category;
    }

    public function destroy($id)
    {
        $category = $this->find($id);

        foreach ($category->translations as $translation) {
            if ($translation->image_url) {
                \Storage::disk('public')->delete($translation->image_url);
            }
        }

        return $category->delete();
    }

    public function storeWithTranslations(array $translations)
    {
        $slug = Str::slug($translations['en']['name']);

        $category = Category::create([
            'slug' => $slug,
        ]);

        foreach ($translations as $languageCode => $translation) {
            $imagePath = null;

            if (isset($translation['image']) && $translation['image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $translation['image']->store('categories', 'public');
            }

            CategoryTranslation::create([
                'category_id' => $category->id,
                'language_code' => $languageCode,
                'name' => $translation['name'],
                'description' => $translation['description'] ?? null,
                'image_url' => $imagePath,
            ]);
        }

        return $category;
    }

    public function updateWithTranslations(Category $category, array $translations)
    {
        foreach ($translations as $languageCode => $translation) {
            $imagePath = $category->translations()->where('language_code', $languageCode)->value('image_url');

            if (isset($translation['image']) && $translation['image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $translation['image']->store('categories', 'public');
            }

            $category->translations()->updateOrCreate(
                ['language_code' => $languageCode],
                [
                    'name' => $translation['name'],
                    'description' => $translation['description'] ?? null,
                    'image_url' => $imagePath,
                ]
            );
        }

        return $category;
    }
}
