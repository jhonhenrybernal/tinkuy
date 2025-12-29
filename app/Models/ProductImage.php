<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model
    protected $table = 'product_images';

    // Specify the fillable attributes
    protected $fillable = [
        'name',
        'image_url',
        'type',
        'product_id',
    ];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
