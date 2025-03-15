@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Manufacturer</h4>
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
                            {{-- <th><input type="checkbox" id="" name="checkbox" class="form-check-input"/></th> --}}
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Address Type</th>
                            <th>Phone</th>
                            <th>Zip Code</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
            <tr>
              <th>Serial</th>
              <th>Name</th>
              <th>Address Line1</th>
              <th>Address Line2</th>
              <th>Address Type</th>
              <th>City</th>
              <th>Phone</th>
              <th>Zip Code</th>
              <th>Email</th>
              <th></th>
            </tr>
          </tfoot> --}}
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.manufacturer.modal.__create')
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
                "scrollCollapse": true,
                "order": [
                    [0, 'desc']
                ],
                ajax: "{{ route('manufacturer') }}",
                columns: [
                    // {data: 'checkbox', name: 'checkbox'},
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ManufacturerName',
                        name: 'ManufacturerName'
                    },
                    {
                        data: 'address1',
                        name: 'address.address_line_1'
                    },
                    {
                        data: 'city',
                        name: 'address.city'
                    },
                    {
                        data: 'address2',
                        name: 'address.address_line_2'
                    },
                    {
                        data: 'type',
                        name: 'address.address_type'
                    },
                    {
                        data: 'phone',
                        name: 'address.phone'
                    },
                    {
                        data: 'zip_code',
                        name: 'address.zip_code'
                    },
                    {
                        data: 'email',
                        name: 'address.email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // initComplete: function () {
                //   this.api().columns().every(function () {
                //       var column = this;
                //       var input = document.createElement('input');
                //       $(input).appendTo($(column.footer()).empty())
                //       .on('change', function () {
                //           var val = $.fn.dataTable.util.escapeRegex($(this).val());
                //           column.search(val ? val : '', true, false).draw();
                //         });
                //     });
                // }
            });
        });
    </script>
@endpush
