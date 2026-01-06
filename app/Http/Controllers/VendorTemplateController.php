<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorTemplateController extends Controller
{
    public function templateCompany(Request $request, int $id)
    {
        // 1. Buscar el vendor o 404
        $vendor = Vendor::findOrFail($id);

        // 2. Determinar qué plantilla usar:
        //    - Si viene ?page_type=... (por los radios de vista previa), usar esa
        //    - Si no, usar la que está guardada en la BD
        $pageType = $request->query('page_type', $vendor->page_type ?? 'landing_1');

        $view = match ($pageType) {
            'landing_2' => 'themes.xylo.vendor_templates.landing_2',
            'landing_3' => 'themes.xylo.vendor_templates.landing_3',
            default     => 'themes.xylo.vendor_templates.landing_1',
        };

        // 3. Datos básicos
        $companyName = $vendor->name ?? 'Demo Company';

        $logoUrl = $vendor->profile_image
            ? url('storage/' . $vendor->profile_image)
            : asset('images/defaults/vendor-logo.png');

        $description = $vendor->description
            ?? 'Texto descriptivo de la empresa y sus productos. Esta es una descripción de ejemplo por defecto.';

        // 4. Media (banners + imágenes empresa) desde company_media
        $media = $vendor->company_media ?? [];

        $bannerImages = collect($media['banners'] ?? [])
            ->map(fn($i) => url('storage/'.$i['path']))
            ->values()
            ->all();

        $companyMedia = collect($media['company_images'] ?? [])
        ->map(function ($item) {
            $path = $item['path'] ?? '';
            $url  = url('storage/' . $path);

            return [
                'url'      => $url,
                'is_video' => str_ends_with(strtolower($path), '.mp4'),
            ];
        })
        ->values()
        ->all();


        // 5. Productos demo (luego se pueden cambiar por productos reales del vendor)
        $products = $vendor->products()
        ->where('status', 1)                    // o 'active' según tu modelo
        ->with(['translation', 'images', 'primaryVariant'])
        ->orderByDesc('created_at')
        ->take(12)
        ->get();

        return view($view, [
            'companyName'   => $companyName,
            'logoUrl'       => $logoUrl,
            'description'   => $description,
            'bannerImages'  => $bannerImages,            
            'companyMedia'  => $companyMedia, 
            'products'      => $products,
        ]);
    }
}
