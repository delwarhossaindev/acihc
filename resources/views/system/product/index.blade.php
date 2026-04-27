@extends('admin.layouts.master')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/tagify/tagify.css') }}" />
@endpush

@section('content')
    <x-alert.alert-component />

    <div class="settings-crumb">
        <i class="fa fa-house me-1"></i> Dashboard
        <i class="fa fa-angle-right mx-1"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-right mx-1"></i>
        <span>Product</span>
    </div>

    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <span class="settings-icon-badge me-3"><i class="fa fa-box"></i></span>
                <div>
                    <h4 class="settings-title">Product</h4>
                    <div class="settings-subtitle">Pharmaceutical products with strengths, packs, batches and APIs.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <a class="button-create" href="{{ route('product.create') }}">
                <i class="fa fa-plus"></i> Create New
            </a>
        </div>
    </div>

    <div class="card settings-card">
        <div class="card-header"><i class="fa fa-list me-2 text-primary"></i> Product List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Batch / Lot No</th>
                            <th>Strength</th>
                            <th>Unit Pack</th>
                            <th>API Detail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
$(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        order: [[0, 'desc']],
        ajax: "{{ route('product') }}",
        columns: [
            { data: 'ProductID', name: 'ProductID' },
            { data: 'ProductName', name: 'ProductName' },
            { data: 'batch', name: 'batch' },
            { data: 'details', name: 'details' },
            { data: 'packs', name: 'packs' },
            { data: 'apis', name: 'apis' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
});
</script>
@endpush
