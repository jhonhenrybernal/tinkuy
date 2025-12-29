<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        return view('admin.site-settings.index');
    }

    public function edit()
    {
        $settings = SiteSetting::first();

        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'       => 'required|string|max:255',
            'tagline'         => 'nullable|string|max:255',
            'meta_title'      => 'nullable|string|max:255',
            'meta_description'=> 'nullable|string',
            'meta_keywords'   => 'nullable|string',
            'contact_email'   => 'nullable|email',
            'contact_phone'   => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'footer_text'     => 'nullable|string',
        ]);

        $data = $request->only([
            'site_name',
            'tagline',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'contact_email',
            'contact_phone',
            'address',
            'footer_text',
        ]);

        // if row exists, update; otherwise create it
        $settings = SiteSetting::first();

        if ($settings) {
            $settings->update($data);
        } else {
            SiteSetting::create($data);
        }

        return redirect()->back()->with('success', 'Site settings updated successfully!');
    }

}
