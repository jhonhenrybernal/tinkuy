<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function translations()
    {
        return $this->hasMany(AttributeValueTranslation::class, 'attribute_value_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values', 'attribute_value_id', 'product_id');
    }

    public function getTranslatedValueAttribute()
    {
        $locale = app()->getLocale(); // or however you’re managing languages

        return $this->translations->firstWhere('language_code', $locale)?->translated_value ?? $this->value;
    }
}
