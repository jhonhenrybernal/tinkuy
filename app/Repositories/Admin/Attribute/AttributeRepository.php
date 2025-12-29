<?php

namespace App\Repositories\Admin\Attribute;

use App\Models\Attribute;
use App\Models\AttributeValueTranslation;

class AttributeRepository implements AttributeRepositoryInterface
{
    public function getAll()
    {
        return Attribute::with('values.translations')->latest()->paginate(10);
    }

    public function getById($id)
    {
        return Attribute::with('values.translations')->findOrFail($id);
    }

    public function store(array $data)
    {
        $attribute = Attribute::create([
            'name' => $data['name'],
        ]);

        foreach ($data['values'] as $index => $value) {
            $attributeValue = $attribute->values()->create([
                'value' => $value,
            ]);

            if (! empty($data['translations'])) {
                foreach ($data['translations'] as $languageCode => $translatedValues) {
                    if (! empty($translatedValues[$index])) {
                        AttributeValueTranslation::create([
                            'attribute_value_id' => $attributeValue->id,
                            'language_code' => $languageCode,
                            'translated_value' => $translatedValues[$index],
                        ]);
                    }
                }
            }
        }

        return $attribute;
    }

    public function update(Attribute $attribute, array $data)
    {
        $attribute->update(['name' => $data['name']]);

        $attribute->values()->each(function ($value) {
            $value->translations()->delete();
            $value->delete();
        });

        foreach ($data['values'] as $index => $value) {
            $attributeValue = $attribute->values()->create(['value' => $value]);

            if (! empty($data['translations'])) {
                foreach ($data['translations'] as $languageCode => $translatedValues) {
                    if (! empty($translatedValues[$index])) {
                        \App\Models\AttributeValueTranslation::create([
                            'attribute_value_id' => $attributeValue->id,
                            'language_code' => $languageCode,
                            'translated_value' => $translatedValues[$index],
                        ]);
                    }
                }
            }
        }

        return $attribute;
    }

    public function delete($id)
    {
        $attribute = Attribute::findOrFail($id);

        return $attribute->delete();
    }
}
