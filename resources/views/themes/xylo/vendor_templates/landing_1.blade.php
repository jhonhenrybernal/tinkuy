{{-- resources/views/themes/xylo/vendor_templates/landing_1.blade.php --}}
@php
    $companyName = $companyName ?? 'Demo Company';
    $logoUrl     = $logoUrl     ?? asset('images/defaults/vendor-logo.png');
    $description = $description ?? 'Texto descriptivo de ejemplo.';

    // BANNERS
    $bannerImages = (isset($bannerImages) && is_array($bannerImages) && count($bannerImages))
        ? $bannerImages
        : [
            asset('images/defaults/vendor-banner-1.jpg'),
            asset('images/defaults/vendor-banner-2.jpg'),
            asset('images/defaults/vendor-banner-3.jpg'),
        ];

    // COMPANY MEDIA (columna derecha: imágenes / videos)
    // Esperamos algo así desde el controlador:
    // $companyMedia = [
    //   ['url' => '...', 'is_video' => true/false],
    //   ...
    // ];
    $companyMediaItems = (isset($companyMedia) && is_array($companyMedia) && count($companyMedia))
        ? $companyMedia
        : [
            ['url' => asset('images/defaults/highlight-1.jpg'), 'is_video' => false],
            ['url' => asset('images/defaults/highlight-2.jpg'), 'is_video' => false],
            ['url' => asset('images/defaults/highlight-3.jpg'), 'is_video' => false],
        ];

    // ¿Hay productos reales?
    $hasRealProducts = isset($products)
        && $products instanceof \Illuminate\Support\Collection
        && $products->count() > 0;

    // Productos demo si no hay reales
    $demoProducts = [
        ['name' => 'Producto demo 1', 'image' => asset('images/defaults/product-1.jpg'), 'price' => '$19.99'],
        ['name' => 'Producto demo 2', 'image' => asset('images/defaults/product-2.jpg'), 'price' => '$24.99'],
        ['name' => 'Producto demo 3', 'image' => asset('images/defaults/product-3.jpg'), 'price' => '$29.99'],
        ['name' => 'Producto demo 4', 'image' => asset('images/defaults/product-4.jpg'), 'price' => '$39.99'],
    ];
@endphp

