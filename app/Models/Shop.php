<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'name', 'slug', 'logo', 'description', 'status',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($shop) {
            $shop->slug = Str::slug($shop->name);
        });
    }
}
