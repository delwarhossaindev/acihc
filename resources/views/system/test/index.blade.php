@extends('admin.layouts.master')

@section('content')
    <x-alert.alert-component />

    <div class="settings-crumb">
        <i class="fa fa-house me-1"></i> Dashboard
        <i class="fa fa-angle-right mx-1"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-right mx-1"></i>
        <span>Test</span>
    </div>

    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <span class="settings-icon-badge me-3"><i class="fa fa-flask"></i></span>
                <div>
                    <h4 class="settings-title">Test</h4>
                    <div class="settings-subtitle">Stability test parameters and value types.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <a class="button-create" data-bs-target="#basicModal" data-bs-toggle="modal" data-backdrop="static" data-keyboard="false">
                <i class="fa fa-plus"></i> Create New
            </a>
        </div>
    </div>

    <div class="card settings-card">
        <div class="card-header"><i class="fa fa-list me-2 text-primary"></i> Test List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Test</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.test.modal.__create')
    <div class="edit-modal"></div>
@endsection

@push('script')
<script>
$(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('test') }}",
        order: [[0, 'desc']],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'TestName', name: 'TestName' },
            { data: 'TestType', name: 'TestType' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

    $('input[type=checkbox][name=hasParent]').on('click', function() {
        if ($(this).prop('checked')) {
            $('#hidden-select-test').fadeIn();
            $('#parentTest').attr('required', true);
        } else {
            $('#hidden-select-test').fadeOut();
            $('#parentTest').removeAttr('required');
        }
    });
});
</script>
@endpush
