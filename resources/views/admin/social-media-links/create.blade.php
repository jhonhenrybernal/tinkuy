@extends('admin.layouts.admin')

@section('title', 'Create Social Media Link')

@section('content')
    <div class="container mt-4">
        <!-- Card Structure -->
        <div class="card">
            <div class="card-header card-header-bg text-white">
                <h6>{{ __('cms.social_media_links.create') }}</h6>
            </div>
            <div class="card-body">
               
                <!-- Social Media Link Form -->
                <form action="{{ route('admin.social-media-links.store') }}" method="POST">
                    @csrf

                    <!-- Social Media Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label">{{ __('cms.social_media_links.type') }}</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>
                                {{ __('cms.social_media_links.select_type') }}
                            </option>
                            <option value="facebook" {{ old('type') == 'facebook' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.facebook') }}</option>
                            <option value="instagram" {{ old('type') == 'instagram' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.instagram') }}</option>
                            <option value="tiktok" {{ old('type') == 'tiktok' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.tiktok') }}</option>
                            <option value="youtube" {{ old('type') == 'youtube' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.youtube') }}</option>
                            <option value="x" {{ old('type') == 'x' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.x') }}</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Platform Name -->
                    <div class="mb-3">
                        <label for="platform" class="form-label">{{ __('cms.social_media_links.platform') }}</label>
                        <input 
                            type="text" 
                            name="platform" 
                            id="platform" 
                            value="{{ old('platform') }}"
                            class="form-control @error('platform') is-invalid @enderror">
                        @error('platform') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Social Media Link -->
                    <div class="mb-3">
                        <label for="link" class="form-label">{{ __('cms.social_media_links.link') }}</label>
                        <input 
                            type="url" 
                            name="link" 
                            id="link" 
                            value="{{ old('link') }}"
                            class="form-control @error('link') is-invalid @enderror">
                        @error('link') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Translations Section -->
                    <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                        @foreach ($languages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        id="{{ $language->code }}-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#{{ $language->code }}" 
                                        type="button" role="tab">
                                    {{ ucwords($language->name) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-3" id="languageTabContent">
                        @foreach ($languages as $language)
                            <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}" role="tabpanel">
                                <label class="form-label">
                                    {{ __('cms.social_media_links.translations.platform_name') }} ({{ $language->name }})
                                </label>
                                <input 
                                    type="text" 
                                    name="languages[{{ $language->code }}][name]" 
                                    value="{{ old("languages.{$language->code}.name") }}"
                                    class="form-control @error("languages.{$language->code}.name") is-invalid @enderror">
                                @error("languages.{$language->code}.name")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success mt-3">{{ __('cms.social_media_links.save') }}</button>
                </form>
            </div>
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
@endsection