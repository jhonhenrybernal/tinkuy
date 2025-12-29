<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::where('active', 1)->get();

        $logoPath = 'brands/logo-ready.png';
        if (! Storage::disk('public')->exists($logoPath)) {
            Storage::disk('public')->put($logoPath, file_get_contents('https://i.postimg.cc/vH39NxBy/velstore-logo-removebg-preview.png'));
        }

        $brandId = DB::table('brands')->insertGetId([
            'slug' => 'awesome-brand',
            'logo_url' => $logoPath,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($languages as $lang) {
            $translatedName = match ($lang->code) {
                'es' => 'Marca Asombrosa',
                'de' => 'Großartige Marke',
                default => 'Awesome Brand',
            };

            $translatedDescription = match ($lang->code) {
                'es' => 'Una marca de alta calidad conocida por sus productos asombrosos.',
                'de' => 'Eine hochwertige Marke, bekannt für ihre großartigen Produkte.',
                default => 'A high-quality brand known for its awesome products.',
            };

            DB::table('brand_translations')->insert([
                'brand_id' => $brandId,
                'locale' => $lang->code,
                'name' => $translatedName,
                'description' => $translatedDescription,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
