@extends('admin.layouts.master')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/tagify/tagify.css') }}" />
@endpush

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Product List</h4>
        </div>
        <div class="col-md 8"></div>
        <div class="col-md-2">
            <a class="button-create float-right" href="{{ route('product.create') }}">Create New</a>
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
                            <th>Batch/Lot No</th>
                            <th>Strength</th>
                            <th>Unit Pack</th>
                            <th>API Detail</th>
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
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                ajax: "{{ route('product') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ProductName',
                        name: 'ProductName'
                    },
                    {
                        data: 'batch',
                        name: 'batch'
                    },
                    {
                        data: 'details',
                        name: 'details'
                    },
                    {
                        data: 'packs',
                        name: 'packs'
                    },
                    {
                        data: 'apis',
                        name: 'apis'
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
