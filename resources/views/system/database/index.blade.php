@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Database List</h4>
        </div>
        <div class="col-md 8"></div>
        <div class="col-md-2">
            <a class="button-create float-right" href="{{ route('batch.create') }}">Create New</a>
        </div>
    </div>

    <x-alert.alert-component />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Batch Name</th>
                            <th>Batch No</th>
                            <th>Batch Size</th>
                            <th>SI Date</th>
                            <th>Unit Pack</th>
                            <th>Month</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "order": [
                    [0, 'desc']
                ],
                ajax: "{{ route('batch.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product',
                        name: 'product',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'BatchName',
                        name: 'BatchName',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'BatchNo',
                        name: 'BatchNo',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'BatchSize',
                        name: 'BatchSize',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'SIDate',
                        name: 'SIDate'
                    },
                    {
                        data: 'PackID',
                        name: 'PackID'
                    },
                    {
                        data: 'Month',
                        name: 'Month'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
