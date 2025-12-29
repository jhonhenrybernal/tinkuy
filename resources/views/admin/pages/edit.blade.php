@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6>{{ __('cms.pages.edit') }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                    @php
                        $translation = $page->translations->firstWhere('language_code', $language->code);
                    @endphp

                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $language->code }}">
                        <div class="mb-3">
                            <label class="form-label">{{ __('cms.pages.form_title', ['code' => $language->code]) }}</label>
                            <input type="text" name="translations[{{ $language->code }}][title]" 
                                   class="form-control" 
                                   value="{{ old("translations.{$language->code}.title", $translation?->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('cms.pages.form_content', ['code' => $language->code]) }}</label>
                            <textarea name="translations[{{ $language->code }}][content]" 
                                      class="form-control ck-editor-multi-languages">
                                {{ old("translations.{$language->code}.content", $translation?->content) }}
                            </textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label mt-2">{{ __('cms.pages.form_image', ['code' => $language->code]) }}</label>
                            <div class="custom-file">
                                <label class="btn btn-primary" for="image_file_{{ $language->code }}">{{ __('cms.pages.choose_file') }}</label>
                                <input type="file"
                                       name="translations[{{ $language->code }}][image]"
                                       accept="image/*"
                                       class="form-control d-none @error("translations.$language->code.image") is-invalid @enderror"
                                       id="image_file_{{ $language->code }}"
                                       onchange="previewImage('{{ $language->code }}')">
                            </div>

                            <div class="mt-2" id="image_preview_{{ $language->code }}" style="display:{{ $translation && $translation->image_url ? 'block' : 'none' }};">
                                <img id="image_preview_img_{{ $language->code }}"
                                     src="{{ $translation && $translation->image_url ? Storage::url($translation->image_url) : '#' }}"
                                     alt="{{ __('cms.pages.form_image', ['code' => $language->code]) }}"
                                     class="img-thumbnail" style="max-width: 200px;">
                            </div>

                            @error("translations.$language->code.image")
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">{{ __('cms.pages.form_update') }}</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.querySelectorAll('.ck-editor-multi-languages').forEach(el => {
        ClassicEditor.create(el).catch(console.error);
    });

    function previewImage(code) {
        const input = document.getElementById('image_file_' + code);
        const previewDiv = document.getElementById('image_preview_' + code);
        const previewImg = document.getElementById('image_preview_img_' + code);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewDiv.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
