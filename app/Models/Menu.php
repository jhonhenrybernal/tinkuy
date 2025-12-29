<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'date'];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    protected $casts = [
        'date' => 'datetime',
    ];
}
