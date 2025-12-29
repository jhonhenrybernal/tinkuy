<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    // Assume that you have an 'active' column in your languages table
    protected $fillable = ['name', 'code', 'translated_text', 'active'];

    /**
     * Scope to filter active languages
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1); // Assuming 'active' column holds a boolean or 1/0 value
    }
}
