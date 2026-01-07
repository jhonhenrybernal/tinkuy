@extends('admin.layouts.admin')

@section('content')
@php
    $vendorType      = old('vendor_type', 'informal');
    $billingProvider = old('billing_provider', 'internal');
    $billingUser     = old('billing_user', '');
    $billingNotes    = old('billing_notes', '');
@endphp

<div class="card mt-4">
    <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 dt-heading">{{ __('cms.vendors.register_new_vendor') }}</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.vendors.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="vendor-form"
              data-mode="create">
            @csrf

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
                                       value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Nombre de marca --}}
                            <div class="mb-3">
                                <label for="brand_name" class="form-label">Nombre de la marca / nombre comercial</label>
                                <input type="text"
                                       name="brand_name"
                                       id="brand_name"
                                       class="form-control @error('brand_name') is-invalid @enderror"
                                       value="{{ old('brand_name') }}">
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
                                        <option value="cc" {{ old('personal_document_type') === 'cc' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                                        <option value="ce" {{ old('personal_document_type') === 'ce' ? 'selected' : '' }}>Cédula de extranjería</option>
                                        <option value="pp" {{ old('personal_document_type') === 'pp' ? 'selected' : '' }}>Pasaporte</option>
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
                                           value="{{ old('personal_document_number') }}">
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
                                       value="{{ old('city') }}">
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
                                       value="{{ old('company_name') }}">
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
                                           value="{{ old('company_nit') }}">
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
                                           value="{{ old('company_nit_dv') }}">
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
                                       value="{{ old('legal_representative_name') }}">
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
                                        <option value="cc" {{ old('legal_representative_document_type') === 'cc' ? 'selected' : '' }}>C.C.</option>
                                        <option value="ce" {{ old('legal_representative_document_type') === 'ce' ? 'selected' : '' }}>C.E.</option>
                                        <option value="pp" {{ old('legal_representative_document_type') === 'pp' ? 'selected' : '' }}>Pasaporte</option>
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
                                           value="{{ old('legal_representative_document_number') }}">
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
                        <label for="email" class="form-label">{{ __('cms.vendors.vendor_email') }}</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" maxlength="255">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('cms.vendors.phone_optional') }}</label>
                        <input type="text" name="phone" id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}" maxlength="20">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('cms.vendors.status') }}</label>
                        <select name="status" id="status"
                                class="form-select @error('status') is-invalid @enderror">
                            <option value="active"   {{ old('status','active')=='active' ? 'selected' : '' }}>{{ __('cms.vendors.active') }}</option>
                            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>{{ __('cms.vendors.inactive') }}</option>
                            <option value="banned"   {{ old('status')=='banned' ? 'selected' : '' }}>{{ __('cms.vendors.banned') }}</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- contraseña + logo --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('cms.vendors.password') }}</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="new-password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <div id="password-rules" class="form-text mt-1">
                            La contraseña debe tener al menos <strong>8 caracteres</strong> y
                            <strong>1 símbolo</strong> (ej: ! @ # $ % &).
                        </div>
                        <small id="password-error-js" class="text-danger d-block" style="display:none;"></small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('cms.vendors.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               autocomplete="new-password">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profile_image" class="form-label">{{ __('cms.vendors.logo') }}</label>
                        <input type="file" name="profile_image" id="profile_image"
                               class="form-control @error('profile_image') is-invalid @enderror"
                               accept="image/*">
                        @error('profile_image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">
                            JPG, PNG, WEBP · máximo 2MB. Tamaño recomendado: al menos 200×200 px.
                        </small>

                        <div class="mt-2">
                            <small class="d-block text-muted mb-1">Vista previa del logo:</small>
                            <img
                                id="logo-preview"
                                src=""
                                alt="Logo"
                                class="img-thumbnail"
                                style="width:80px;height:80px;object-fit:contain;background:#fff;display:none;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================
                 DESCRIPCIÓN
            ========================= --}}
            <hr class="my-4">

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('cms.vendors.description') }}</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            @php
                $existingBanners = [];
                $existingCompanyImages = [];
            @endphp

            {{-- Banners --}}
            <div class="mb-3">
                <label for="banners" class="form-label">Banners (imágenes)</label>
                <input type="file"
                       name="banners_input[]"
                       id="banners"
                       class="form-control @error('banners.*') is-invalid @enderror"
                       accept="image/*"
                       multiple>
                @error('banners.*')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <small class="text-muted d-block mt-1">
                    Máx. 3 imágenes. Tamaño mínimo aprox: 1200×350 px.
                    Se redimensionarán automáticamente a ~1400×450 px si son más grandes.
                </small>

                <div id="banners-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                <div id="banners-paths-container"></div>
            </div>

            {{-- Imágenes / video de empresa --}}
            <div class="mb-3">
                <label for="company_images" class="form-label">Imágenes / video de empresa</label>
                <input type="file"
                       name="company_images_input[]"
                       id="company_images"
                       class="form-control @error('company_images.*') is-invalid @enderror"
                       accept="image/*,video/mp4"
                       multiple>
                @error('company_images.*')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <small class="text-muted d-block mt-1">
                    Máx. 3 archivos.  
                    Opción A: 3 imágenes.  
                    Opción B: 2 imágenes + 1 video MP4 vertical (9:16, 1080×1920 px).
                </small>

                <div id="company-images-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                <div id="company-images-paths-container"></div>
            </div>

            {{-- Tipo de página / plantilla --}}
            <hr class="my-4">

            <div class="mb-3">
                <label class="form-label d-block">{{ __('cms.vendors.page_type') }}</label>

                @php
                    $selectedPageType = old('page_type', 'landing_1');
                @endphp

                <div class="row g-3">
                    {{-- Plantilla 1 --}}
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="page_type" id="page_type_1"
                                       value="landing_1" {{ $selectedPageType === 'landing_1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="page_type_1">
                                    {{ __('cms.vendors.page_type_landing_1') }}
                                </label>
                            </div>
                            <p class="small text-muted mb-2">Banner grande, descripción + imágenes laterales.</p>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="openTemplatePreview('landing_1', null)">
                                Vista previa
                            </button>
                        </div>
                    </div>

                    {{-- Plantilla 2 --}}
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="page_type" id="page_type_2"
                                       value="landing_2" {{ $selectedPageType === 'landing_2' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="page_type_2">
                                    {{ __('cms.vendors.page_type_landing_2') }}
                                </label>
                            </div>
                            <p class="small text-muted mb-2">Banner y descripción lado a lado.</p>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="openTemplatePreview('landing_2', null)">
                                Vista previa
                            </button>
                        </div>
                    </div>

                    {{-- Plantilla 3 --}}
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="page_type" id="page_type_3"
                                       value="landing_3" {{ $selectedPageType === 'landing_3' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="page_type_3">
                                    {{ __('cms.vendors.page_type_landing_3') }}
                                </label>
                            </div>
                            <p class="small text-muted mb-2">Estilo más minimal / branding.</p>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="openTemplatePreview('landing_3', null)">
                                Vista previa
                            </button>
                        </div>
                    </div>
                </div>

                @error('page_type')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            {{-- PROVEEDOR DE FACTURACIÓN --}}
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

            {{-- TÉRMINOS Y CONDICIONES --}}
            <hr class="my-4">

            <div class="mb-3 form-check">
                <input class="form-check-input"
                       type="checkbox"
                       value="1"
                       id="terms_accepted"
                       name="terms_accepted"
                       {{ old('terms_accepted') ? 'checked' : '' }}>

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
                <button type="submit" class="btn btn-success">
                    {{ __('cms.vendors.register_button') }}
                </button>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                    {{ __('cms.vendors.cancel_button') }}
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

{{-- Modal de términos (mismo partial que en edit) --}}
@include('admin.vendors.partials.terms_informal')
@include('admin.vendors.partials.terms_natural')
@include('admin.vendors.partials.terms_juridica')
@endsection

@section('js')
<script>
    // -----------------------------
    // HELPERS GENERALES
    // -----------------------------
    function showImageError(message) {
        if (window.toastr) {
            toastr.error(message);
        } else {
            alert(message);
        }
    }

    // Vista previa de plantillas
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

    // Vista previa de logo + validación mínima
    function setupLogoPreview() {
        const input   = document.getElementById('profile_image');
        const preview = document.getElementById('logo-preview');
        if (!input || !preview) return;

        const MIN_WIDTH  = 200;
        const MIN_HEIGHT = 200;

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            const img = new Image();

            reader.onload = function (e) {
                img.onload = function () {
                    const w = img.width;
                    const h = img.height;

                    if (w < MIN_WIDTH || h < MIN_HEIGHT) {
                        showImageError(
                            `El logo es demasiado pequeño (${w}×${h} px). ` +
                            `Se recomienda al menos ${MIN_WIDTH}×${MIN_HEIGHT} px.`
                        );
                        input.value = '';
                        return;
                    }

                    preview.src = e.target.result;
                    preview.style.display = 'inline-block';
                };
                img.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    }

    // Dimensiones de video
    function getVideoDimensions(file) {
        return new Promise((resolve, reject) => {
            const url = URL.createObjectURL(file);
            const video = document.createElement('video');

            video.preload = 'metadata';
            video.onloadedmetadata = function () {
                URL.revokeObjectURL(url);
                resolve({
                    width:  video.videoWidth,
                    height: video.videoHeight,
                });
            };
            video.onerror = function () {
                URL.revokeObjectURL(url);
                reject(new Error('No se pudo leer el video'));
            };

            video.src = url;
        });
    }

    function getExistingMediaStats(hiddenContainer) {
        const hiddenInputs = hiddenContainer.querySelectorAll('input[type="hidden"]');
        let images = 0;
        let videos = 0;

        hiddenInputs.forEach(input => {
            const value = (input.value || '').toLowerCase();
            if (value.endsWith('.mp4')) {
                videos++;
            } else {
                images++;
            }
        });

        return {
            images,
            videos,
            total: hiddenInputs.length,
        };
    }

    function setupRemoteResize(inputId, type, previewContainerId, hiddenContainerId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const hiddenContainer  = document.getElementById(hiddenContainerId);

        if (!input) return;

        input.addEventListener('change', async function () {
            const files = Array.from(this.files);
            if (files.length === 0) return;

            const existing = getExistingMediaStats(hiddenContainer);

            try {
                if (type === 'banner') {
                    if (existing.total + files.length > 3) {
                        showImageError(
                            `Máximo 3 banners. Ya tienes ${existing.total} y estás intentando subir ${files.length} más.`
                        );
                        this.value = '';
                        return;
                    }

                    const hasNonImage = files.some(f => !f.type.startsWith('image/'));
                    if (hasNonImage) {
                        showImageError('Solo se permiten imágenes en los banners.');
                        this.value = '';
                        return;
                    }

                } else if (type === 'company') {
                    const newImages = files.filter(f => f.type.startsWith('image/'));
                    const newVideos = files.filter(f => f.type === 'video/mp4');
                    const others = files.filter(
                        f => !f.type.startsWith('image/') && f.type !== 'video/mp4'
                    );

                    if (others.length > 0) {
                        showImageError('Solo se permiten imágenes y videos MP4 en Imágenes de empresa.');
                        this.value = '';
                        return;
                    }

                    const totalImages = existing.images + newImages.length;
                    const totalVideos = existing.videos + newVideos.length;

                    if (existing.total + files.length > 3) {
                        showImageError(
                            `Máximo 3 archivos en Imágenes de empresa. Ya tienes ${existing.total} y estás intentando subir ${files.length} más.`
                        );
                        this.value = '';
                        return;
                    }

                    if (totalVideos > 1) {
                        showImageError('Solo se permite un (1) video MP4 en Imágenes de empresa.');
                        this.value = '';
                        return;
                    }

                    if (totalVideos === 0) {
                        if (totalImages > 3) {
                            showImageError('Máximo 3 imágenes en Imágenes de empresa.');
                            this.value = '';
                            return;
                        }
                    } else {
                        if (totalImages > 2) {
                            showImageError('Si tienes un video, solo puedes tener hasta 2 imágenes.');
                            this.value = '';
                            return;
                        }
                    }

                    if (newVideos.length > 0) {
                        const videoFile = newVideos[0];
                        const dims = await getVideoDimensions(videoFile);
                        const w = dims.width;
                        const h = dims.height;

                        if (!(w === 1080 && h === 1920)) {
                            showImageError(
                                `El video debe ser vertical 9:16 (1080×1920 px). ` +
                                `El archivo seleccionado es de ${w}×${h} px.`
                            );
                            this.value = '';
                            return;
                        }
                    }
                }

                const formData = new FormData();
                formData.append('type', type);
                files.forEach(file => formData.append('media[]', file));

                const response = await fetch("{{ route('admin.vendors.resize-media') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                });

                const data = await response.json();

                if (!data.success) {
                    if (Array.isArray(data.errors)) {
                        data.errors.forEach(msg => showImageError(msg));
                    } else {
                        showImageError('Los archivos no son válidos.');
                    }
                    this.value = '';
                    return;
                }

                if (Array.isArray(data.errors) && data.errors.length > 0) {
                    data.errors.forEach(msg => showImageError(msg));
                }

                data.items.forEach(item => {
                    const kind = item.kind || 'image';

                    if (kind === 'video') {
                        const vid = document.createElement('video');
                        vid.src = item.url;
                        vid.className = 'img-thumbnail';
                        vid.style.maxHeight = '80px';
                        vid.controls = true;
                        vid.muted = true;
                        previewContainer.appendChild(vid);
                    } else {
                        const img = document.createElement('img');
                        img.src = item.url;
                        img.alt = type === 'banner' ? 'Banner' : 'Imagen empresa';
                        img.className = 'img-thumbnail';
                        img.style.maxHeight = '80px';
                        previewContainer.appendChild(img);
                    }

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = type === 'banner'
                        ? 'banners_paths[]'
                        : 'company_images_paths[]';
                    hidden.value = item.path;
                    hiddenContainer.appendChild(hidden);
                });

                this.value = '';
            } catch (e) {
                console.error(e);
                showImageError('Error subiendo / procesando los archivos.');
                this.value = '';
            }
        });
    }

    // -----------------------------
    // TIPO PROVEEDOR / BILLING
    // -----------------------------
    function toggleVendorTypeBlocks() {
        const type = document.querySelector('input[name="vendor_type"]:checked')?.value || 'informal';
        const juridicaBlock = document.querySelector('.provider-block--juridica');
        if (juridicaBlock) {
            juridicaBlock.classList.toggle('d-none', type !== 'juridica');
        }
    }

    function toggleBillingProviderBlocks() {
        const select = document.getElementById('billing_provider');
        if (!select) return;
        const value = select.value;
        const extraBlocks = document.querySelectorAll('.billing-extra');
        const showExtras = value !== 'internal';
        extraBlocks.forEach(el => el.classList.toggle('d-none', !showExtras));
    }

    // -----------------------------
    // VALIDACIÓN DE CONTRASEÑA
    // -----------------------------
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

    function clearPasswordError() {
        const passwordInput  = document.getElementById('password');
        const confirmInput   = document.getElementById('password_confirmation');
        const errorLabel     = document.getElementById('password-error-js');

        if (passwordInput)  passwordInput.classList.remove('is-invalid');
        if (confirmInput)   confirmInput.classList.remove('is-invalid');
        if (errorLabel) {
            errorLabel.style.display = 'none';
            errorLabel.innerHTML = '';
        }
    }

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


    // -----------------------------
    // INIT
    // -----------------------------
    document.addEventListener('DOMContentLoaded', function () {
        setupLogoPreview();

        setupRemoteResize('banners', 'banner', 'banners-preview', 'banners-paths-container');
        setupRemoteResize('company_images', 'company', 'company-images-preview', 'company-images-paths-container');

        toggleVendorTypeBlocks();
        document.querySelectorAll('input[name="vendor_type"]').forEach(r =>
            r.addEventListener('change', toggleVendorTypeBlocks)
        );

        toggleBillingProviderBlocks();
        const billingSelect = document.getElementById('billing_provider');
        if (billingSelect) {
            billingSelect.addEventListener('change', toggleBillingProviderBlocks);
        }

        const form          = document.getElementById('vendor-form');
        const termsCheckbox = document.getElementById('terms_accepted');
        const btnShowTerms  = document.getElementById('btn-show-terms');
        const btnAccept     = document.getElementById('btn-accept-terms');

        if (btnShowTerms) {
            btnShowTerms.addEventListener('click', function (e) {
                e.preventDefault();
                openTermsModal();
            });
        }

          if (form && termsCheckbox) {
            form.addEventListener('submit', function (e) {
                // Si ya está marcado, dejamos pasar
                if (termsCheckbox.checked) return;

                // Si NO está marcado, bloqueamos envío y mostramos modal
                e.preventDefault();
                showTermsModal();
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
