@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Test</h4>
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
                            <th>Test</th>
                            <th>Type</th>
                            {{-- <th>Sub Test</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
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
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('test') }}",
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
                        data: 'TestName',
                        name: 'TestName'
                    },
                    {
                        data: 'TestType',
                        name: 'TestType'
                    },
                    // {data: 'subtest', name: 'subtest.SubTestName'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $("input[type=checkbox]").click(function() {
                if ($(this).prop("checked")) {
                    $('#hidden-select-test').fadeIn();
                    $("#language").attr("required", "true");
                } else {
                    $('#hidden-select-test').fadeOut()
                    $("#language").removeAttr("required");
                }
            });
        });
    </script>
@endpush
