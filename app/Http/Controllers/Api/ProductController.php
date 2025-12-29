<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', app()->getLocale());

        $products = Product::with([
            'translations' => function ($q) use ($lang) {
                $q->where('language_code', $lang);
            },
            'category.translations' => function ($q) use ($lang) {
                $q->where('language_code', $lang);
            },
            'brand',
            'thumbnail',
        ])
            ->where('status', 1)
            ->get()
            ->map(function ($product) {
                $translation = $product->translations->first();

                return [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'name' => $translation->name ?? '',
                    'description' => $translation->description ?? '',
                    'short_description' => $translation->short_description ?? '',
                    'price' => $product->getConvertedPriceAttribute(),
                    'thumbnail' => $product->thumbnail->image_url ?? null,
                    'category' => $product->category->translations->first()->name ?? '',
                    'brand' => $product->brand->name ?? null,
                    'rating' => round($product->averageRating(), 1),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $products,
        ]);
    }
}
