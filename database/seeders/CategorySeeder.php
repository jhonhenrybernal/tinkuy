<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $languages = Language::where('active', 1)->pluck('code')->toArray();

            $categories = [
                [
                    'slug' => 'electronics',
                    'parent_slug' => null,
                    'translations' => [
                        'en' => ['name' => 'Electronics', 'description' => 'Electronic devices'],
                        'fr' => ['name' => 'Électronique', 'description' => 'Appareils électroniques'],
                        'es' => ['name' => 'Electrónica', 'description' => 'Dispositivos electrónicos'],
                    ],
                    'image' => 'https://i.postimg.cc/mgTTQWtW/07-300x300-1-1-removebg-preview.png',
                ],
                [
                    'slug' => 'fashion',
                    'parent_slug' => null,
                    'translations' => [
                        'en' => ['name' => 'Fashion', 'description' => 'Clothing and accessories'],
                        'fr' => ['name' => 'Mode', 'description' => 'Vêtements et accessoires'],
                        'es' => ['name' => 'Moda', 'description' => 'Ropa y accesorios'],
                    ],
                    'image' => 'https://i.postimg.cc/QM9NMkFF/cat7-removebg-preview.png',
                ],
                [
                    'slug' => 'smartphones',
                    'parent_slug' => 'electronics',
                    'translations' => [
                        'en' => ['name' => 'Smartphones', 'description' => 'Latest mobile phones'],
                        'fr' => ['name' => 'Smartphones', 'description' => 'Derniers téléphones mobiles'],
                        'es' => ['name' => 'Smartphones', 'description' => 'Últimos teléfonos móviles'],
                    ],
                    'image' => 'https://i.postimg.cc/ZKwJFD39/cat1-removebg-preview.png',
                ],
                [
                    'slug' => 't-shirts',
                    'parent_slug' => 'fashion',
                    'translations' => [
                        'en' => ['name' => 'T-Shirts', 'description' => 'Casual wear t-shirts'],
                        'fr' => ['name' => 'T-shirts', 'description' => 'T-shirts décontractés'],
                        'es' => ['name' => 'Camisetas', 'description' => 'Camisetas informales'],
                    ],
                    'image' => 'https://i.postimg.cc/VkSP9smT/cat2-removebg-preview.png',
                ],
            ];

            foreach ($categories as $categoryData) {
                $parentId = $categoryData['parent_slug']
                    ? Category::where('slug', $categoryData['parent_slug'])->value('id')
                    : null;

                $category = Category::firstOrCreate(
                    ['slug' => $categoryData['slug']],
                    [
                        'parent_category_id' => $parentId,
                        'status' => true,
                    ]
                );

                $imageUrl = $categoryData['image'];
                $imageName = basename($imageUrl);

                try {
                    $imageContents = file_get_contents($imageUrl);
                    $localPath = 'categories/'.$imageName;
                    Storage::disk('public')->put($localPath, $imageContents);
                } catch (\Exception $e) {
                    $localPath = $imageUrl;
                }

                foreach ($languages as $lang) {
                    $translation = $categoryData['translations'][$lang] ?? $categoryData['translations']['en'];

                    $category->translations()->updateOrCreate(
                        ['language_code' => $lang],
                        [
                            'name' => $translation['name'],
                            'description' => $translation['description'],
                            'image_url' => $localPath,
                        ]
                    );
                }
            }
        });
    }
}
