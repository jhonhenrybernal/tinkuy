@extends('admin.layouts.admin')

@section('content')
@php
    // Valores por defecto desde el modelo + old()
    $vendorType      = old('vendor_type', $vendor->vendor_type ?? 'informal');
    $billingProvider = old('billing_provider', $vendor->billing_provider ?? 'internal');
    $billingUser     = old('billing_user', $vendor->billing_user ?? '');
    $billingNotes    = old('billing_notes', $vendor->billing_notes ?? '');

    $companyMedia    = $vendor->company_media ?? [];
    $existingBanners = $companyMedia['banners'] ?? [];
    $existingCompany = $companyMedia['company_images'] ?? [];
@endphp

<div class="card mt-4">
    <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 dt-heading">Editar proveedor</h6>
    </div>

    <div class="card-body">
        <form id="vendor-form" action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- =========================
                 TIPO DE PROVEEDOR
            ========================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Tipo de proveedor</strong>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="vendor_type"
                                   id="vendor_type_informal"
                                   value="informal"
                                   {{ $vendorType === 'informal' ? 'checked' : '' }}>
                            <label class="form-check-label" for="vendor_type_informal">
                                Persona informal
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="vendor_type"
                                   id="vendor_type_natural"
                                   value="natural"
                                   {{ $vendorType === 'natural' ? 'checked' : '' }}>
                            <label class="form-check-label" for="vendor_type_natural">
                                Persona natural
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="vendor_type"
                                   id="vendor_type_juridica"
                                   value="juridica"
                                   {{ $vendorType === 'juridica' ? 'checked' : '' }}>
                            <label class="form-check-label" for="vendor_type_juridica">
                                Persona jurídica
                            </label>
                        </div>
                    </div>

                    @error('vendor_type')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- =========================
                 INFORMACIÓN PERSONAL / EMPRESA
            ========================= --}}
            <div class="row g-3">

                {{-- Columna izquierda: Información personal --}}
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <strong>Información personal</strong>
                        </div>
                        <div class="card-body">

                            {{-- Nombre completo --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre completo</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $vendor->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="brand_name" class="form-label">Nombre de la marca / nombre comercial</label>
                                <input type="text"
                                    name="brand_name"
                                    id="brand_name"
                                    class="form-control @error('brand_name') is-invalid @enderror"
                                    value="{{ old('brand_name', $vendor->brand_name ?? '') }}">
                                @error('brand_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- Tipo y número de documento --}}
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label for="personal_document_type" class="form-label">Tipo de documento</label>
                                    <select name="personal_document_type"
                                            id="personal_document_type"
                                            class="form-select @error('personal_document_type') is-invalid @enderror">
                                        <option value="">Seleccione…</option>
                                        <option value="cc" {{ old('personal_document_type', $vendor->personal_document_type ?? '') === 'cc' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                                        <option value="ce" {{ old('personal_document_type', $vendor->personal_document_type ?? '') === 'ce' ? 'selected' : '' }}>Cédula de extranjería</option>
                                        <option value="pp" {{ old('personal_document_type', $vendor->personal_document_type ?? '') === 'pp' ? 'selected' : '' }}>Pasaporte</option>
                                    </select>
                                    @error('personal_document_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="personal_document_number" class="form-label">Número de documento</label>
                                    <input type="text"
                                           name="personal_document_number"
                                           id="personal_document_number"
                                           class="form-control @error('personal_document_number') is-invalid @enderror"
                                           value="{{ old('personal_document_number', $vendor->personal_document_number ?? '') }}">
                                    @error('personal_document_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Ubicación --}}
                            <div class="mb-3">
                                <label for="city" class="form-label">Ubicación (ciudad)</label>
                                <input type="text"
                                       name="city"
                                       id="city"
                                       class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city', $vendor->city ?? '') }}">
                                @error('city')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Columna derecha: Información empresa (jurídica) --}}
                <div class="col-lg-6">
                    <div class="card h-100 provider-block provider-block--juridica">
                        <div class="card-header">
                            <strong>Información de la empresa</strong>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="company_name" class="form-label">Razón social</label>
                                <input type="text"
                                       name="company_name"
                                       id="company_name"
                                       class="form-control @error('company_name') is-invalid @enderror"
                                       value="{{ old('company_name', $vendor->company_name ?? '') }}">
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-sm-8">
                                    <label for="company_nit" class="form-label">NIT</label>
                                    <input type="text"
                                           name="company_nit"
                                           id="company_nit"
                                           class="form-control @error('company_nit') is-invalid @enderror"
                                           value="{{ old('company_nit', $vendor->company_nit ?? '') }}">
                                    @error('company_nit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="company_nit_dv" class="form-label">DV</label>
                                    <input type="text"
                                           name="company_nit_dv"
                                           id="company_nit_dv"
                                           class="form-control @error('company_nit_dv') is-invalid @enderror"
                                           value="{{ old('company_nit_dv', $vendor->company_nit_dv ?? '') }}">
                                    @error('company_nit_dv')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="legal_representative_name" class="form-label">
                                    Representante legal
                                </label>
                                <input type="text"
                                       name="legal_representative_name"
                                       id="legal_representative_name"
                                       class="form-control @error('legal_representative_name') is-invalid @enderror"
                                       value="{{ old('legal_representative_name', $vendor->legal_representative_name ?? '') }}">
                                @error('legal_representative_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label for="legal_representative_document_type" class="form-label">
                                        Tipo de documento
                                    </label>
                                    <select name="legal_representative_document_type"
                                            id="legal_representative_document_type"
                                            class="form-select @error('legal_representative_document_type') is-invalid @enderror">
                                        <option value="">Seleccione…</option>
                                        <option value="cc" {{ old('legal_representative_document_type', $vendor->legal_representative_document_type ?? '') === 'cc' ? 'selected' : '' }}>C.C.</option>
                                        <option value="ce" {{ old('legal_representative_document_type', $vendor->legal_representative_document_type ?? '') === 'ce' ? 'selected' : '' }}>C.E.</option>
                                        <option value="pp" {{ old('legal_representative_document_type', $vendor->legal_representative_document_type ?? '') === 'pp' ? 'selected' : '' }}>Pasaporte</option>
                                    </select>
                                    @error('legal_representative_document_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="legal_representative_document_number" class="form-label">
                                        Número de documento
                                    </label>
                                    <input type="text"
                                           name="legal_representative_document_number"
                                           id="legal_representative_document_number"
                                           class="form-control @error('legal_representative_document_number') is-invalid @enderror"
                                           value="{{ old('legal_representative_document_number', $vendor->legal_representative_document_number ?? '') }}">
                                    @error('legal_representative_document_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="legal_rut" class="form-label">RUT (PDF, máx. 5MB)</label>
                                <input type="file"
                                       name="legal_rut"
                                       id="legal_rut"
                                       class="form-control @error('legal_rut') is-invalid @enderror"
                                       accept="application/pdf">
                                @error('legal_rut')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="legal_chamber" class="form-label">Cámara de comercio (PDF, máx. 5MB)</label>
                                <input type="file"
                                       name="legal_chamber"
                                       id="legal_chamber"
                                       class="form-control @error('legal_chamber') is-invalid @enderror"
                                       accept="application/pdf">
                                @error('legal_chamber')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================
                 DATOS GENERALES / LOGO / ACCESO
            ========================= --}}
            <hr class="my-4">

            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $vendor->email) }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono (opcional)</label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $vendor->phone) }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror">
                            <option value="active"   {{ old('status', $vendor->status) === 'active' ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ old('status', $vendor->status) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            <option value="banned"   {{ old('status', $vendor->status) === 'banned' ? 'selected' : '' }}>Bloqueado</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="new-password">
                        <small class="text-muted">
                            Déjala vacía si no deseas cambiarla. Mínimo 8 caracteres y un símbolo.
                        </small>
                        @error('password')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               autocomplete="new-password">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Logo</label>
                        <input type="file"
                               name="profile_image"
                               id="profile_image"
                               class="form-control @error('profile_image') is-invalid @enderror"
                               accept="image/*">
                        @error('profile_image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">
                            JPG, PNG, WEBP · máximo 2MB · tamaño recomendado al menos 200×200 px.
                        </small>

                        <div class="mt-2">
                            <small class="d-block text-muted mb-1">Vista previa del logo:</small>
                            <img id="logo-preview"
                                 src="{{ $vendor->profile_image ? Storage::url($vendor->profile_image) : '' }}"
                                 alt="Logo"
                                 class="img-thumbnail"
                                 style="max-height:80px;object-fit:contain;background:#fff;{{ $vendor->profile_image ? '' : 'display:none;' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================
                 DESCRIPCIÓN
            ========================= --}}
            <hr class="my-4">

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $vendor->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- =========================
                 BANNERS / MEDIA EMPRESA
            ========================= --}}
            <div class="mb-3">
                <label for="banners" class="form-label">Banners (imágenes)</label>
                <input type="file"
                       name="banners[]"
                       id="banners"
                       class="form-control @error('banners.*') is-invalid @enderror"
                       accept="image/*"
                       multiple>
                @error('banners.*')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <small class="text-muted d-block mt-1">
                    Máx. 3 imágenes. Tamaño mínimo aprox: 1200×350 px. Se redimensionarán automáticamente en backend.
                </small>

                {{-- Vista de banners existentes --}}
                @if(!empty($existingBanners))
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        @foreach($existingBanners as $banner)
                            @php
                                $path = $banner['path'] ?? null;
                            @endphp
                            @if($path)
                                <img src="{{ Storage::url($path) }}"
                                     alt="Banner actual"
                                     class="img-thumbnail"
                                     style="height:70px;object-fit:cover;">
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="company_media" class="form-label">Imágenes / video de empresa</label>
                <input type="file"
                       name="company_media[]"
                       id="company_media"
                       class="form-control @error('company_media.*') is-invalid @enderror"
                       accept="image/*,video/mp4"
                       multiple>
                @error('company_media.*')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <small class="text-muted d-block mt-1">
                    Máx. 3 elementos. Se permite 1 video MP4 vertical (9:16, 1080×1920) y el resto imágenes.
                </small>

                {{-- Vista de media existente --}}
                @if(!empty($existingCompany))
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        @foreach($existingCompany as $item)
                            @php
                                $path = $item['path'] ?? null;

                                $isVideo = false;

                                if ($path) {
                                    // Quitar querystring si el path viene como URL completa
                                    $pathOnly = parse_url($path, PHP_URL_PATH);

                                    // Obtener extensión real
                                    $ext = strtolower(pathinfo($pathOnly, PATHINFO_EXTENSION));

                                    $isVideo = ($ext === 'mp4');
                                }
                            @endphp
                            @if($path)
                                <div style="width:120px;height:90px;overflow:hidden;border-radius:6px;">
                                    @if($isVideo)
                                         <video src="{{ Storage::url($path) }}"
                                            class="w-100 h-100"
                                            style="object-fit:cover;display:block;"
                                            muted
                                            autoplay
                                            loop
                                            playsinline
                                            controls>
                                        </video>
                                    @else
                                        <img src="{{ Storage::url($path) }}"
                                             class="w-100 h-100"
                                             style="object-fit:cover;">
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- =========================
                 PLANTILLA / PAGE TYPE
            ========================= --}}
            <hr class="my-4">

            @php
                $selectedPageType = old('page_type', $vendor->page_type ?? 'landing_1');
            @endphp

            <div class="mb-3">
                <label class="form-label d-block">Plantilla de página pública</label>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="page_type" id="page_type_1"
                                       value="landing_1" {{ $selectedPageType === 'landing_1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="page_type_1">
                                    Plantilla 1 – Landing clásica
                                </label>
                            </div>
                            <p class="small text-muted mb-2">Banner destacado, descripciones e imágenes laterales.</p>
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="openTemplatePreview('landing_1', {{ $vendor->id }})">
                                Vista previa
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="page_type" id="page_type_2"
                                       value="landing_2" {{ $selectedPageType === 'landing_2' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="page_type_2">
                                    Plantilla 2 – Enfoque en catálogo
                                </label>
                            </div>
                            <p class="small text-muted mb-2">Banner y descripción lado a lado.</p>
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="openTemplatePreview('landing_2', {{ $vendor->id }})">
                                Vista previa
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="page_type" id="page_type_3"
                                       value="landing_3" {{ $selectedPageType === 'landing_3' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="page_type_3">
                                    Plantilla 3 – Minimal / branding
                                </label>
                            </div>
                            <p class="small text-muted mb-2">Estilo más minimal / branding.</p>
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="openTemplatePreview('landing_3', {{ $vendor->id }})">
                                Vista previa
                            </button>
                        </div>
                    </div>
                </div>

                @error('page_type')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            {{-- =========================
                 PROVEEDOR DE FACTURACIÓN
            ========================= --}}
            <hr class="my-4">

            <div class="card mb-4">
                <div class="card-header">
                    <strong>Proveedor de facturación</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="billing_provider" class="form-label">
                                Sistema de facturación
                            </label>
                            <select name="billing_provider"
                                    id="billing_provider"
                                    class="form-select @error('billing_provider') is-invalid @enderror">
                                <option value="internal" {{ $billingProvider === 'internal' ? 'selected' : '' }}>
                                    Nuestro sistema de facturación
                                </option>
                                <option value="sigo" {{ $billingProvider === 'sigo' ? 'selected' : '' }}>
                                    Sigo
                                </option>
                                <option value="alegra" {{ $billingProvider === 'alegra' ? 'selected' : '' }}>
                                    Alegra
                                </option>
                                <option value="other" {{ $billingProvider === 'other' ? 'selected' : '' }}>
                                    Otro proveedor
                                </option>
                            </select>
                            @error('billing_provider')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 billing-extra d-none">
                            <label for="billing_user" class="form-label">
                                Usuario de facturación
                            </label>
                            <input type="text"
                                   name="billing_user"
                                   id="billing_user"
                                   class="form-control @error('billing_user') is-invalid @enderror"
                                   value="{{ $billingUser }}">
                            @error('billing_user')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 billing-extra d-none">
                            <label for="billing_notes" class="form-label">
                                Notas / parámetros adicionales
                            </label>
                            <textarea name="billing_notes"
                                      id="billing_notes"
                                      rows="2"
                                      class="form-control @error('billing_notes') is-invalid @enderror">{{ $billingNotes }}</textarea>
                            @error('billing_notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted">
                                Luego estos datos se podrán guardar como JSON para integraciones.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">

            <div class="mb-3 form-check">
                <input class="form-check-input"
                    type="checkbox"
                    value="1"
                    id="terms_accepted"
                    name="terms_accepted"
                    {{ old('terms_accepted', $vendor->terms_accepted ?? false) ? 'checked' : '' }}>

                <label class="form-check-label" for="terms_accepted">
                    He leído y acepto los términos y condiciones del contrato de proveedor.
                    <button type="button"
                            class="btn btn-link p-0 align-baseline"
                            id="btn-show-terms"
                            style="font-size: 0.9rem;">
                        Leer términos y condiciones
                    </button>
                </label>
            </div>

            {{-- BOTONES --}}
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Guardar cambios
                </button>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Modal de vista previa de plantilla --}}
<div class="modal fade" id="templatePreviewModal" tabindex="-1" aria-labelledby="templatePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templatePreviewModalLabel">Vista previa de plantilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="templatePreviewFrame"
                        src=""
                        style="border:0;width:100%;height:600px;"></iframe>
            </div>
        </div>
    </div>
</div>
@include('admin.vendors.partials.terms_informal')
@include('admin.vendors.partials.terms_natural')
@include('admin.vendors.partials.terms_juridica')
@endsection

@section('js')
<script>
     // --- Vista previa de plantillas ---
    function openTemplatePreview(pageType, vendorId) {
        let baseUrl = "{{ route('admin.vendors.template-preview', ['pageType' => 'PLACEHOLDER']) }}";
        baseUrl = baseUrl.replace('PLACEHOLDER', pageType);

        const params = new URLSearchParams();
        if (vendorId) {
            params.append('vendor_id', vendorId);
        }

        const url = params.toString() ? baseUrl + '?' + params.toString() : baseUrl;

        const frame = document.getElementById('templatePreviewFrame');
        frame.src = url;

        const modal = new bootstrap.Modal(document.getElementById('templatePreviewModal'));
        modal.show();
    }
    // --- Mostrar / ocultar bloque de persona jurídica ---
    function toggleVendorTypeBlocks() {
        const type = document.querySelector('input[name="vendor_type"]:checked')?.value || 'informal';
        const juridicaBlock = document.querySelector('.provider-block--juridica');
        if (juridicaBlock) {
            juridicaBlock.classList.toggle('d-none', type !== 'juridica');
        }
    }

    // --- Mostrar / ocultar campos extra de proveedor de facturación ---
    function toggleBillingProviderBlocks() {
        const select = document.getElementById('billing_provider');
        if (!select) return;
        const value = select.value;
        const extraBlocks = document.querySelectorAll('.billing-extra');
        const showExtras = value !== 'internal';
        extraBlocks.forEach(el => el.classList.toggle('d-none', !showExtras));
    }

    // --- Vista previa de logo ---
    function setupLogoPreview() {
        const input = document.getElementById('profile_image');
        const img   = document.getElementById('logo-preview');
        if (!input || !img) return;

        input.addEventListener('change', function () {
            if (!this.files || !this.files[0]) {
                if (!img.getAttribute('data-has-original')) {
                    img.style.display = 'none';
                    img.src = '';
                }
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        });
    }

    // --- Validación banners ---
    function setupBannerValidation() {
        const bannersInput = document.getElementById('banners');
        if (!bannersInput) return;

        bannersInput.addEventListener('change', function () {
            if (this.files.length > 3) {
                alert('Solo se permiten máximo 3 banners.');
                this.value = '';
            }
        });
    }

    // --- Validación media empresa ---
    function setupCompanyMediaValidation() {
        const input = document.getElementById('company_media');
        if (!input) return;

        input.addEventListener('change', function () {
            const files = Array.from(this.files);
            if (files.length > 3) {
                alert('Solo se permiten máximo 3 archivos de empresa.');
                this.value = '';
                return;
            }

            const videos = files.filter(f => f.type === 'video/mp4');
            if (videos.length > 1) {
                alert('Solo se permite 1 video MP4. El resto deben ser imágenes.');
                this.value = '';
            }
        });
    }

    // --- INIT ---
    document.addEventListener('DOMContentLoaded', function () {
        toggleVendorTypeBlocks();
        document.querySelectorAll('input[name="vendor_type"]').forEach(r =>
            r.addEventListener('change', toggleVendorTypeBlocks)
        );

        toggleBillingProviderBlocks();
        const billingSelect = document.getElementById('billing_provider');
        if (billingSelect) {
            billingSelect.addEventListener('change', toggleBillingProviderBlocks);
        }

        setupLogoPreview();
        setupBannerValidation();
        setupCompanyMediaValidation();
    });

     // ---- Utilidad: tipo actual de proveedor ----
        function getCurrentVendorType() {
            const checked = document.querySelector('input[name="vendor_type"]:checked');
            return checked ? checked.value : 'informal';
        }

        // ---- Actualizar datos dinámicos en los 3 modales ----
        function updateTermsPreview() {
            const nameInput      = document.getElementById('name');
            const brandInput     = document.getElementById('brand_name');
            const docInput       = document.getElementById('personal_document_number');
            const companyNameInp = document.getElementById('company_name');
            const repNameInput   = document.getElementById('legal_representative_name');

            const name        = nameInput      ? nameInput.value.trim()      : '';
            const brand       = brandInput     ? brandInput.value.trim()     : '';
            const doc         = docInput       ? docInput.value.trim()       : '';
            const companyName = companyNameInp ? companyNameInp.value.trim() : '';
            const repName     = repNameInput   ? repNameInput.value.trim()   : name;

            // Nombre de marca
            document.querySelectorAll('.tc-brand-name').forEach(el => {
                el.textContent = brand || '[Nombre de marca]';
            });

            // Nombre persona / representante
            document.querySelectorAll('.tc-person-name').forEach(el => {
                el.textContent = repName || name || '[Nombre completo]';
            });

            // Número de documento
            document.querySelectorAll('.tc-document-number').forEach(el => {
                el.textContent = doc || '[Documento]';
            });

            // Razón social
            document.querySelectorAll('.tc-company-name').forEach(el => {
                el.textContent = companyName || '[Razón social]';
            });
        }

        // ---- Abrir el modal correspondiente según vendor_type ----
        function openTermsModal() {
            updateTermsPreview();

            const type = getCurrentVendorType();
            let modalId = 'termsModalInformal';
            if (type === 'natural') {
                modalId = 'termsModalNatural';
            } else if (type === 'juridica') {
                modalId = 'termsModalJuridica';
            }

            const modalEl = document.getElementById(modalId);
            if (!modalEl) return;

            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.show();
        }

        // ---- INIT TÉRMINOS (llamar dentro de DOMContentLoaded) ----
        function setupTermsLogic() {
            const form          = document.getElementById('vendor-form');
            const termsCheckbox = document.getElementById('terms_accepted');
            const btnShowTerms  = document.getElementById('btn-show-terms');

            // Botón "Leer términos y condiciones"
            if (btnShowTerms) {
                btnShowTerms.addEventListener('click', function (e) {
                    e.preventDefault();
                    openTermsModal();
                });
            }

            // Interceptar envío si NO está marcado el checkbox
            if (form && termsCheckbox) {
                form.addEventListener('submit', function (e) {
                    if (termsCheckbox.checked) {
                        // ya aceptó, dejamos continuar
                        return;
                    }
                    // bloqueamos envío y abrimos el modal correspondiente
                    e.preventDefault();
                    openTermsModal();
                });
            }

            // Botones "Acepto los términos" dentro de cualquier modal
            const acceptButtons = document.querySelectorAll('.btn-accept-terms');
            acceptButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    // 1) marcar el checkbox
                    if (termsCheckbox) {
                        termsCheckbox.checked = true;
                    }

                    // 2) cerrar SOLO el modal actual
                    const modalEl = this.closest('.modal');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                    }

                    // 3) NO enviamos el formulario automáticamente.
                    //    El usuario luego pulsa Guardar / Registrar.
                });
            });
        }

     function validatePasswordOnSubmit(form) {
        const mode = form.dataset.mode || 'create'; // create | edit
        const passwordInput  = document.getElementById('password');
        const confirmInput   = document.getElementById('password_confirmation');
        const errorLabel     = document.getElementById('password-error-js');

        if (!passwordInput || !confirmInput || !errorLabel) {
            return true;
        }

        const password = (passwordInput.value || '').trim();
        const confirm  = (confirmInput.value || '').trim();
        const isCreate = mode === 'create';

        let errors = [];

        if (isCreate && password.length === 0) {
            errors.push('La contraseña es obligatoria.');
        }

        if (!isCreate && password.length === 0 && confirm.length === 0) {
            clearPasswordError();
            return true;
        }

        if (password.length > 0 && password.length < 8) {
            errors.push('Debe tener al menos 8 caracteres.');
        }

        if (password.length > 0 && !/[^\w]/.test(password)) {
            errors.push('Debe incluir al menos un símbolo (ej: ! @ # $ % &).');
        }

        if (password.length > 0 && password !== confirm) {
            errors.push('La confirmación de contraseña no coincide.');
        }

        if (errors.length > 0) {
            passwordInput.classList.add('is-invalid');
            confirmInput.classList.add('is-invalid');

            errorLabel.style.display = 'block';
            errorLabel.innerHTML = errors.join('<br>');

            return false;
        }

        clearPasswordError();
        return true;
    }    
    document.addEventListener('DOMContentLoaded', function () {
        // ... aquí ya tienes otras inicializaciones (vendorType, billing, etc.)

        const form = document.getElementById('vendor-form');
        const termsCheckbox = document.getElementById('terms_accepted');
        const btnShowTerms  = document.getElementById('btn-show-terms');
        const btnAccept     = document.getElementById('btn-accept-terms');

        if (btnShowTerms) {
            btnShowTerms.addEventListener('click', function (e) {
                e.preventDefault();
                openTermsModal();
            });
        }

       if (form) {
            form.addEventListener('submit', function (e) {
                const okPassword = validatePasswordOnSubmit(form);
                if (!okPassword) {
                    e.preventDefault();
                    return;
                }

                if (!termsCheckbox || termsCheckbox.checked) {
                    return; // ya aceptó
                }

                e.preventDefault();
                openTermsModal();
            });
        }

        if (btnAccept && form && termsCheckbox) {
            btnAccept.addEventListener('click', function () {
                termsCheckbox.checked = true;

                const modalEl = document.getElementById('termsModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }

                // En create NO enviamos el formulario automáticamente.
                // El usuario debe pulsar "Registrar" después de aceptar.
            });
        }
        setupTermsLogic(); 
    });
</script>
@endsection

