<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['code' => 'en', 'name' => 'English', 'translated_text' => 'English', 'active' => true],
            ['code' => 'ar', 'name' => 'Arabic', 'translated_text' => 'العربية', 'active' => false],
            ['code' => 'de', 'name' => 'German', 'translated_text' => 'Deutsch', 'active' => true],
            ['code' => 'es', 'name' => 'Spanish', 'translated_text' => 'Español', 'active' => true],
            ['code' => 'fa', 'name' => 'Persian', 'translated_text' => 'فارسی', 'active' => false],
            ['code' => 'fr', 'name' => 'French', 'translated_text' => 'Français', 'active' => true],
            ['code' => 'hi', 'name' => 'Hindi', 'translated_text' => 'हिन्दी', 'active' => false],
            ['code' => 'id', 'name' => 'Indonesian', 'translated_text' => 'Bahasa Indonesia', 'active' => false],
            ['code' => 'it', 'name' => 'Italian', 'translated_text' => 'Italiano', 'active' => false],
            ['code' => 'ja', 'name' => 'Japanese', 'translated_text' => '日本語', 'active' => false],
            ['code' => 'ko', 'name' => 'Korean', 'translated_text' => '한국어', 'active' => false],
            ['code' => 'nl', 'name' => 'Dutch', 'translated_text' => 'Nederlands', 'active' => false],
            ['code' => 'pl', 'name' => 'Polish', 'translated_text' => 'Polski', 'active' => false],
            ['code' => 'pt', 'name' => 'Portuguese', 'translated_text' => 'Português', 'active' => false],
            ['code' => 'ru', 'name' => 'Russian', 'translated_text' => 'Русский', 'active' => false],
            ['code' => 'th', 'name' => 'Thai', 'translated_text' => 'ไทย', 'active' => false],
            ['code' => 'tr', 'name' => 'Turkish', 'translated_text' => 'Türkçe', 'active' => false],
            ['code' => 'vi', 'name' => 'Vietnamese', 'translated_text' => 'Tiếng Việt', 'active' => false],
            ['code' => 'zh', 'name' => 'Chinese', 'translated_text' => '中文', 'active' => false],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], [
                'name' => $lang['name'],
                'active' => $lang['active'],
            ]);
        }
    }
}
