<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'language_code', 'name', 'description', 'image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
