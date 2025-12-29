<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'platform', 'link'];

    // Relationship with translations
    public function translations()
    {
        return $this->hasMany(SocialMediaLinkTranslation::class);
    }
}
