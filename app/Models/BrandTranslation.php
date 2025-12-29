<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    use HasFactory;

    protected $table = 'brand_translations';

    protected $fillable = ['brand_id', 'locale', 'name', 'description'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
