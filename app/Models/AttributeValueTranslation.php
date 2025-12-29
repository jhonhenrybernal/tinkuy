<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_value_id', 'language_code', 'translated_value'];

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
