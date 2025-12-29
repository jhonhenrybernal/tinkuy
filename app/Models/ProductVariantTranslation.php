<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'language_code',
        'name',
    ];

    // Relationship with the ProductVariant model
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
