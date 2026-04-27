@extends('admin.layouts.master')

@section('content')
    <x-alert.alert-component />

    <div class="settings-crumb">
        <i class="fa fa-house me-1"></i> Dashboard
        <i class="fa fa-angle-right mx-1"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-right mx-1"></i>
        <span>API Details</span>
    </div>

    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <span class="settings-icon-badge me-3"><i class="fa fa-vial"></i></span>
                <div>
                    <h4 class="settings-title">API Details</h4>
                    <div class="settings-subtitle">Active pharmaceutical ingredients used in protocols.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            @if (auth()->user()->hasPermission('ApiController@create'))
                <a class="button-create" data-bs-target="#basicModal" data-bs-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus"></i> Create New
                </a>
            @endif
        </div>
    </div>

    <div class="card settings-card">
        <div class="card-header"><i class="fa fa-list me-2 text-primary"></i> API Detail List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Source</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.apidetail.modal.__create')
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
        order: [[0, 'desc']],
        ajax: "{{ route('apidetail') }}",
        columns: [
            { data: 'ApiDetailID', name: 'ApiDetailID' },
            { data: 'ApiDetailName', name: 'ApiDetailName' },
            { data: 'APIDetailSource', name: 'APIDetailSource' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
});
</script>
@endpush
