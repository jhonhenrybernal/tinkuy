<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'slug', 'order_number', 'parent_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menuItemTranslations()
    {
        return $this->hasMany(MenuItemTranslation::class);
    }

    public function translations()
    {
        return $this->hasMany(MenuItemTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(MenuItemTranslation::class)
            ->where('language_code', app()->getLocale());
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
}
