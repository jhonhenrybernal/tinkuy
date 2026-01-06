{{-- resources/views/themes/xylo/vendor_templates/landing_3.blade.php --}}
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

    // COMPANY MEDIA: vienen del controlador como
    // [
    //   ['url' => '...', 'is_video' => true/false],
    //   ...
    // ]
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

    // Demo de productos si no hay reales
    $demoProducts = [
        ['name' => 'Producto demo 1', 'image' => asset('images/defaults/product-1.jpg'), 'price' => '$19.99'],
        ['name' => 'Producto demo 2', 'image' => asset('images/defaults/product-2.jpg'), 'price' => '$24.99'],
        ['name' => 'Producto demo 3', 'image' => asset('images/defaults/product-3.jpg'), 'price' => '$29.99'],
        ['name' => 'Producto demo 4', 'image' => asset('images/defaults/product-4.jpg'), 'price' => '$39.99'],
    ];
@endphp

@extends('themes.xylo.layouts.master')

@section('content')
<div class="vendor-landing vendor-landing-3">

    {{-- Header --}}
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

    {{-- Banner grande --}}
    <section class="py-4">
        <div class="container">
            <div class="banner-area inner-banner img-banner" style="padding-bottom: 10px !important; ">
                @if(count($bannerImages) > 1)
                    {{-- Si hay varios, usamos el slider del theme --}}
                    <div class="banner-slider">
                        @foreach($bannerImages as $image)
                            <div class="rightimg-banner" >
                                <img src="{{ $image }}" alt="Banner {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rightimg-banner">
                        <img src="{{ $bannerImages[0] }}" alt="Banner principal">
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Texto + tira de imágenes / video --}}
    <section class="py-3">
        <div class="container">
            <h3 class="h5 mb-3">Descripción</h3>
            <p>{{ $description }}</p>

            <div class="d-flex gap-2 mt-3 flex-wrap align-items-stretch">
                @foreach($companyMediaItems as $item)
                    @php
                        $isVideo = $item['is_video'] ?? false;
                        $url     = $item['url'] ?? '';
                    @endphp

                    {{-- En landing 3 mantenemos la tira horizontal.
                         Imagen: altura 80px,
                         Video: un poco más alto pero sin romper el diseño. --}}
                    <button type="button"
                        class="border-0 p-0 bg-transparent rounded overflow-hidden company-media-thumb"
                         style="{{ $isVideo ? 'width:140px;height:278px;' : 'flex:1 1 0;height:282px;' }}"
                        data-company-media="preview"
                        data-url="{{ $url }}"
                        data-type="{{ $isVideo ? 'video' : 'image' }}">
                        @if($isVideo)
                            <video
                                src="{{ $url }}"
                                class="w-100 h-100"
                                style="object-fit:cover;"
                                autoplay
                                muted
                                loop
                                playsinline
                            ></video>
                        @else
                            <img
                                src="{{ $url }}"
                                alt="Detalle {{ $loop->iteration }}"
                                class="w-100 h-100"
                                style="object-fit:cover;"
                            >
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Productos --}}
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

                            // Precio
                            $rawPrice = $product->primaryVariant->converted_price
                                ?? $product->price
                                ?? null;

                            $pPriceFormatted = $rawPrice !== null
                                ? '$' . number_format($rawPrice, 2)
                                : '';

                            // URL detalle
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

@section('css')
<style>
    .banner-area .rightimg-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
    }
</style>
@endsection
@section('js')
@endsection
