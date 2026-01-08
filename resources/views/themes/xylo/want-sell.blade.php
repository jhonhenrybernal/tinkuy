@extends('themes.xylo.layouts.master')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('content')
<style>
    /* HERO CON COLORES DE LA BANDERA DE COLOMBIA */
    .vendor-landing-hero {
        position: relative;
        overflow: hidden;
        padding: 4rem 0 3rem;
        color: #0f172a;
        background: linear-gradient(
            to bottom,
            /* Amarillo */
            #ffd600 0%,
            #ffd600 8%,
            /* Azul */
            #0033a0 8%,
            #0033a0 14%,
            /* Rojo */
            #ce1126 14%,
            #ce1126 20%,
            /* Transición hacia blanco */
            #f4f4f8 35%,
            #ffffff 100%
        );
    }

    /* Bandera de Colombia como marca de agua arriba a la derecha */
    .vendor-landing-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: url("/images/flags/flag-colombia.svg")
                    no-repeat top right;
        background-size: 260px auto; /* ajusta el tamaño si quieres */
        opacity: 0.12;               /* muy suave para no distraer */
        pointer-events: none;
    }

    .vendor-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .25rem .75rem;
        border-radius: 999px;
        background: rgba(15,23,42,.9);
        font-size: .8rem;
        color: #fff;
        backdrop-filter: blur(6px);
    }

    .vendor-hero-illustration {
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 25px 55px rgba(15,23,42,.15);
        border: 1px solid rgba(15,23,42,.08);
        background: linear-gradient(135deg, #111827, #1f2937);
        min-height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e5e7eb;
        text-align: center;
        padding: 1.5rem;
    }

    .vendor-section-title {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: .75rem;
    }

    .vendor-feature-card {
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        padding: 1.25rem;
        height: 100%;
        background: #fff;
        box-shadow: 0 10px 25px rgba(15,23,42,.04);
    }

    .vendor-feature-icon {
        width: 36px;
        height: 36px;
        border-radius: .75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        background: #eef2ff;
        color: #4f46e5;
        margin-bottom: .75rem;
    }

    .vendor-step {
        display: flex;
        gap: .75rem;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .vendor-step-number {
        width: 28px;
        height: 28px;
        border-radius: 999px;
        background: #4f46e5;
        color: #fff;
        font-size: .85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .vendor-form-card {
        border-radius: 1.25rem;
        border: 1px solid #e5e7eb;
        padding: 1.75rem 1.5rem;
        background: #fff;
        box-shadow: 0 18px 40px rgba(15,23,42,.06);
    }

    .vendor-chip {
        display:inline-flex;
        align-items:center;
        border-radius:999px;
        background:#f3f4f6;
        padding:.25rem .7rem;
        font-size:.78rem;
        margin-right:.35rem;
        margin-bottom:.35rem;
    }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 500;
        background-color: #f4f4f5;   /* gris claro */
        color: #111827;              /* texto oscuro */
        border: 1px solid rgba(15,23,42,0.08);
        white-space: nowrap;
    }

    @media (min-width: 992px) {
        .vendor-landing-hero {
            padding: 5rem 0 4rem;
        }
    }
</style>

<div class="vendor-public-landing">

    {{-- HERO --}}
    <section class="vendor-landing-hero">
        <div class="container position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3">
                        Vende tus productos<br>
                        en nuestra plataforma
                    </h1>
                    <p class="lead mb-3 text-muted">
                        Llega a miles de clientes sin preocuparte por la tecnología.
                        Nosotros ponemos la vitrina, tú te enfocas en vender.
                    </p>

                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-1">
                            <i class="bi bi-check-circle-fill me-2 text-success"></i>
                            <span>Sin costo de inscripción inicial.</span>
                        </li>
                        <li class="d-flex align-items-center mb-1">
                            <i class="bi bi-check-circle-fill me-2 text-success"></i>
                            <span>Panel para gestionar tus productos y pedidos.</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2 text-success"></i>
                            <span>Acompañamiento en la configuración de tu tienda.</span>
                        </li>
                    </ul>

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="#vendor-apply-form" class="btn btn-primary btn-lg">
                            Quiero empezar a vender
                        </a>
                        <div class="text-sm">
                            <div class="small text-muted">Ideal para:</div>
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <span class="hero-chip">Emprendedores</span>
                                <span class="hero-chip">Tiendas físicas</span>
                                <span class="hero-chip">Marcas digitales</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 ms-lg-auto">
                    <div class="vendor-hero-illustration">
                        {{-- Aquí puedes colocar una imagen o slider real --}}
                        <div>
                            <div class="mb-2 small text-muted">
                                Vista de ejemplo
                            </div>
                            <h3 class="h4 mb-2">Tu marca con presencia profesional</h3>
                            <p class="mb-3 small text-gray-200">
                                Banner principal, descripción, catálogo y estadísticas en un solo lugar.
                            </p>
                            <img src="{{ asset('images/defaults/vendor-banner-1.jpg') }}"
                                 alt="Ejemplo tienda"
                                 style="width:100%;max-width:340px;border-radius:.75rem;object-fit:cover;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFICIOS / CÓMO FUNCIONA --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-start g-4">
                <div class="col-lg-6">
                    <h2 class="vendor-section-title">¿Por qué vender con nosotros?</h2>
                    <p class="text-muted mb-4">
                        Diseñamos nuestra plataforma pensando en pequeños negocios,
                        emprendedores y marcas establecidas que quieren vender más
                        sin complicarse.
                    </p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="vendor-feature-card">
                                <div class="vendor-feature-icon">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Más visibilidad</h6>
                                <p class="small text-muted mb-0">
                                    Aparece en los listados y campañas destacadas de la plataforma.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="vendor-feature-card">
                                <div class="vendor-feature-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Tienda lista en minutos</h6>
                                <p class="small text-muted mb-0">
                                    Plantillas optimizadas, adaptadas a celular y escritorio.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="vendor-feature-card">
                                <div class="vendor-feature-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Pagos confiables</h6>
                                <p class="small text-muted mb-0">
                                    Integración con pasarelas de pago y facturación.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="vendor-feature-card">
                                <div class="vendor-feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Soporte cercano</h6>
                                <p class="small text-muted mb-0">
                                    Te acompañamos en la configuración y primeras ventas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pasos --}}
                <div class="col-lg-5 ms-lg-auto">
                    <h2 class="vendor-section-title">¿Cómo funciona?</h2>
                    <div class="vendor-step">
                        <div class="vendor-step-number">1</div>
                        <div>
                            <h6 class="fw-semibold mb-1">Déjanos tus datos</h6>
                            <p class="small text-muted mb-0">
                                Completa el formulario de abajo con la información básica de tu negocio.
                            </p>
                        </div>
                    </div>
                    <div class="vendor-step">
                        <div class="vendor-step-number">2</div>
                        <div>
                            <h6 class="fw-semibold mb-1">Validamos tu información</h6>
                            <p class="small text-muted mb-0">
                                Nuestro equipo revisa tu solicitud y se pone en contacto contigo.
                            </p>
                        </div>
                    </div>
                    <div class="vendor-step">
                        <div class="vendor-step-number">3</div>
                        <div>
                            <h6 class="fw-semibold mb-1">Activa tu catálogo</h6>
                            <p class="small text-muted mb-0">
                                Cargamos tus productos, configuramos tu plantilla y empiezas a vender.
                            </p>
                        </div>
                    </div>
                    <p class="small text-muted mt-3">
                        El registro inicial no te compromete a nada. Solo sirve para conocerte
                        y validar que tu negocio encaje con nuestra plataforma.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- FORMULARIO DE REGISTRO RÁPIDO --}}
    <section class="py-5" id="vendor-apply-form">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-7 text-center">
                    <h2 class="vendor-section-title">Déjanos tus datos y te contactamos</h2>
                    <p class="text-muted mb-0">
                        Responde este formulario corto y en pocos días un miembro de nuestro equipo
                        se comunicará contigo para ayudarte a activar tu tienda.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="vendor-form-card">

                        {{-- Mensajes generales --}}
                        <div class="mb-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Por favor corrige los errores marcados en el formulario.</strong>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('vendors.lead.store') }}" method="POST" id="vendor-lead-form">
                            @csrf

                            <div class="row g-3">

                                {{-- Nombre completo --}}
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label">Nombre completo</label>
                                    <input
                                        type="text"
                                        name="full_name"
                                        id="full_name"
                                        value="{{ old('full_name') }}"
                                        class="form-control @error('full_name') is-invalid @enderror"
                                        required
                                    >
                                    @error('full_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        required
                                    >
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Teléfono --}}
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Teléfono / WhatsApp (opcional)</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        value="{{ old('phone') }}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                    >
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Marca / negocio --}}
                                <div class="col-md-6">
                                    <label for="brand_name" class="form-label">Nombre de la marca o negocio</label>
                                    <input
                                        type="text"
                                        name="brand_name"
                                        id="brand_name"
                                        value="{{ old('brand_name') }}"
                                        class="form-control @error('brand_name') is-invalid @enderror"
                                    >
                                    @error('brand_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Tipo de proveedor --}}
                                <div class="col-md-12">
                                    <label class="form-label d-block">Tipo de proveedor</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="vendor_type"
                                                id="vendor_type_informal"
                                                value="informal"
                                                {{ old('vendor_type','informal')=='informal' ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="vendor_type_informal">
                                                Persona informal
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="vendor_type"
                                                id="vendor_type_natural"
                                                value="natural"
                                                {{ old('vendor_type')=='natural' ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="vendor_type_natural">
                                                Persona natural
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="vendor_type"
                                                id="vendor_type_juridica"
                                                value="juridica"
                                                {{ old('vendor_type')=='juridica' ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="vendor_type_juridica">
                                                Persona jurídica
                                            </label>
                                        </div>
                                    </div>
                                    @error('vendor_type')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Qué vendes --}}
                                <div class="col-12">
                                    <label for="about" class="form-label">Cuéntanos brevemente qué vendes</label>
                                    <textarea
                                        name="about"
                                        id="about"
                                        rows="3"
                                        class="form-control @error('about') is-invalid @enderror"
                                        placeholder="Ej: Ropa deportiva para mujer, desarrollo de software a la medida, etc."
                                    >{{ old('about') }}</textarea>
                                    @error('about')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 d-flex justify-content-between align-items-center mt-2">
                                    <button type="submit" class="btn btn-primary">
                                        Enviar mi solicitud
                                    </button>
                                    <div class="small text-muted">
                                        Tiempo estimado de respuesta: 1–3 días hábiles.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
