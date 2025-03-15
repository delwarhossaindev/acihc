@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Packaging</h4>
        </div>
        <div class="col-md 8"></div>
        <div class="col-md-2">
            <a class="button-create float-right" data-bs-target="#basicModal" data-backdrop="static" data-keyboard="false"
                data-bs-toggle="modal">Create New</a>
        </div>
    </div>

    <x-alert.alert-component />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Source</th>
                            <th>DMF</th>
                            <th>Resin</th>
                            <th>Colorant</th>
                            <th>Liner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.packaging.modal.__create')
    <div class="edit-modal"></div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                "processing": true,
                "retrieve": true,
                "serverSide": true,
                'paginate': true,
                'searchDelay': 700,
                "bDeferRender": true,
                "responsive": true,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                ajax: "{{ route('packaging') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'PackagingName',
                        name: 'PackagingName'
                    },
                    {
                        data: 'PackagingSource',
                        name: 'PackagingSource'
                    },
                    {
                        data: 'PackagingDMF',
                        name: 'PackagingDMF'
                    },
                    {
                        data: 'PackagingResin',
                        name: 'PackagingResin'
                    },
                    {
                        data: 'PackagingColorant',
                        name: 'PackagingColorant'
                    },
                    {
                        data: 'PackagingLiner',
                        name: 'PackagingLiner'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endpush
