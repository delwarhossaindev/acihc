@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Condition List</h4>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.condition.modal.__create')
    <div class="edit-modal"></div>
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
                ajax: "{{ route('condition') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ConditionName',
                        name: 'ConditionName'
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
