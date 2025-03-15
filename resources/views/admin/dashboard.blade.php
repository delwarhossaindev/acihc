@php
//dd($from_date,$to_date);
@endphp

@extends('admin.layouts.master')

@section('content')
<div class="col-lg-12 mb-4 order-0">

@include('admin.summery')

<div class="row mt-5">
  <h4 class="fw-bold">CURRENT MONTH WITHDRAWAL BOARD!</h4>
</div>

<div class="card">
   <div class="card-body">

      <p style="font-weight: bold;">This month you have <span class="text-red">{{ count($withdrawal_products) }}</span> products to be withdrawn! <br></p>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="from_date">From Date</label>
            <input type="date" class="form-control" id="from_date" name="from_date" value="{{$from_date}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="to_date">To Date</label>
            <input type="date" class="form-control" id="to_date" name="to_date"  value="{{$to_date}}">
          </div>
        </div>
      </div>

      <table class="invoice-list-table table data-table border-top" style="width: 100%;">
    <thead>
    <tr>
    <th style="width: 5%;">#</th>
    <th style="width: 20%;">Product</th>
    <th style="width: 15%;">Batch No</th>
    <th style="width: 15%;">Stability Initiation Date</th>
    <th style="width: 10%;">Withdrawal Date</th>
    <th style="width: 10%;">Strength</th>
    <th style="width: 5%;">Unit Pack</th>
    <th style="width: 3%;">Status</th>
    <th style="width: 5%;">Month</th>
    <th style="width: 9%;">Withdraw By</th>
    <th style="width: 3%;">Action</th>
</tr>
    </thead>
</table>

<!-- Modal -->
<!-- <div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form
            action="{{ route('withdrawn.store') }}"
            method="post"
            class="needs-validation"
            novalidate
        >
            @csrf
            @method('post')
            <input type="hidden" name="batch_id" id="batch_id">
            <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="withdrawnDate" class="form-label">Withdrawn Date</label>
                                    <input type="date" class="form-control" id="withdrawnDate" name="withdrawnDate" value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                <p>Are you sure you want to withdraw this product?</p>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> -->
<!-- Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form
            action="{{ route('withdrawn.store') }}"
            method="post"
            class="needs-validation"
            novalidate
        >
            @csrf
            <input type="hidden" name="batch_id" id="batch_id">
            <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Are you sure you want to withdraw this product?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> 
                        <!-- <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="withdrawnDate" class="form-label">Withdrawn Date</label>
                                    <input type="date" class="form-control" id="withdrawnDate" name="withdrawnDate" value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                
                            </div>  
                        </div>                  -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->




   </div>
</div>
</div>
@endsection

@push('script')
<script>

$('body').on('click', '.ajax-approval-modal-btn', function(e) {

            e.preventDefault();
            var id = $(this).data('id');

            $('#batch_id').val(id);

            $('#dynamicApprovalModal').modal('show');

            });


    $(function () {
        var table = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('dashboard') }}",
                "data": function (d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            "columns": [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'ProductName', name: 'ProductName' },
                { data: 'BatchNo', name: 'BatchNo' },
                { data: 'SIDate', name: 'SIDate' },
                { data: 'WithdrawalDate', name: 'WithdrawalDate' },
                { data: 'Strength', name: 'Strength' },
                { data: 'PackID', name: 'PackID' },
                { data: 'Status', name: 'Status' },
                { data: 'Month', name: 'Month' },
                { data: 'WithdrawalBy', name: 'WithdrawalBy' },
                { data: 'action', name: 'action' },
            ]
        });

        // Trigger table reload on date change
        $('#from_date, #to_date').change(function () {
            table.draw();
        });
    });
</script>
@endpush
