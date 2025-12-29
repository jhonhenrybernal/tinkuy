@extends('admin.layouts.admin')

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.customers.customer_list') }}</h6>
    </div>
    <div class="card-body">
        <table id="customers-table" class="table table-bordered mt-4 dt-style">
            <thead>
                <tr>
                    <th>{{ __('cms.customers.id') }}</th>
                    <th>{{ __('cms.customers.name') }}</th>
                    <th>{{ __('cms.customers.email') }}</th>
                    <th>{{ __('cms.customers.phone') }}</th>
                    <th>{{ __('cms.customers.address') }}</th>
                    <th>{{ __('cms.customers.status') }}</th>
                    <th>{{ __('cms.customers.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerModalLabel">{{ __('cms.customers.confirm_delete_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ __('cms.customers.confirm_delete_message') }}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.customers.cancel_button') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCustomer">{{ __('cms.customers.delete_button') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@php
    $datatableLang = __('cms.datatables'); 
@endphp

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.customers.success_title') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.customers.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { 
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data === 'active' 
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                }
            },
            { 
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<span class="border border-danger dt-trash rounded-3 d-inline-block" 
                                onclick="deleteCustomer(${row.id})">
                                <i class="bi bi-trash-fill text-danger"></i>
                            </span>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let customerToDeleteId = null;

function deleteCustomer(id) {
    customerToDeleteId = id;        
    $('#deleteCustomerModal').modal('show');

    $('#confirmDeleteCustomer').off('click').on('click', function() {
        if (customerToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.customers.destroy', ':id') }}'.replace(':id', customerToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#customers-table').DataTable().ajax.reload();
                        toastr.error(response.message, "Deleted", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteCustomerModal').modal('hide');
                    }
                },
                error: function() {
                    toastr.error("Error deleting customer!", "Error");
                    $('#deleteCustomerModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
