@extends('admin.layouts.master')

@section('content')
    <x-alert.alert-component />

    <div class="settings-crumb">
        <i class="fa fa-house me-1"></i> Dashboard
        <i class="fa fa-angle-right mx-1"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-right mx-1"></i>
        <span>Unit Pack</span>
    </div>

    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <span class="settings-icon-badge me-3"><i class="fa fa-cube"></i></span>
                <div>
                    <h4 class="settings-title">Unit Pack</h4>
                    <div class="settings-subtitle">Pack sizes used across products (e.g. 10, 20, 100 tablets).</div>
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
        <div class="card-header"><i class="fa fa-list me-2 text-primary"></i> Pack List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.pack.modal.__create')
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
        order: [[0, 'desc']],
        ajax: "{{ route('pack') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'PackValue', name: 'PackValue' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

    $('.btn-add-more').click(function() {
        var html = $('.select_date').html();
        $('.input_div').after(html);
    });
    $('body').on('click', '.btn-remove', function() {
        $(this).closest('.remove_row').remove();
    });
});
</script>
@endpush
