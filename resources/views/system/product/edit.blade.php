@extends('admin.layouts.master')

@section('content')

    <h4 class="fw-bold py-1 mb-3">Update Product</h4>

    <x-alert.alert-component />

    <div class="card">
       <div class="card-body">
        <form 
        action="{{ route('product.update',$product->ProductID) }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate
    >
    @csrf
    @method('patch')
    <div class="row">
        <div class="col mb-3">
            <label for="ProductName" class="form-label">Product Name</label> <span style="color: red">*</span>
            <input type="text" name="ProductName" id="ProductName" class="form-control" required value="{{ $product->ProductName }}">
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="ProductStrength" class="form-label">Product Strength</label> <span style="color: red">*</span>
            <input name="StudyTypeMonth" placeholder="10mg,20mg,30mg.." value="@if(isset($product->details)) {{ json_encode($previousStrength,TRUE) }} @endif" required class="form-control"> 
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
        <label for="MarketName" class="form-label">No Of Unit Per Packs</label> <span style="color: red">*</span>
        <select class="select2 form-select select2-hidden-accessible" multiple="multiple" name="packs[]" required>
            @foreach (\App\Models\Pack::all() as $pack)
            <option value="{{$pack->PackID}}" 
              @foreach ($product->packs as $pPack)
                @if ($pPack->PackID == $pack->PackID)
                {{'selected="selected"'}}
                @endif 
              @endforeach >
             {{ $pack->PackValue }} </option>               
           @endforeach    
        </select>
        </div>
    </div>

    <div class="row">
        <div class="col">
        <label for="MarketName" class="form-label">API Detail</label> <span style="color: red">*</span>
        <select class="select2 form-select select2-hidden-accessible" multiple="multiple"  name="apis[]" required>
            @foreach (\App\Models\ApiDetail::all() as $ApiDetail)
            <option value="{{$ApiDetail->ApiDetailID}}" 
              @foreach ($product->apis as $api)
                @if ($api->ApiDetailID == $ApiDetail->ApiDetailID)
                {{'selected="selected"'}}
                @endif 
              @endforeach >
             {{ $ApiDetail->ApiDetailName .'('.$ApiDetail->APIDetailSource.')' }} </option>               
           @endforeach   
        </select>
        </div>
    </div>

        <button type="submit" class="btn btn-primary">Save changes</button>

       </div>
    </div>
@endsection

@push('script')
<script>
    $(function () {
        var input = document.querySelector('input[name=StudyTypeMonth]'),
        tagify =new Tagify( input )
    });
</script>
@endpush
