<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = ['banner_id', 'language_code', 'title', 'description', 'image_url', 'type'];

    // Relationship with Banner
    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}
