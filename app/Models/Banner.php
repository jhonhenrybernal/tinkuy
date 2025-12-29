<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'type',
    ];

    /**
     * Get the translations for the banner.
     */
    public function translations()
    {
        return $this->hasMany(BannerTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(BannerTranslation::class)->where('language_code', App::getLocale());
    }
}
