@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">  
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.payment_gateways.title') }}</h6>
    </div>

    <div class="card-body">
        <table id="gateways-table" class="table table-bordered mt-4 dt-style">
            <thead>
                <tr>
                    <th>{{ __('cms.payment_gateways.id') }}</th>
                    <th>{{ __('cms.payment_gateways.name') }}</th>
                    <th>{{ __('cms.payment_gateways.code') }}</th>
                    <th>{{ __('cms.payment_gateways.status') }}</th>
                    <th>{{ __('cms.payment_gateways.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteGatewayModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('cms.payment_gateways.delete_confirm') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">{{ __('cms.payment_gateways.delete_message') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.payment_gateways.cancel') }}</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteGateway">{{ __('cms.payment_gateways.delete') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@php
    $datatableLang = __('cms.datatables'); 
@endphp

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.payment_gateways.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#gateways-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payment-gateways.getData') }}",
        language: @json($datatableLang),
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { 
                data: 'status', 
                name: 'is_active', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    return data ? "{{ __('cms.payment_gateways.active') }}" : "{{ __('cms.payment_gateways.inactive') }}";
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editBtn = '<span class="border border-edit dt-trash rounded-3 d-inline-block">' +
                                    '<a href="/admin/payment-gateways/' + row.id + '/edit">' +
                                        '<i class="bi bi-pencil-fill pencil-edit-color"></i>' +
                                    '</a>' +
                                '</span>';

                    var deleteBtn = '<span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteGateway(' + row.id + ')">' +
                                        '<i class="bi bi-trash-fill text-danger"></i>' +
                                    '</span>';

                    return editBtn + ' ' + deleteBtn;
                }
            }
        ],
        pageLength: 10
    });
});

let gatewayToDeleteId = null;

function deleteGateway(id) {
    gatewayToDeleteId = id;        
    $('#deleteGatewayModal').modal('show');

    $('#confirmDeleteGateway').off('click').on('click', function() {
        if (gatewayToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.payment-gateways.destroy', ':id') }}'.replace(':id', gatewayToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#gateways-table').DataTable().ajax.reload();

                        toastr.error(response.message, "Deleted", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteGatewayModal').modal('hide');
                    }
                },
                error: function() {
                    alert('Error deleting payment gateway!');
                    $('#deleteGatewayModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
