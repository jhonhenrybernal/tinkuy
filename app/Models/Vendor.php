<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use Notifiable;

    protected $guard = 'vendor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'profile_image',
        'description',
        'page_type',
        'company_media',

        // nuevos:
        'vendor_type',
        'brand_name',
        'personal_document_type',
        'personal_document_number',
        'city',
        'company_name',
        'company_nit',
        'company_nit_dv',
        'legal_representative_name',
        'legal_representative_document_type',
        'legal_representative_document_number',
        'legal_rut',
        'legal_chamber',
        'billing_provider',
        'billing_user',
        'billing_notes',
        'terms_accepted',
        'is_prospect',
        'admin_validations',
        'has_delivery_provider',
    ];


    protected $hidden = ['password'];

    protected $casts = [
        'password'      => 'hashed',
        'company_media' => 'array',  // NUEVO: JSON → array
        'admin_validations' => 'array',  // NUEVO: JSON → array
        'terms_accepted' => 'boolean',
        'is_prospect'    => 'boolean', 
        'has_delivery_provider' => 'boolean',
    ];

    /**
     * Devuelve arreglo de banners a partir de company_media.
     * Estructura esperada:
     * [
     *   'banners' => [
     *      ['path' => 'vendors/banners/1.jpg'],
     *      ...
     *   ],
     *   'company_images' => [...]
     * ]
     */
    public function getBannerImagesAttribute(): array
    {
        $media = $this->company_media ?? [];

        return $media['banners'] ?? [];
    }

    /**
     * Devuelve arreglo de imágenes de empresa (debajo de descripción).
     */
    public function getCompanyImagesAttribute(): array
    {
        $media = $this->company_media ?? [];

        return $media['company_images'] ?? [];
    }

    /**
     * URL del logo (profile_image).
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->profile_image) {
            return \Storage::url($this->profile_image);
        }

        return asset('images/defaults/vendor-logo.png');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
