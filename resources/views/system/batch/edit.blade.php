@extends('admin.layouts.master')

@section('content')

    <h4 class="fw-bold py-1 mb-3">Edit Batch</h4>

    <x-alert.alert-component />

    <div class="card">
       <div class="card-body">
        <form
        action="{{ route('batch.update',$batch->BatchID) }}"
        method="post"
        class="needs-validation"
        role="form"
        novalidate
    >
    @csrf
    @method('patch')
    <div class="row">
        <div class="col mb-3">
        <label for="BatchName" class="form-label">Batch Type</label> <span style="color: red">*</span>
        <input type="text" name="BatchName" id="BatchName" class="form-control" placeholder="Enter Batchname" required value="{{ isset($batch) ? $batch->BatchName : '' }}">
        <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col mb-3">
            <label for="BatchNo" class="form-label">Batch No</label> <span style="color: red">*</span>
            <input type="text" name="BatchNo" id="BatchNo" class="form-control" placeholder="Enter BatchNo" required value="{{ isset($batch) ? $batch->BatchNo : '' }}">
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col mb-3">
            <label for="BatchSize" class="form-label">Batch Size</label> <span style="color: red">*</span>
            <input type="text" name="BatchSize" id="BatchSize" class="form-control" placeholder="Enter BatchSize" required value="{{ isset($batch) ? $batch->BatchSize : '' }}">
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="DescriptionOfPack" class="form-label">Description of Pack</label> <span style="color: red">*</span>
            <input type="text" name="DescriptionOfPack" id="DescriptionOfPack" class="form-control" placeholder="Enter Description of pack" required value="{{ isset($batch) ? $batch->DescriptionOfPack : '' }}">
            <div class="invalid-tooltip">Required</div>
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
            <label for="SIDate" class="form-label">SIDate</label>
            <input type="date" name="SIDate" id="SIDate" class="form-control" placeholder="Enter SIDate" required value="{{ isset($batch) ? $batch->SIDate : '' }}">
            <div class="invalid-tooltip">Required</div>
        </div>

        <div class="col mb-3">
            <label for="WithdrawalDate" class="form-label">WithdrawalDate</label>
            <input type="date" name="WithdrawalDate" id="WithdrawalDate" class="form-control" placeholder="Enter WithdrawalDate" required value="{{ isset($batch) ? $batch->WithdrawalDate : '' }}">
            <div class="invalid-tooltip">Required</div>
        </div>

    </div>

    <div class="row">
        <div class="col mb-3">
            <label for="ProtocolID" class="form-label">Protocol</label> <span style="color: red">*</span>
            <select class="select2 form-select" name="ProtocolID" id="ProtocolID" required>
                <option value="">Select Protocol</option>
                @foreach ($protocols as $protocol)
                <option value="{{$protocol->ProtocolID}}" {{ $protocol->ProtocolID == $batch->ProtocolID ? 'selected' : '' }}>
                {{ $protocol->Title }}
                </option>
            @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col">
            <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="form-control" name="SkuID" id="SkuID" required>
                @foreach ($batch->product->skus as $sku)
                <option value="{{$sku->SkuID}}" {{ $sku->SkuID == $batch->SkuID ? 'selected' : '' }}>
                {{ $sku->ProductStrength }}
                </option>
                @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col mb-3">
            <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
            <select class="form-select" name="PackID" id="PackID" required>
                <option value="">Unit Pack</option>
                @foreach (\App\Models\Pack::all() as $pack)
                <option value="{{$pack->PackValue}}" {{ $pack->PackValue == $batch->PackID ? 'selected' : '' }}>
                {{ $pack->PackValue }}
                </option>
            @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col mb-3">
            <label for="Month" class="form-label">Month</label> <span style="color: red">*</span>
            <select class="form-select" name="Month" id="Month" required>
                <option value="">Select Month</option>
                @foreach ($months as $month)
                <option value="{{$month}}" {{ $month == $batch->Month ? 'selected' : '' }}>
                {{ $month }}
                </option>
                @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
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
