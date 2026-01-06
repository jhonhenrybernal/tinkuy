@extends('admin.layouts.admin')

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center">
            <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.vendors.title_list') }}</h6>

            {{-- Botón para crear nuevo proveedor --}}
            <a href="{{ route('admin.vendors.create') }}" class="btn btn-sm btn-success">
                {{ __('cms.vendors.register_new_vendor') }}
            </a>
        </div>

        <div class="card-body">
            <table id="vendors-table" class="table table-bordered mt-4 dt-style">
                <thead>
                    <tr>
                        <th>{{ __('cms.vendors.id') }}</th>
                        <th>{{ __('cms.vendors.name') }}</th>
                        <th>{{ __('cms.vendors.email') }}</th>
                        <th>{{ __('cms.vendors.phone') }}</th>
                        <th>{{ __('cms.vendors.status') }}</th>
                        <th>{{ __('cms.vendors.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteVendorModal" tabindex="-1" aria-labelledby="deleteVendorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteVendorModalLabel">{{ __('cms.vendors.modal_confirm_delete_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">{{ __('cms.vendors.modal_confirm_delete_body') }}</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.vendors.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteVendor">{{ __('cms.vendors.delete') }}</button>
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
            toastr.success("{{ session('success') }}", "{{ __('cms.vendors.success') }}", {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 5000
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            console.log('Inicializando DataTable vendors...');

            // URLs base para acciones
            const editUrlTemplate = '{{ route('admin.vendors.edit', ':id') }}';

            $('#vendors-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.vendors.data') }}",
                    type: "GET",
                    error: function (xhr, error, thrown) {
                        console.error('Error DataTables:', error, thrown);
                        console.error('Respuesta:', xhr.responseText);
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data === 'active'
                                ? '<span class="badge bg-success">{{ __('cms.vendors.active') }}</span>'
                                : '<span class="badge bg-danger">{{ __('cms.vendors.inactive') }}</span>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            const editUrl = editUrlTemplate.replace(':id', row.id);

                            return `
                                <a href="${editUrl}" class="border border-primary dt-edit rounded-3 d-inline-block me-2 px-2 py-1">
                                    <i class="bi bi-pencil-fill text-primary"></i>
                                </a>
                                <span class="border border-danger dt-trash rounded-3 d-inline-block px-2 py-1"
                                      onclick="deleteVendor(${row.id})">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </span>
                            `;
                        }
                    }
                ],
                pageLength: 10,
                language: @json($datatableLang)
            });
        });

        let vendorToDeleteId = null;

        function deleteVendor(id) {
            vendorToDeleteId = id;
            $('#deleteVendorModal').modal('show');

            $('#confirmDeleteVendor').off('click').on('click', function() {
                if (vendorToDeleteId !== null) {
                    $.ajax({
                        url: '{{ route('admin.vendors.destroy', ':id') }}'.replace(':id', vendorToDeleteId),
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#vendors-table').DataTable().ajax.reload();
                                toastr.success(response.message || "{{ __('cms.vendors.success_delete') }}", "{{ __('cms.vendors.success') }}", {
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-top-right",
                                    timeOut: 5000
                                });
                                $('#deleteVendorModal').modal('hide');
                            } else {
                                toastr.error("{{ __('cms.vendors.error_delete') }}", "Error");
                            }
                        },
                        error: function() {
                            toastr.error("{{ __('cms.vendors.error_delete') }}", "Error");
                            $('#deleteVendorModal').modal('hide');
                        }
                    });
                }
            });
        }
    </script>
@endsection