@extends('themes.xylo.layouts.master')
@section('css')
    @parent
    <style>
        /* Contenedor de la columna derecha */
        .vendor-landing-1 .company-media-stack {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .vendor-landing-1 .company-media-item {
            width: 100%;
            max-width: 260px;     /* ancho máx de la tarjeta */
            border-radius: 12px;
            overflow: hidden;
            background: #000;
        }

        /* VIDEO: formato vertical 9:16 (ej. 1080x1920) */
        .vendor-landing-1 .company-media-item--video {
            aspect-ratio: 9 / 16; /* mantiene el formato de celular vertical */
        }

        /* IMAGEN: formato más clásico 4:3 */
        .vendor-landing-1 .company-media-item--image {
            aspect-ratio: 4 / 3;
        }

        .vendor-landing-1 .company-media-item img,
        .vendor-landing-1 .company-media-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Responsive: en pantallas pequeñas se pueden mostrar 2 por fila */
        @media (max-width: 768px) {
            .vendor-landing-1 .company-media-stack {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .vendor-landing-1 .company-media-item {
                max-width: 48%;
            }
        }
    </style>
@endsection

@section('content')
<div class="vendor-landing vendor-landing-1">

    {{-- Header con logo + nombre empresa --}}
    <section class="py-3 border-bottom mb-3">
        <div class="container d-flex align-items-center gap-3">
            <div class="rounded-circle overflow-hidden border"
                 style="width:64px;height:64px;">
                <img src="{{ $logoUrl }}" alt="Logo {{ $companyName }}"
                     class="w-100 h-100" style="object-fit:cover;">
            </div>
            <div>
                <h2 class="mb-0">{{ $companyName }}</h2>
            </div>
        </div>
    </section>

    {{-- Banner (slider de imágenes) --}}
    <section class="banner-area inner-banner py-4">
        <div class="container h-100 banner-slider">
            @foreach($bannerImages as $image)
                <div>
                    <div class="row h-100 align-items-center">
                        <div class="col-12 rightimg-banner">
                            <img src="{{ $image }}" alt="Banner {{ $loop->iteration }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Descripción + columna de imágenes/video --}}
    <section class="py-4">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-md-7">
                    <h3 class="h5 mb-3">Sobre la empresa</h3>
                    <p class="mb-0">{{ $description }}</p>
                </div>
                <div class="col-md-5">
                    <div class="company-media-stack"
                        data-company-media-group="company-media-landing1">

                        @foreach($companyMediaItems as $index => $item)
                            @php
                                $isVideo = $item['is_video'] ?? false;
                                $url     = $item['url'] ?? '';
                            @endphp

                            <button type="button"
                                    class="company-media-item {{ $isVideo ? 'company-media-item--video' : 'company-media-item--image' }} company-media-thumb"
                                    data-company-media="preview"
                                    data-url="{{ $url }}"
                                    data-type="{{ $isVideo ? 'video' : 'image' }}"
                                    data-index="{{ $index }}">

                                @if($isVideo)
                                    <video
                                        src="{{ $url }}"
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                    ></video>
                                @else
                                    <img
                                        src="{{ $url }}"
                                        alt="Imagen empresa {{ $loop->iteration }}"
                                    >
                                @endif
                            </button>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Grid de productos --}}
    <section class="py-4">
        <div class="container">
            <h3 class="h5 mb-3">Productos</h3>
            <div class="row g-3">

                {{-- Si hay productos reales, mostramos esos --}}
                @if($hasRealProducts)
                    @foreach($products as $product)
                        @php
                            // Nombre
                            $pName = $product->translation->name
                                ?? $product->name
                                ?? 'Producto';

                            // Imagen: primera de images(), luego image_url, luego default
                            $imageModel = $product->images->first();

                            if ($imageModel && $imageModel->image_url) {
                                $pImage = \Storage::url($imageModel->image_url);
                            } elseif (!empty($product->image_url)) {
                                $pImage = \Storage::url($product->image_url);
                            } else {
                                $pImage = asset('images/defaults/product-1.jpg');
                            }

                            // Precio (ajusta según tu lógica real)
                            $rawPrice = $product->primaryVariant->converted_price
                                ?? $product->price
                                ?? null;

                            $pPriceFormatted = $rawPrice !== null
                                ? '$' . number_format($rawPrice, 2)
                                : '';

                            // URL al detalle del producto
                            $pUrl = route('product.show', $product->slug ?? $product->id);
                        @endphp

                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="product-card">
                                <a href="{{ $pUrl }}" class="text-decoration-none text-dark d-block">
                                    <div class="product-img">
                                        <img src="{{ $pImage }}" alt="{{ $pName }}">
                                    </div>
                                    <div class="product-info mt-3">
                                        <div class="bottom-info">
                                            <div class="left">
                                                <h3 class="mb-1">
                                                    <span class="product-title">{{ $pName }}</span>
                                                </h3>
                                                @if($pPriceFormatted)
                                                    <p class="price mb-0">
                                                        <span class="original">{{ $pPriceFormatted }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

                {{-- Si no hay productos reales, mostramos los demo --}}
                @else
                    @foreach($demoProducts as $product)
                        @php
                            $pName  = $product['name'];
                            $pImage = $product['image'];
                            $pPrice = $product['price'];
                        @endphp

                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ $pImage }}" alt="{{ $pName }}">
                                </div>
                                <div class="product-info mt-3">
                                    <div class="bottom-info">
                                        <div class="left">
                                            <h3 class="mb-1">
                                                <span class="product-title">{{ $pName }}</span>
                                            </h3>
                                            <p class="price mb-0">
                                                <span class="original">{{ $pPrice }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

</div>
@include('themes.xylo.vendor_templates.partials.company_media_modal')
@endsection

@section('js')
@endsection
