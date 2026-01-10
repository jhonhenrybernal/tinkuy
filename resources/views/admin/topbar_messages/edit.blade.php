@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="mb-0 dt-heading">{{ __('cms.topbar_messages.edit') ?? 'Edit' }}</h6>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.topbar_messages.update', $message->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">
                    {{ __('cms.topbar_messages.title') }} ({{ __('cms.optional') ?? 'optional' }})
                </label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $message->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('cms.topbar_messages.message') }} (HTML)</label>
                <textarea id="content_html" name="content_html" class="form-control ck-editor" rows="6">{{ old('content_html', $message->content_html) }}</textarea>
                <small class="text-muted">
                    {{ __('cms.topbar_messages.editor_help') ?? 'You can use the editor for links, bold text, etc.' }}
                </small>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('cms.topbar_messages.starts_at') }} ({{ __('cms.optional') ?? 'optional' }})</label>
                    <input type="datetime-local" name="starts_at" class="form-control"
                        value="{{ old('starts_at', optional($message->starts_at)->format('Y-m-d\\TH:i')) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('cms.topbar_messages.ends_at') }} ({{ __('cms.optional') ?? 'optional' }})</label>
                    <input type="datetime-local" name="ends_at" class="form-control"
                        value="{{ old('ends_at', optional($message->ends_at)->format('Y-m-d\\TH:i')) }}">
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('cms.topbar_messages.priority') }}</label>
                    <input type="number" name="priority" class="form-control"
                           value="{{ old('priority', $message->priority) }}" min="0">
                </div>

                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', $message->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('cms.topbar_messages.status') }}</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('cms.topbar_messages.update') ?? 'Update' }}
                </button>
                <a href="{{ route('admin.topbar_messages.index') }}" class="btn btn-light">
                    {{ __('cms.topbar_messages.back') ?? 'Back' }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('#content_html');
    if (!el) return;

    ClassicEditor.create(el).catch(console.error);
});
</script>
@endsection
