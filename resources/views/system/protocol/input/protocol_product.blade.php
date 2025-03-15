@php 
if(isset($protocol)){
    $product = $protocol->product;
}
@endphp
@if(isset($protocol))
<div class="row g-3">
    <div class="col-md-12 col-sm-6">
        <label for="ProductID" class="form-label">Product</label> <span style="color: red">*</span>
        <input type="text" class="form-control" required value="{{ isset($protocol) ? $protocol->product->ProductName : '' }} @if(isset($protocol))@foreach ($protocol->product->details as $strength)({{ $strength->ProductStrength }})@endforeach | Packs: @foreach ($protocol->product->packs as $pack) ({{ $pack->PackValue }}) @endforeach @endif" disabled>
        <input type="hidden" name="ProductID" id="ProductID" class="form-control" required value="{{ isset($protocol) ? $protocol->product->ProductID : '' }}">
        <div class="invalid-tooltip">This field is required</div>
    </div>
    @if($protocol->protocolProductDetails->count() > 0)
    <div class="row mt-3">
        @forelse ($protocol->protocolProductDetails as $protocolProduct)
        <div class="col-md-2">
            <label for="Strength" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="custom-select form-control" name="SkuID[]" required id="SkuIDList">
                <option value="" selected disabled>Select Strength</option>
                @if(isset($protocol))
                @foreach ($protocol->product->skus as $sku)
                <option value="{{ $sku->SkuID }}" {{ $protocolProduct->SkuID == $sku->SkuID ? 'selected' : '' }}>
                    {{ $sku->ProductStrength }}
                </option>
                @endforeach
                @endif
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col-md-4">
            <label for="SpecificationNo" class="form-label">Specification Number</label> <span style="color: red">*</span>
            <input type="text" name="SpecificationNo[]" id="SpecificationNo" class="form-control" required value="{{ isset($protocol) ? $protocolProduct->SpecificationNo : '' }}" placeholder="Specification No">
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col-md-5">
            <label class="form-label" for="Purpose">STP Number</label> <span style="color: red">*</span>
            <input type="text" id="STPNo" name="STPNo[]" class="form-control" placeholder="STPNo" required value="{{ isset($protocol) ? $protocolProduct->STPNo : '' }}">
            <div class="invalid-tooltip">This field is required</div>
        </div>
        {{-- <div class="col-md-1" style="margin-top: 35px;">
            <span class="btn btn-danger btn-xs pull-right btn-del-product"><i class="fa fa-remove"></i></span>
        </div> --}}
        @empty
        @endforelse
    </div>
    @endif
    <div class="row mt-3 product-clone">
        <div class="col-md-2">
            <label for="Strength" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="custom-select form-control" name="SkuID[]" id="SkuIDList" {{ $protocol->protocolProductDetails->count() > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Select Strength</option>
                @if(isset($protocol))
                @foreach ($protocol->product->skus as $sku)
                <option value="{{ $sku->SkuID }}">
                    {{ $sku->ProductStrength }}
                </option>
                @endforeach
                @endif
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col-md-4">
            <label for="SpecificationNo" class="form-label">Specification Number</label> <span style="color: red">*</span>
            <input type="text" name="SpecificationNo[]" id="SpecificationNo" class="form-control" {{ $protocol->protocolProductDetails->count() > 0 ? '' : 'required' }} placeholder="Specification No">
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col-md-5">
            <label class="form-label" for="Purpose">STP Number</label> <span style="color: red">*</span>
            <input type="text" id="STPNo" name="STPNo[]" class="form-control" placeholder="STPNo" {{ $protocol->protocolProductDetails->count() > 0 ? '' : 'required' }}>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col-md-1" style="margin-top: 35px;">
            <span class="btn btn-danger btn-xs pull-right btn-del-product"><i class="fa fa-remove"></i></span>
        </div>
    </div>
    <div class="col-md-2" style="margin-left: 5px;">
        <span class="btn btn-success btn-xs add-product"><i class="fa fa-add"></i></span>
    </div>
    <div class="modal-footer">
    @if(isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)
        <button data-toggle='modal' data-target='#dynamicApprovalModal'  class='btn btn-primary  dynamic-approval-modal-btn ajax-approval-modal-btn'>Save changes</button>
        @else
        <button type="submit" class="btn btn-primary">Save changes</button>
        @endif
    </div>
</div>
@else 
<p>Please create a protocol first!</p>
@endif

@push('script')
    <script>
     $(function () {
        $('.btn-del-product').hide();
        $(document).on('click','.add-product', function(){
            $(this).parent().parent().find(".product-clone").clone().insertBefore($(this).parent()).removeClass("product-clone");
            $('.btn-del-product').fadeIn();
            $(this).parent().parent().find(".btn-del-product").click(function(e) {
                $(this).parent().parent().remove(); 
            });
        });
    });
    </script>
@endpush