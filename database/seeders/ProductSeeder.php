<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $languages = Language::where('active', 1)->get();

            $sizeAttr = Attribute::firstOrCreate(['name' => 'Size']);
            $colorAttr = Attribute::firstOrCreate(['name' => 'Color']);

            $sizes = ['Small', 'Medium', 'Large'];
            $colors = ['Red', 'Blue', 'Black'];

            foreach ($sizes as $size) {
                $attrValue = AttributeValue::firstOrCreate([
                    'attribute_id' => $sizeAttr->id,
                    'value' => $size,
                ]);

                foreach ($languages as $lang) {
                    $attrValue->translations()->firstOrCreate([
                        'language_code' => $lang->code,
                    ], [
                        'translated_value' => match ($lang->code) {
                            'es' => match ($size) {
                                'Small' => 'Pequeño',
                                'Medium' => 'Mediano',
                                'Large' => 'Grande',
                                default => $size,
                            },
                            'de' => match ($size) {
                                'Small' => 'Klein',
                                'Medium' => 'Mittel',
                                'Large' => 'Groß',
                                default => $size,
                            },
                            default => $size,
                        },
                    ]);
                }
            }

            foreach ($colors as $color) {
                $attrValue = AttributeValue::firstOrCreate([
                    'attribute_id' => $colorAttr->id,
                    'value' => $color,
                ]);

                foreach ($languages as $lang) {
                    $attrValue->translations()->firstOrCreate([
                        'language_code' => $lang->code,
                    ], [
                        'translated_value' => match ($lang->code) {
                            'es' => match ($color) {
                                'Red' => 'Rojo',
                                'Blue' => 'Azul',
                                'Black' => 'Negro',
                                default => $color,
                            },
                            'de' => match ($color) {
                                'Red' => 'Rot',
                                'Blue' => 'Blau',
                                'Black' => 'Schwarz',
                                default => $color,
                            },
                            default => $color,
                        },
                    ]);
                }
            }

            $vendor = Vendor::first() ?? Vendor::factory()->create();
            $category = Category::first() ?? Category::factory()->create();
            $brand = Brand::first() ?? Brand::factory()->create();

            $products = [
                [
                    'name' => 'Cool T-Shirt',
                    'slug' => 'cool-tshirt',
                    'image' => 'https://i.postimg.cc/zBCkRRvb/T-Shirt-removebg-preview.png',
                    'description' => 'Trendy T-Shirt available in multiple sizes and colors.',
                ],
                [
                    'name' => 'Sport Shoes',
                    'slug' => 'sport-shoes',
                    'image' => 'https://i.postimg.cc/YS1FXBHT/images-removebg-preview.png',
                    'description' => 'Comfortable sport shoes for daily use.',
                ],
                [
                    'name' => 'Wireless Headphones',
                    'slug' => 'wireless-headphones',
                    'image' => 'https://i.postimg.cc/2Sn3YdKZ/images-1-removebg-preview-2.png',
                    'description' => 'Noise-cancelling wireless headphones with long battery life.',
                ],
                [
                    'name' => 'Travel Backpack',
                    'slug' => 'travel-backpack',
                    'image' => 'https://i.postimg.cc/WpDkKZTM/images-2-removebg-preview-1.png',
                    'description' => 'Durable backpack for travel and outdoor activities.',
                ],
            ];

            foreach ($products as $item) {
                $product = Product::create([
                    'shop_id' => 1,
                    'vendor_id' => $vendor->id,
                    'slug' => $item['slug'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'product_type' => 'variable',
                    'status' => 1,
                ]);

                foreach ($languages as $lang) {
                    $translatedName = match ($lang->code) {
                        'es' => match ($item['name']) {
                            'Cool T-Shirt' => 'Camiseta genial',
                            'Sport Shoes' => 'Zapatillas deportivas',
                            'Wireless Headphones' => 'Auriculares inalámbricos',
                            'Travel Backpack' => 'Mochila de viaje',
                            default => $item['name'],
                        },
                        'de' => match ($item['name']) {
                            'Cool T-Shirt' => 'Cooles T-Shirt',
                            'Sport Shoes' => 'Sportschuhe',
                            'Wireless Headphones' => 'Kabellose Kopfhörer',
                            'Travel Backpack' => 'Reiserucksack',
                            default => $item['name'],
                        },
                        default => $item['name'],
                    };

                    $translatedDescription = match ($lang->code) {
                        'es' => match ($item['name']) {
                            'Cool T-Shirt' => 'Camiseta moderna disponible en varios tamaños y colores.',
                            'Sport Shoes' => 'Zapatillas deportivas cómodas para uso diario.',
                            'Wireless Headphones' => 'Auriculares inalámbricos con cancelación de ruido y batería de larga duración.',
                            'Travel Backpack' => 'Mochila duradera para viajes y actividades al aire libre.',
                            default => $item['description'],
                        },
                        'de' => match ($item['name']) {
                            'Cool T-Shirt' => 'Trendiges T-Shirt in verschiedenen Größen und Farben erhältlich.',
                            'Sport Shoes' => 'Bequeme Sportschuhe für den täglichen Gebrauch.',
                            'Wireless Headphones' => 'Kabellose Kopfhörer mit Geräuschunterdrückung und langer Akkulaufzeit.',
                            'Travel Backpack' => 'Robuster Rucksack für Reisen und Outdoor-Aktivitäten.',
                            default => $item['description'],
                        },
                        default => $item['description'],
                    };

                    $product->translations()->create([
                        'language_code' => $lang->code,
                        'name' => $translatedName,
                        'description' => $translatedDescription,
                    ]);
                }

                $imageUrl = $item['image'];
                $imageName = basename($imageUrl);
                try {
                    $imageContents = file_get_contents($imageUrl);
                    $localPath = 'products/'.$imageName;
                    Storage::disk('public')->put($localPath, $imageContents);
                } catch (\Exception $e) {
                    $localPath = $imageUrl;
                }

                $product->images()->create([
                    'name' => $imageName,
                    'image_url' => $localPath,
                    'type' => 'thumb',
                ]);

                $sizesAttrValues = AttributeValue::where('attribute_id', $sizeAttr->id)->get();
                $colorsAttrValues = AttributeValue::where('attribute_id', $colorAttr->id)->get();

                foreach ($sizesAttrValues as $size) {
                    foreach ($colorsAttrValues as $color) {
                        $price = rand(20, 60);
                        $discountPrice = rand(10, $price);

                        $variant = $product->variants()->create([
                            'variant_slug' => Str::slug("{$item['name']} {$size->value}-{$color->value}").'-'.uniqid(),
                            'price' => $price,
                            'discount_price' => $discountPrice,
                            'stock' => rand(50, 200),
                            'SKU' => strtoupper(substr($size->value, 0, 1)).substr($color->value, 0, 2).rand(100, 999),
                            'barcode' => null,
                            'weight' => '0.5',
                            'dimensions' => '10x10x2 cm',
                            'is_primary' => 1,
                        ]);

                        foreach ($languages as $lang) {
                            $variant->translations()->create([
                                'language_code' => $lang->code,
                                'name' => "{$size->value} - {$color->value}",
                            ]);
                        }

                        foreach ([$size->id, $color->id] as $attrValueId) {
                            DB::table('product_variant_attribute_values')->insert([
                                'product_id' => $product->id,
                                'product_variant_id' => $variant->id,
                                'attribute_value_id' => $attrValueId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            ProductAttributeValue::firstOrCreate([
                                'product_id' => $product->id,
                                'attribute_value_id' => $attrValueId,
                            ]);
                        }
                    }
                }
            }
        });
    }
}
