<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->get('lang', App::getLocale());

        $brands = Brand::with(['translations' => function ($query) {
            $query->where('locale', App::getLocale());
        }])
            ->where('status', 'active')
            ->get()
            ->map(function ($brand) {
                $translation = $brand->translations->first();

                return [
                    'id' => $brand->id,
                    'slug' => $brand->slug,
                    'logo_url' => $brand->logo_url,
                    'status' => $brand->status,
                    'name' => $translation->name ?? null,
                    'description' => $translation->description ?? null,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $brands,
        ]);
    }
}
