<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_settings')->insert([
            'site_name' => 'My Awesome Laravel Site',
            'tagline' => 'Building the future of web development',
            'meta_title' => 'My Awesome Laravel Site - Home',
            'meta_description' => 'Welcome to My Awesome Laravel Site, the place for all your web development needs.',
            'meta_keywords' => 'laravel, web development, awesome site',
            'logo' => 'path_to_logo.png',
            'favicon' => 'favicon.ico',
            'contact_email' => 'contact@myawesomelarsite.com',
            'contact_phone' => '+1 234 567 890',
            'address' => '123 Laravel St, Web City, Webland',
            'footer_text' => '© 2025 My Awesome Laravel Site. All rights reserved.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
