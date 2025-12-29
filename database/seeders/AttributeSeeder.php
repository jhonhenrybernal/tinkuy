<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeAttributeId = DB::table('attributes')->insertGetId([
            'name' => 'Size',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sizes = ['Small', 'Medium', 'Large'];
        foreach ($sizes as $size) {
            $valueId = DB::table('attribute_values')->insertGetId([
                'attribute_id' => $sizeAttributeId,
                'value' => $size,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add a default translation (English)
            DB::table('attribute_value_translations')->insert([
                'attribute_value_id' => $valueId,
                'language_code' => 'en',
                'translated_value' => $size,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert 'Color' attribute
        $colorAttributeId = DB::table('attributes')->insertGetId([
            'name' => 'Color',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $colors = ['Red', 'Green', 'Blue', 'Black', 'White', 'Yellow'];
        foreach ($colors as $color) {
            $valueId = DB::table('attribute_values')->insertGetId([
                'attribute_id' => $colorAttributeId,
                'value' => $color,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('attribute_value_translations')->insert([
                'attribute_value_id' => $valueId,
                'language_code' => 'en',
                'translated_value' => $color,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
