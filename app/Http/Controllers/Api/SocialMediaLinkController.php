<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SocialMediaLinkController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());

        $links = SocialMediaLink::with([
            'translations' => function ($query) use ($lang) {
                $query->where('language_code', $lang);
            },
        ])
            ->get();

        $data = $links->map(function ($link) {
            $translation = $link->translations->first();

            return [
                'id' => $link->id,
                'type' => $link->type,
                'platform' => $link->platform,
                'link' => $link->link,
                'name' => $translation ? $translation->name : null,
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
}
