@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center">
            <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.topbar_messages.heading') }}</h6>
            <a href="{{ route('admin.topbar_messages.create') }}" class="btn btn-sm btn-light">
                + {{ __('cms.topbar_messages.add_new') }}
            </a>
        </div>

        <div class="card-body">
            <table id="topbar-messages-table" class="table table-bordered mt-4 dt-style">
                <thead>
                    <tr>
                        <th>{{ __('cms.topbar_messages.id') }}</th>
                        <th>{{ __('cms.topbar_messages.title') }}</th>
                        <th>{{ __('cms.topbar_messages.priority') }}</th>
                        <th>{{ __('cms.topbar_messages.starts_at') }}</th>
                        <th>{{ __('cms.topbar_messages.ends_at') }}</th>
                        <th>{{ __('cms.topbar_messages.status') }}</th>
                        <th>{{ __('cms.topbar_messages.action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteTopbarMessageModal" tabindex="-1" aria-labelledby="deleteTopbarMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTopbarMessageModalLabel">{{ __('cms.topbar_messages.massage_confirm') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">{{ __('cms.topbar_messages.confirm_delete') }}</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.topbar_messages.massage_cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteTopbarMessage">{{ __('cms.topbar_messages.massage_delete') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

@if (session('success'))
<script>
toastr.success("{{ session('success') }}", "{{ __('cms.topbar_messages.success') }}", {
    closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
});
</script>
@endif

<script>
$(document).ready(function() {
    $('#topbar-messages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.topbar_messages.data') }}",
            type: 'POST',
            data: function(d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'priority', name: 'priority' },
            { data: 'starts_at', name: 'starts_at' },
            { data: 'ends_at', name: 'ends_at' },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    var isChecked = data ? 'checked' : '';
                    return `<label class="switch">
                                <input type="checkbox" class="toggle-status" data-id="${row.id}" ${isChecked}>
                                <span class="slider round"></span>
                            </label>`;
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editBtn = `<span class="border border-edit dt-trash rounded-3 d-inline-block">
                        <a href="/admin/topbar-messages/${row.id}/edit">
                            <i class="bi bi-pencil-fill pencil-edit-color"></i>
                        </a>
                    </span>`;

                    var deleteBtn = `<span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteTopbarMessage(${row.id})">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </span>`;

                    return editBtn + ' ' + deleteBtn;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });

    $(document).on('change', '.toggle-status', function() {
        var id = $(this).data('id');
        var isActive = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('admin.topbar_messages.updateStatus') }}',
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id, status: isActive },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, "Updated", { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:5000 });
                } else {
                    toastr.error(response.message, "Failed", { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:5000 });
                }
            },
            error: function() {
                alert('Error updating status!');
            }
        });
    });
});

let topbarMessageToDeleteId = null;

function deleteTopbarMessage(id) {
    topbarMessageToDeleteId = id;
    $('#deleteTopbarMessageModal').modal('show');

    $('#confirmDeleteTopbarMessage').off('click').on('click', function() {
        $.ajax({
            url: '{{ route('admin.topbar_messages.destroy', ':id') }}'.replace(':id', topbarMessageToDeleteId),
            method: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                if (response.success) {
                    $('#topbar-messages-table').DataTable().ajax.reload();
                    toastr.error(response.message, "{{ __('cms.topbar_messages.success') }}", { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:5000 });
                    $('#deleteTopbarMessageModal').modal('hide');
                } else {
                    toastr.error(response.message, "Error", { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:5000 });
                }
            },
            error: function() {
                console.log('Error deleting message!');
                $('#deleteTopbarMessageModal').modal('hide');
            }
        });
    });
}
</script>
@endsection
