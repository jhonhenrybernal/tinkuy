@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">  
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.refunds.title') }}</h6>
    </div>

    <div class="card-body">
        <table id="refunds-table" class="table table-bordered mt-4 dt-style">
            <thead>
                <tr>
                    <th>{{ __('cms.refunds.id') }}</th>
                    <th>{{ __('cms.refunds.payment') }}</th>
                    <th>{{ __('cms.refunds.amount') }}</th>
                    <th>{{ __('cms.refunds.status') }}</th>
                    <th>{{ __('cms.refunds.reason') }}</th>
                    <th>{{ __('cms.refunds.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteRefundModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('cms.refunds.delete_confirm') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">{{ __('cms.refunds.delete_message') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.refunds.cancel') }}</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteRefund">{{ __('cms.refunds.delete') }}</button>
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
    toastr.success("{{ session('success') }}", "{{ __('cms.refunds.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#refunds-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.refunds.getData') }}",
        language: @json($datatableLang),
        columns: [
            { data: 'id', name: 'id' },
            { data: 'payment', name: 'payment_id' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status' },
            { data: 'reason', name: 'reason' },
            { data: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10
    });
});

let refundToDeleteId = null;

function deleteRefund(id) {
    refundToDeleteId = id;        
    $('#deleteRefundModal').modal('show');

    $('#confirmDeleteRefund').off('click').on('click', function() {
        if (refundToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.refunds.destroy', ':id') }}'.replace(':id', refundToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#refunds-table').DataTable().ajax.reload();

                        toastr.error(response.message, "Deleted", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteRefundModal').modal('hide');
                    }
                },
                error: function() {
                    alert('Error deleting refund!');
                    $('#deleteRefundModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
