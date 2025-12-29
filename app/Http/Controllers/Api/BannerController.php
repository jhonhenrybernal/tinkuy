<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->get('lang', app()->getLocale());

        $banners = Banner::with(['translations' => function ($query) use ($language) {
            $query->where('language_code', $language);
        }])
            ->where('status', 1)
            ->get()
            ->map(function ($banner) {
                $translation = $banner->translations->first();

                return [
                    'id' => $banner->id,
                    'type' => $banner->type,
                    'title' => $translation->title ?? $banner->title,
                    'description' => $translation->description ?? null,
                    'image_url' => $translation->image_url ?? null,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $banners,
        ]);
    }
}
