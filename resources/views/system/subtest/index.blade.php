@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Sub Test</h4>
        </div>
        <div class="col-md 8"></div>
        <div class="col-md-2">
            <a href="{{ route('test') }}" class="button-create float-right">Create New</a>
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
                            <th>Sub Test Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="edit-modal"></div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('subtest') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'SubTestName',
                        name: 'SubTestName'
                    },
                    {
                        data: 'TestType',
                        name: 'TestType'
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
