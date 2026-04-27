@extends('admin.layouts.master')

@section('content')
    <x-alert.alert-component />

    <div class="settings-crumb">
        <i class="fa fa-house me-1"></i> Dashboard
        <i class="fa fa-angle-right mx-1"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-right mx-1"></i>
        <span>Sub Test</span>
    </div>

    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <span class="settings-icon-badge me-3"><i class="fa fa-flask-vial"></i></span>
                <div>
                    <h4 class="settings-title">Sub Test</h4>
                    <div class="settings-subtitle">Sub-tests grouped under parent tests. Create from the Test page.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('test') }}" class="button-create">
                <i class="fa fa-plus"></i> Create New
            </a>
        </div>
    </div>

    <div class="card settings-card">
        <div class="card-header"><i class="fa fa-list me-2 text-primary"></i> Sub Test List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sub Test Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="edit-modal"></div>
@endsection

@push('script')
<script>
$(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('subtest') }}",
        order: [[0, 'desc']],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'SubTestName', name: 'SubTestName' },
            { data: 'TestType', name: 'TestType' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
});
</script>
@endpush
