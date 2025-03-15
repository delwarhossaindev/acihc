@extends('admin.layouts.master')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/css/froala_editor.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
   
@endpush

@section('content')
    <div class="row mt-3">
        <div class="col-md-4 mt-2">
            <h4 class="fw-bold">Recieved Sample</h4>
        </div>
        <div class="col-md 6"></div>
        <div class="col-md-2">
            <a class="button-create float-right" data-bs-target="#basicModal" data-backdrop="static" data-keyboard="false"
                data-bs-toggle="modal">Create New</a>
        </div>

        
    </div>

    <x-alert.alert-component />

    <div class="card">

        <div class="card-body">
        <!-- <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="from_date">From Date</label>
            <input type="date" class="form-control" id="from_date" name="from_date">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="to_date">To Date</label>
            <input type="date" class="form-control" id="to_date" name="to_date">
          </div>
        </div>
      </div> -->
      <br>
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Sample No</th>
                            <th>Product</th>
                            <th>Receiving Date</th>
                            <th>Packaging Date</th>
                            <th>Protocol</th>
                            <th>GRN Number</th>
                            <th>Manufacturer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('system.sample.modal.__create')
    <div class="edit-modal"></div>
@endsection

@push('script')
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/froala_editor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/froala_editor.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/plugins.pkgd.min.js"></script>

    <script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#note'))
            .catch(error => {
                console.error(error);
            });
        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            responsive: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('sample.index') }}",
                data: function(d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            columns: [
                { data: 'SampleNo', name: 'SampleNo', orderable: false, searchable: false },
                { data: 'ProductName', name: 'ProductName', orderable: false },
                { data: 'ReceivingDate', name: 'ReceivingDate' },
                { data: 'PackagingDate', name: 'PackagingDate' },
                { data: 'protocol', name: 'protocol', orderable: false },
                { data: 'GRN_NUMBER', name: 'GRN_NUMBER' },
                { data: 'ManufacturerName', name: 'ManufacturerName' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

     
        $('#from_date, #to_date').on('change', function() {
            table.draw(); 
        });

      
       
    });
</script>

@endpush
