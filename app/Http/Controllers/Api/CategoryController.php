<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->get('lang', App::getLocale());

        $categories = Category::with([
            'translations' => function ($query) use ($language) {
                $query->where('language_code', $language);
            },
            'children.translations',
        ])
            ->where('status', true)
            ->whereNull('parent_category_id')
            ->get()
            ->map(function ($category) {
                $translation = $category->translations->first();

                return [
                    'id' => $category->id,
                    'slug' => $category->slug,
                    'name' => $translation->name ?? 'N/A',
                    'description' => $translation->description ?? null,
                    'image_url' => $translation->image_url ?? null,
                    'children' => $category->children->map(function ($child) {
                        $childTranslation = $child->translations->first();

                        return [
                            'id' => $child->id,
                            'slug' => $child->slug,
                            'name' => $childTranslation->name ?? 'N/A',
                            'description' => $childTranslation->description ?? null,
                            'image_url' => $childTranslation->image_url ?? null,
                        ];
                    }),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $categories,
        ]);
    }
}
