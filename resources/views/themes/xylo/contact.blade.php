@extends('themes.xylo.layouts.master')

@section('title', 'Contacto')

@section('content')
    {{-- Banner superior estilo XYLO --}}
    <section class="banner-area inner-banner pt-5 animate__animated animate__fadeIn productinnerbanner">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-8">
                    <div class="breadcrumbs">
                        <a href="{{ route('xylo.home') }}">Inicio</a>
                        <i class="fa fa-angle-right"></i>
                        Contacto
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- Intro --}}
                    <div class="text-center mb-4">
                        <h2 class="section-title mb-2">Aquí puedes contactarnos con cualquier inquietud</h2>
                        <p class="text-muted mb-0">
                            Puedes preguntarle a nuestro agente <strong>TinKuiY</strong>.
                        </p>
                    </div>

                    {{-- Chat UI (placeholder) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column" style="min-height: 520px;">
                                {{-- Header del chat --}}
                                <div class="p-3 border-bottom bg-light d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">Puedes preguntar para salirte de tu dudas.</small>
                                    </div>
                                </div>

                                {{-- Área de mensajes --}}
                                <div class="flex-grow-1 p-4 d-flex align-items-center justify-content-center text-muted">
                                    <div class="text-center" style="max-width: 520px;">
                                        <i class="fa fa-comments fa-2x mb-3"></i>
                                        <p class="mb-1">Aquí irá el chat.</p>
                                        <small>Más adelante conectaremos esta vista con el agente y otras tareas.</small>
                                    </div>
                                </div>

                                {{-- Input --}}
                                <div class="p-3 border-top">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Escribe tu mensaje..." disabled>
                                        <button class="btn btn-dark" type="button" disabled>Enviar</button>
                                    </div>
                                    <small class="text-muted d-block mt-2">Diseño en construcción (solo UI por ahora).</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bloque de contacto inferior --}}
                    <div class="row g-4 mt-4">
                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5 class="mb-2"><i class="fa fa-envelope me-2"></i>Correo</h5>
                                <p class="text-muted mb-0">
                                    <a class="text-decoration-none"
                                       href="mailto:{{ $contactEmail ?? 'soporte@tudominio.com' }}">
                                        {{ $contactEmail ?? 'soporte@tudominio.com' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5 class="mb-2"><i class="fa fa-phone me-2"></i>Teléfono</h5>
                                <p class="text-muted mb-0">
                                    <a class="text-decoration-none"
                                       href="tel:{{ $contactPhone ?? '+57 300 000 0000' }}">
                                        {{ $contactPhone ?? '+57 300 000 0000' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5 class="mb-2"><i class="fa fa-circle-info me-2"></i>Información</h5>
                                <p class="text-muted mb-0">
                                    {{ $contactNote ?? 'Horario: Lunes a Viernes · 9:00 a 18:00' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
