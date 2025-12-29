<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = ['slug', 'logo_url', 'status'];

    public function translations()
    {
        return $this->hasMany(BrandTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(BrandTranslation::class)
            ->where('locale', App::getLocale());
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
