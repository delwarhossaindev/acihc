@extends('admin.layouts.master')

@section('content')
    <h4 class="fw-bold py-1 mb-3">Create Batch</h4>
    <x-alert.alert-component />
    <div class="card">
       <div class="card-body">
        <form
        action="{{ route('batch.store') }}"
        method="post"
        class="needs-validation"
        role="form"
        novalidate
    >
    @csrf
    <div class="row">
        <div class="col-md-2 mb-3">
        <label for="BatchName" class="form-label">Batch Type</label> <span style="color: red">*</span>
        <input type="text" name="BatchName" id="BatchName" class="form-control" placeholder="Enter Batchtype" required value="{{ isset($batch) ? $batch->BatchName : '' }}">
        </div>
        <div class="col-md-2 mb-3">
            <label for="BatchNo" class="form-label">Batch No</label> <span style="color: red">*</span>
            <input type="text" name="BatchNo" id="BatchNo" class="form-control" placeholder="Enter BatchNo" required value="{{ isset($batch) ? $batch->BatchNo : '' }}">
        </div>
        <div class="col-md-2 mb-3">
            <label for="BatchSize" class="form-label">Batch Size</label> <span style="color: red">*</span>
            <input type="text" name="BatchSize" id="BatchSize" class="form-control" placeholder="Enter BatchSize" required value="{{ isset($batch) ? $batch->BatchSize : '' }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="DescriptionOfPack" class="form-label">Description of Pack</label> <span style="color: red">*</span>
            <input type="text" name="DescriptionOfPack" id="DescriptionOfPack" class="form-control" placeholder="Enter Description of pack" required value="{{ isset($batch) ? $batch->DescriptionOfPack : '' }}">
        </div>
   </div>

   <div class="row">
        <div class="col mb-3">
            <label for="MfgDate" class="form-label">Mfg Date</label>
            <input type="month" name="MfgDate" id="MfgDate" class="form-control" placeholder="Enter MfgDate" required value="{{ isset($batch) ? date('Y-m', strtotime($batch->MfgDate)) : '' }}">
        </div>
        <div class="col mb-3">
            <label for="ExpDate" class="form-label">Exp Date</label>
            <input type="month" name="ExpDate" id="ExpDate" class="form-control" placeholder="Enter ExpDate" required value="{{ isset($batch) ? date('Y-m', strtotime($batch->ExpDate)) : '' }}">
        </div>
        <div class="col mb-3">
            <label for="SIDate" class="form-label">SI Date</label>
            @if(isset($batch) && isset($SIDate))
            <input type="date" name="SIDate" id="SIDate" class="form-control" placeholder="Enter SIDate" required value="{{ $SIDate }}">
            @elseif(isset($batch) && isset($batch->SIDate))
            <input type="date" name="SIDate" id="SIDate" class="form-control" placeholder="Enter SIDate" required value="{{ $batch->SIDate }}">
            @else
            <input type="date" name="SIDate" id="SIDate" class="form-control" placeholder="Enter SIDate" required>
            @endif
        </div>
        <div class="col mb-3">
            <label for="SIDate" class="form-label">Withdraw Date</label>
            @if(isset($batch) && isset($WithdrawalDate))
            <input type="date" name="WithdrawalDate" id="WithdrawalDate" class="form-control" placeholder="Enter Withdraw Date" required value="{{ $WithdrawalDate }}">
            @elseif(isset($batch) && isset($batch->WithdrawDate))
            <input type="date" name="WithdrawalDate" id="WithdrawalDate" class="form-control" placeholder="Enter Withdraw Date" required value="{{ $batch->WithdrawalDate }}">
            @else
            <input type="date" name="WithdrawalDate" id="WithdrawalDate" class="form-control" placeholder="Enter Withdraw Date" required>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col mb-3">
            <label for="ProtocolID" class="form-label">Protocol</label> <span style="color: red">*</span>
            <select class="select2 form-select" name="ProtocolID" id="ProtocolID" required>
                <option value="">Select Protocol</option>
                @foreach ($protocols as $protocol)
                <option value="{{$protocol->ProtocolID}}">
                {{ $protocol->Title }}
                </option>
            @endforeach
            </select>
        </div>
        <div class="col">
            <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="form-control" name="SkuID" id="SkuID" required>
                <option value="">Select Strength</option>
            </select>
        </div>
        <div class="col mb-3">
            <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
            <select class="form-select" name="PackID" id="PackID" required>
                <option value="">Unit Pack</option>
            </select>
        </div>
        <div class="col mb-3">
            <label for="Month" class="form-label">Month</label> <span style="color: red">*</span>
            <select class="form-select" name="Month" id="Month" required>
                <option value="">Select Month</option>
            </select>
        </div>
    </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
       </div>
    </div>
@endsection

@push('script')
<script>
    $(function () {
        $('#ProtocolID').on('change',function(e) {
            var ProtocolID = e.target.value;
            $.ajax({
                url:"{{ route('ajax.get.product') }}",
                type:"GET",
                data: {
                    ProtocolID: ProtocolID
                },
                success:function (data) {
                    $('#SkuID').empty();
                    $.each(data.skus,function(index,sku){
                        $('#SkuID').append('<option value="'+sku.SkuID+'">'+sku.ProductStrength+'</option>');
                    })
                    $.each(data.packs,function(index,pack){
                        $('#PackID').append('<option value="'+pack.PackValue+'">'+pack.PackValue+'</option>');
                    })
                    $.each(data.months,function(index,month){
                        $('#Month').append('<option value="'+month+'">'+month+'</option>');
                    })
                }
            })
        });
    });
</script>
@endpush
