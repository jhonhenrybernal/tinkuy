<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'status'];

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation($languageCode = null)
    {
        $languageCode = $languageCode ?? app()->getLocale();

        return $this->translations()->where('language_code', $languageCode)->first();
    }
}
