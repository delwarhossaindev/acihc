@extends('admin.layouts.master')
@section('content')
    <div class="row mt-3">
        <div class="col-md-3 mt-2">
            <h4 class="fw-bold">Packaging Profile</h4>
        </div>
        <div class="col-md 7"></div>
        <div class="col-md-2">
            <a class="button-create float-right" href="{{ route('container.create') }}">Create New</a>
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
                            <th>Packaging Type</th>
                            <th>Packaging Name</th>
                            <th>Packaging Source</th>
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
                "retrieve": true,
                "serverSide": true,
                'paginate': true,
                'searchDelay': 700,
                "bDeferRender": true,
                "order": [
                    [0, 'desc']
                ],
                ajax: "{{ route('container') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ContainerType',
                        name: 'ContainerType'
                    },
                    {
                        data: 'PackagingName',
                        name: 'packaging.PackagingName',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'PackagingSource',
                        name: 'packaging.PackagingSource',
                        orderable: false,
                        searchable: false
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
        $('.js-example-basic-multiple').select2({
            placeholder: 'Select an option'
        });
    </script>
@endpush
