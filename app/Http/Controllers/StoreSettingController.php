<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    public function index()
    {
        return StoreSetting::all();
    }

    public function update(Request $request, $key)
    {
        $setting = StoreSetting::where('key', $key)->first();

        if ($setting) {
            $setting->update(['value' => $request->value]);

            return response()->json(['message' => 'Setting updated']);
        }

        return response()->json(['message' => 'Setting not found'], 404);
    }
}
