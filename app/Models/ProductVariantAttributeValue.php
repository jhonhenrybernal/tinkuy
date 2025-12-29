<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttributeValue extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'product_variant_attribute_values';

    // The attributes that are mass assignable.
    protected $fillable = [
        'product_variant_id',
        'attribute_value_id',
        'product_id',
    ];

    // Define relationships if necessary
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
