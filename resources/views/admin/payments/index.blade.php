@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">  
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.payments.title') }}</h6>
    </div>

    <div class="card-body">
        <table id="payments-table" class="table table-bordered mt-4 dt-style">
            <thead>
                <tr>
                    <th>{{ __('cms.payments.id') }}</th>
                    <th>{{ __('cms.payments.order') }}</th>
                    <th>{{ __('cms.payments.user') }}</th>
                    <th>{{ __('cms.payments.gateway') }}</th>
                    <th>{{ __('cms.payments.amount') }}</th>
                    <th>{{ __('cms.payments.status') }}</th>
                    <th>{{ __('cms.payments.transaction') }}</th>
                    <th>{{ __('cms.payments.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletePaymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('cms.payments.delete_confirm') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">{{ __('cms.payments.delete_message') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.payments.cancel') }}</button>
        <button type="button" class="btn btn-danger" id="confirmDeletePayment">{{ __('cms.payments.delete') }}</button>
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
    toastr.success("{{ session('success') }}", "{{ __('cms.payments.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payments.getData') }}",
        language: @json($datatableLang),
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order', name: 'order_id' },
            { data: 'user', name: 'user_id' },
            { data: 'gateway', name: 'gateway_id' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status' },
            { data: 'transaction_id', name: 'transaction_id' },
            { data: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10
    });
});

let paymentToDeleteId = null;

function deletePayment(id) {
    paymentToDeleteId = id;        
    $('#deletePaymentModal').modal('show');

    $('#confirmDeletePayment').off('click').on('click', function() {
        if (paymentToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.payments.destroy', ':id') }}'.replace(':id', paymentToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#payments-table').DataTable().ajax.reload();

                        toastr.error(response.message, "Deleted", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deletePaymentModal').modal('hide');
                    }
                },
                error: function() {
                    alert('Error deleting payment!');
                    $('#deletePaymentModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
