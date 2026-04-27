@extends('admin.layouts.master')

@section('content')
    <x-alert.alert-component />

    <div class="settings-crumb">
        <i class="fa fa-house me-1"></i> Dashboard
        <i class="fa fa-angle-right mx-1"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-right mx-1"></i>
        <span>Manufacturer</span>
    </div>

    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <span class="settings-icon-badge me-3"><i class="fa fa-industry"></i></span>
                <div>
                    <h4 class="settings-title">Manufacturer</h4>
                    <div class="settings-subtitle">Companies that manufacture products and their addresses.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            @if (auth()->user()->hasPermission('ManufacturerController@create'))
                <a class="button-create" data-bs-target="#basicModal" data-bs-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus"></i> Create New
                </a>
            @endif
        </div>
    </div>

    <div class="card settings-card">
        <div class="card-header"><i class="fa fa-list me-2 text-primary"></i> Manufacturer List</div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table data-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Address Type</th>
                            <th>Phone</th>
                            <th>Zip Code</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.manufacturer.modal.__create')
    <div class="edit-modal"></div>
@endsection

@push('script')
<script>
$(function() {
    $('.data-table').DataTable({
        processing: true,
        retrieve: true,
        serverSide: true,
        paginate: true,
        searchDelay: 700,
        bDeferRender: true,
        responsive: true,
        autoWidth: false,
        scrollCollapse: true,
        order: [[0, 'desc']],
        ajax: "{{ route('manufacturer') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'ManufacturerName', name: 'ManufacturerName' },
            { data: 'address1', name: 'address.address_line_1' },
            { data: 'city', name: 'address.city' },
            { data: 'address2', name: 'address.address_line_2' },
            { data: 'type', name: 'address.address_type' },
            { data: 'phone', name: 'address.phone' },
            { data: 'zip_code', name: 'address.zip_code' },
            { data: 'email', name: 'address.email' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
});
</script>
@endpush
