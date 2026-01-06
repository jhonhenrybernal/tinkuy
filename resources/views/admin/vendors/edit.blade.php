@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 dt-heading">{{ __('cms.vendors.edit_vendor') }}</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.vendors.update', $vendor->id) }}"
            method="POST"
            enctype="multipart/form-data"
            id="vendor-form"
            data-mode="edit">
            @csrf
            @method('PUT')

            <div class="row g-3">
                {{-- Columna izquierda: datos básicos --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('cms.vendors.vendor_name') }}</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $vendor->name) }}" maxlength="255">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('cms.vendors.vendor_email') }}</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $vendor->email) }}" maxlength="255">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('cms.vendors.phone_optional') }}</label>
                        <input type="text" name="phone" id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $vendor->phone) }}" maxlength="20">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('cms.vendors.status') }}</label>
                        <select name="status" id="status"
                                class="form-select @error('status') is-invalid @enderror">
                            <option value="active"   {{ old('status', $vendor->status)=='active' ? 'selected' : '' }}>{{ __('cms.vendors.active') }}</option>
                            <option value="inactive" {{ old('status', $vendor->status)=='inactive' ? 'selected' : '' }}>{{ __('cms.vendors.inactive') }}</option>
                            <option value="banned"   {{ old('status', $vendor->status)=='banned' ? 'selected' : '' }}>{{ __('cms.vendors.banned') }}</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Columna derecha: contraseña + logo --}}
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

                        {{-- Vista previa del logo (actual o nueva selección) --}}
                        <div class="mt-2">
                            <small class="d-block text-muted mb-1">Vista previa del logo:</small>
                            <img
                                id="logo-preview"
                                src="{{ $vendor->profile_image ? url('storage/'.$vendor->profile_image) : '' }}"
                                alt="Logo"
                                class="img-thumbnail"
                                style="width:80px;height:80px;object-fit:contain;background:#fff;{{ $vendor->profile_image ? '' : 'display:none;' }}"
                            >
                        </div>
                    </div>

                </div>
            </div>

            <hr class="my-4">

            {{-- Descripción --}}
            <div class="mb-3">
                <label for="description" class="form-label">{{ __('cms.vendors.description') }}</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $vendor->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            @php
                $companyMedia = $vendor->company_media ?? [];
                $existingBanners = '';
                if (is_array($companyMedia['banners'] ?? null)) {
                    $existingBanners = collect($companyMedia['banners'])
                        ->map(fn($item) => $item['path'] ?? '')
                        ->filter()
                        ->implode(', ');
                }

                $existingCompanyImages = '';
                if (is_array($companyMedia['company_images'] ?? null)) {
                    $existingCompanyImages = collect($companyMedia['company_images'])
                        ->map(fn($item) => $item['path'] ?? '')
                        ->filter()
                        ->implode(', ');
                }
            @endphp

           @php
                $companyMedia = $vendor->company_media ?? [];
                $existingBanners = $companyMedia['banners'] ?? [];
                $existingCompanyImages = $companyMedia['company_images'] ?? [];
            @endphp

          {{-- Banners --}}
            <div class="mb-3">
                <label for="banners" class="form-label">Banners (imágenes)</label>
                <input type="file"
                    name="banners_input[]"
                    id="banners"
                    class="form-control"
                    accept="image/*"
                    multiple>
                <small class="text-muted d-block mt-1">
                    Máx. 3 imágenes. Tamaño mínimo aprox: 1200×350 px. Se redimensionarán automáticamente a ~1400×450 px si son más grandes.
                </small>

                {{-- Preview de banners redimensionados --}}
                <div id="banners-preview" class="mt-2 d-flex flex-wrap gap-2">
                    @if(!empty($existingBanners))
                        @foreach($existingBanners as $item)
                            @php $path = $item['path'] ?? null; @endphp
                            @if($path)
                                <img src="{{ url('storage/'.$path) }}" alt="Banner actual"
     class="img-thumbnail" style="max-height:80px;">
                            @endif
                        @endforeach
                    @endif
                </div>

                {{-- Inputs hidden donde guardaremos los paths de las imágenes redimensionadas --}}
                <div id="banners-paths-container">
                    @if(!empty($existingBanners))
                        @foreach($existingBanners as $item)
                            @php $path = $item['path'] ?? null; @endphp
                            @if($path)
                                <input type="hidden" name="banners_paths[]" value="{{ $path }}">
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Imágenes de empresa --}}
            @php
                use Illuminate\Support\Str;

                $companyMedia = $vendor->company_media ?? [];
                $existingCompanyImages = $companyMedia['company_images'] ?? [];
            @endphp

            {{-- Imágenes de empresa / Video --}}
            <div class="mb-3">
                <label for="company_images" class="form-label">Imágenes de empresa / video</label>
                <input type="file"
                    name="company_images_input[]"
                    id="company_images"
                    class="form-control"
                    accept="image/*,video/mp4"
                    multiple>

                <small class="text-muted d-block mt-1">
                    Máx. 3 archivos.  
                    Opción A: 3 imágenes.  
                    Opción B: 2 imágenes + 1 video MP4 vertical (9:16, 1080×1920 px).
                </small>

                {{-- Preview de imágenes / video actuales --}}
                <div id="company-images-preview" class="mt-2 d-flex flex-wrap gap-2">
                    @foreach($existingCompanyImages as $item)
                        @php $path = $item['path'] ?? null; @endphp
                        @if($path)
                            @if(Str::endsWith(Str::lower($path), '.mp4'))
                                <video
                                    src="{{ url('storage/'.$path) }}"
                                    class="img-thumbnail"
                                    style="max-height:80px;"
                                    controls
                                    muted
                                ></video>
                            @else
                                <img
                                    src="{{ url('storage/'.$path) }}"
                                    alt="Imagen empresa actual"
                                    class="img-thumbnail"
                                    style="max-height:80px;"
                                >
                            @endif
                        @endif
                    @endforeach
                </div>

                {{-- Inputs hidden para paths (imágenes y/o video) --}}
                <div id="company-images-paths-container">
                    @foreach($existingCompanyImages as $item)
                        @php $path = $item['path'] ?? null; @endphp
                        @if($path)
                            <input type="hidden" name="company_images_paths[]" value="{{ $path }}">
                        @endif
                    @endforeach
                </div>
            </div>



            {{-- Tipo de página / plantilla --}}
            <div class="mb-3">
                <label class="form-label d-block">{{ __('cms.vendors.page_type') }}</label>

                @php
                    $selectedPageType = old('page_type', $vendor->page_type ?? 'landing_1');
                    $vendorIdForPreview = $vendor->id;
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
                                    onclick="openTemplatePreview('landing_1', '{{ $vendorIdForPreview }}')">
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
                                    onclick="openTemplatePreview('landing_2', '{{ $vendorIdForPreview }}')">
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
                                    onclick="openTemplatePreview('landing_3', '{{ $vendorIdForPreview }}')">
                                Vista previa
                            </button>
                        </div>
                    </div>
                </div>

                @error('page_type')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('cms.vendors.save_changes') }}
                </button>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                    {{ __('cms.vendors.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Modal de vista previa --}}
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

    function showImageError(message) {
        if (window.toastr) {
            toastr.error(message);
        } else {
            alert(message);
        }
    }

    /**
     * Logo preview + validación tamaño mínimo
     * - Si es muy pequeño, se muestra mensaje y se limpia el input.
     * - Si es suficientemente grande, se muestra en 80x80 (object-fit: contain).
     */
    function setupLogoPreview() {
        const input = document.getElementById('profile_image');
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

                    // OK: mostramos vista previa
                    preview.src = e.target.result;
                    preview.style.display = 'inline-block';
                };
                img.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    }

    /**
     * Sube archivos al backend para redimensionar (imágenes) y guardar (video),
     * y devuelve paths + preview.
     *
     * Para type = 'banner' -> solo imágenes.
     * Para type = 'company' -> 3 imágenes o 2 imágenes + 1 video MP4 (9:16 1080x1920).
     */
    function setupRemoteResize(inputId, type, previewContainerId, hiddenContainerId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const hiddenContainer = document.getElementById(hiddenContainerId);

        if (!input) return;

        input.addEventListener('change', async function () {
            const files = Array.from(this.files);
            if (files.length === 0) return;

            const existing = getExistingMediaStats(hiddenContainer); // 👈 ya guardados

            try {
                if (type === 'banner') {
                    // SOLO IMÁGENES, máx 3 en total
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
                    // IMÁGENES + VIDEO
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

                    // Máx 3 archivos en total
                    if (existing.total + files.length > 3) {
                        showImageError(
                            `Máximo 3 archivos en Imágenes de empresa. Ya tienes ${existing.total} y estás intentando subir ${files.length} más.`
                        );
                        this.value = '';
                        return;
                    }

                    // Máx 1 video en total
                    if (totalVideos > 1) {
                        showImageError('Solo se permite un (1) video MP4 en Imágenes de empresa.');
                        this.value = '';
                        return;
                    }

                    if (totalVideos === 0) {
                        // Solo imágenes en total: máx 3
                        if (totalImages > 3) {
                            showImageError('Máximo 3 imágenes en Imágenes de empresa.');
                            this.value = '';
                            return;
                        }
                    } else {
                        // Hay 1 video en total: máx 2 imágenes
                        if (totalImages > 2) {
                            showImageError('Si tienes un video, solo puedes tener hasta 2 imágenes.');
                            this.value = '';
                            return;
                        }
                    }

                    // Si viene un nuevo video, validar orientación 1080x1920
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

                // --- Si llegamos aquí, la combinación es válida ---
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

                // 👇 YA NO LIMPIAMOS LO EXISTENTE; SOLO AGREGAMOS LO NUEVO

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



    document.addEventListener('DOMContentLoaded', function () {
        // Logo
        setupLogoPreview();

        // Banners
        setupRemoteResize('banners', 'banner', 'banners-preview', 'banners-paths-container');

        // Imágenes de empresa
        setupRemoteResize('company_images', 'company', 'company-images-preview', 'company-images-paths-container');
        const form = document.getElementById('vendor-form');
        if (form) {
            form.addEventListener('submit', function (e) {
                const ok = validatePasswordOnSubmit(form);
                if (!ok) {
                    e.preventDefault(); 
                }
            });
        }
    });

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
    function validatePasswordOnSubmit(form) {
        const mode = form.dataset.mode || 'create'; // create | edit
        const passwordInput  = document.getElementById('password');
        const confirmInput   = document.getElementById('password_confirmation');
        const errorLabel     = document.getElementById('password-error-js');

        if (!passwordInput || !confirmInput || !errorLabel) {
            return true; // nada que validar
        }

        const password = (passwordInput.value || '').trim();
        const confirm  = (confirmInput.value || '').trim();
        const isCreate = mode === 'create';

        let errors = [];

        // 1) requerido en create
        if (isCreate && password.length === 0) {
            errors.push('La contraseña es obligatoria.');
        }

        // En edit: si ambos están vacíos, NO validamos nada (coincide con nullable)
        if (!isCreate && password.length === 0 && confirm.length === 0) {
            clearPasswordError();
            return true;
        }

        // 2) mínimo 8 caracteres si hay algo
        if (password.length > 0 && password.length < 8) {
            errors.push('Debe tener al menos 8 caracteres.');
        }

        // 3) al menos 1 símbolo (no letra ni número)
        if (password.length > 0 && !/[^\w]/.test(password)) {
            errors.push('Debe incluir al menos un símbolo (ej: ! @ # $ % &).');
        }

        // 4) confirmación
        if (password.length > 0 && password !== confirm) {
            errors.push('La confirmación de contraseña no coincide.');
        }

        if (errors.length > 0) {
            passwordInput.classList.add('is-invalid');
            confirmInput.classList.add('is-invalid');

            errorLabel.style.display = 'block';
            errorLabel.innerHTML = errors.join('<br>');

            return false; // ❌ bloqueamos el submit
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
</script>
@endsection
