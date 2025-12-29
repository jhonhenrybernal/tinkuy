<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['menu_item_id', 'language_code', 'title'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
