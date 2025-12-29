<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $lang = $request->input('lang');

        if (! in_array($lang, ['en', 'es', 'de', 'ar', 'fa', 'it', 'nl', 'pl', 'pt', 'tr', 'zh', 'fr', 'ru', 'ja', 'ko', 'th', 'vi', 'hi', 'id'])) {
            return response()->json(['error' => 'Unsupported language'], 400);
        }

        session(['locale' => $lang]);
        app()->setLocale($lang);

        return redirect()->back()->with('success', 'Language changed successfully');
    }
}
