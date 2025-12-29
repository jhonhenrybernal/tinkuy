@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6>{{ __('cms.pages.create') }}</h6>
    </div>

    <div class="card-body">
        <form id="pageForm" action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Language Tabs --}}
            <ul class="nav nav-tabs" role="tablist">
                @foreach($activeLanguages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                data-bs-toggle="tab" 
                                data-bs-target="#lang-{{ $language->code }}" 
                                type="button">
                            {{ ucwords($language->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content mt-3">
                @foreach($activeLanguages as $language)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $language->code }}">

                        {{-- Title --}}
                        <div class="mb-3">
                            <label class="form-label">{{ __('cms.pages.form_title', ['code' => $language->code]) }}</label>
                            <input 
                                type="text" 
                                name="translations[{{ $language->code }}][title]" 
                                value="{{ old('translations.'.$language->code.'.title') }}" 
                                class="form-control @error('translations.'.$language->code.'.title') is-invalid @enderror"
                            >
                            @error('translations.'.$language->code.'.title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Content --}}
                        <div class="mb-3">
                            <label class="form-label">{{ __('cms.pages.form_content', ['code' => $language->code]) }}</label>
                            <textarea 
                                id="content_{{ $language->code }}"
                                name="translations[{{ $language->code }}][content]" 
                                class="form-control ck-editor-multi-languages @error('translations.'.$language->code.'.content') is-invalid @enderror"
                            >{{ old('translations.'.$language->code.'.content') }}</textarea>
                            @error('translations.'.$language->code.'.content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image_file_{{ $language->code }}" class="form-label">
                                {{ __('cms.pages.form_image', ['code' => $language->code]) }}
                            </label>
                            <div class="custom-file">
                                <label class="btn btn-primary" for="image_file_{{ $language->code }}">
                                    {{ __('cms.pages.choose_file') }}
                                </label>
                                <input type="file"
                                    id="image_file_{{ $language->code }}"
                                    name="translations[{{ $language->code }}][image]"
                                    accept="image/*"
                                    class="form-control d-none @error('translations.'.$language->code.'.image') is-invalid @enderror"
                                    onchange="previewImage(this, '{{ $language->code }}')">
                            </div>

                            {{-- Hidden base64 --}}
                            <input type="hidden"
                                   id="image_base64_{{ $language->code }}"
                                   name="translations[{{ $language->code }}][image_base64]"
                                   value="{{ old('translations.'.$language->code.'.image_base64') }}">

                            {{-- Preview --}}
                            <div class="mt-2" id="image_preview_{{ $language->code }}" 
                                 style="{{ old('translations.'.$language->code.'.image_base64') ? '' : 'display:none;' }}">
                                <img id="image_preview_img_{{ $language->code }}" 
                                     src="{{ old('translations.'.$language->code.'.image_base64') ?: '#' }}" 
                                     alt="{{ __('cms.pages.form_image', ['code' => $language->code]) }}" 
                                     class="img-thumbnail" style="max-width:200px;">
                            </div>

                            @error('translations.'.$language->code.'.image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">{{ __('cms.pages.form_save') }}</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    @if ($errors->any())
        var firstErrorElement = document.querySelector('.is-invalid');
        if (firstErrorElement) {
            var tabPane = firstErrorElement.closest('.tab-pane');
            if (tabPane) {
                var tabId = tabPane.getAttribute('id');
                var triggerEl = document.querySelector(`button[data-bs-target="#${tabId}"]`);
                if (triggerEl) {
                    var tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }
        }
    @endif
});
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    const LANG_CODES = {!! json_encode($activeLanguages->pluck('code')) !!};
    const CKEDITORS = {};

    document.querySelectorAll('.ck-editor-multi-languages').forEach((el) => {
        const id = el.id;
        ClassicEditor.create(el)
            .then(editor => { CKEDITORS[id] = editor; })
            .catch(error => { console.error('CKEditor init error', error); });
    });

    function previewImage(input, langCode) {
        var file = input.files[0];
        var previewElement = document.getElementById('image_preview_' + langCode);
        var previewImage = document.getElementById('image_preview_img_' + langCode);
        var hiddenInput = document.getElementById('image_base64_' + langCode);

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewElement.style.display = 'block';
                previewImage.src = e.target.result;
                hiddenInput.value = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            previewElement.style.display = 'none';
            previewImage.src = '';
            hiddenInput.value = '';
        }
    }

    function base64ToFile(dataurl, baseName) {
        if (!dataurl || dataurl.indexOf(',') === -1) return null;
        var arr = dataurl.split(',');
        var mimeMatch = arr[0].match(/data:(.*);base64/);
        if (!mimeMatch) return null;
        var mime = mimeMatch[1];
        var ext = mime.split('/')[1].split('+')[0];
        if (ext === 'jpeg') ext = 'jpg';
        var bstr = atob(arr[1]);
        var n = bstr.length;
        var u8arr = new Uint8Array(n);
        for (var i = 0; i < n; i++) {
            u8arr[i] = bstr.charCodeAt(i);
        }
        var filename = baseName + '.' + ext;
        return new File([u8arr], filename, { type: mime });
    }

    document.getElementById('pageForm').addEventListener('submit', function (e) {
        for (const code of LANG_CODES) {
            const textareaId = 'content_' + code;
            const editor = CKEDITORS[textareaId];
            if (editor) {
                const textarea = document.getElementById(textareaId);
                if (textarea) textarea.value = editor.getData();
            }
        }

        for (const code of LANG_CODES) {
            const fileInput = document.getElementById('image_file_' + code);
            const base64Input = document.getElementById('image_base64_' + code);

            if (fileInput && fileInput.files.length === 0 && base64Input && base64Input.value) {
                try {
                    const f = base64ToFile(base64Input.value, 'image_' + code);
                    if (f) {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(f);
                        fileInput.files = dataTransfer.files;
                    }
                } catch (err) {
                    console.error('base64 -> File conversion failed for', code, err);
                }
            }
        }
    });
</script>
@endsection
