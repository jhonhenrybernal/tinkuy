<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLinkTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['social_media_link_id', 'language_code', 'name'];

    // Relationship with social media link
    public function socialMediaLink()
    {
        return $this->belongsTo(SocialMediaLink::class);
    }
}
