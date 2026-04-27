@php
    $product   = $protocol->product;
    $strengths = $product->details->pluck('ProductStrength')->filter()->implode(', ');
    $packs     = $product->packs->pluck('PackValue')->filter()->implode(', ');
    $hasRows   = $protocol->protocolProductDetails->count() > 0;
@endphp

<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Product <span class="text-danger">*</span></label>
        <input type="text" class="form-control" disabled
               value="{{ $product->ProductName }}@if ($strengths) ({{ $strengths }})@endif @if ($packs) | Packs: {{ $packs }}@endif">
        <input type="hidden" name="ProductID" value="{{ $product->ProductID }}">
    </div>

    @forelse ($protocol->protocolProductDetails as $row)
        <div class="row g-3 align-items-end product-row">
            <div class="col-md-2">
                <label class="form-label">Strength <span class="text-danger">*</span></label>
                <select class="form-select" name="SkuID[]" required>
                    <option value="" selected disabled>Select Strength</option>
                    @foreach ($product->skus as $sku)
                        <option value="{{ $sku->SkuID }}" @selected($row->SkuID == $sku->SkuID)>{{ $sku->ProductStrength }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Specification Number <span class="text-danger">*</span></label>
                <input type="text" name="SpecificationNo[]" class="form-control" required value="{{ $row->SpecificationNo }}" placeholder="Specification No">
            </div>
            <div class="col-md-5">
                <label class="form-label">STP Number <span class="text-danger">*</span></label>
                <input type="text" name="STPNo[]" class="form-control" required value="{{ $row->STPNo }}" placeholder="STP No">
            </div>
        </div>
    @empty
    @endforelse

    <div class="row g-3 align-items-end product-clone">
        <div class="col-md-2">
            <label class="form-label">Strength <span class="text-danger">*</span></label>
            <select class="form-select" name="SkuID[]" {{ $hasRows ? '' : 'required' }}>
                <option value="" selected disabled>Select Strength</option>
                @foreach ($product->skus as $sku)
                    <option value="{{ $sku->SkuID }}">{{ $sku->ProductStrength }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Specification Number <span class="text-danger">*</span></label>
            <input type="text" name="SpecificationNo[]" class="form-control" {{ $hasRows ? '' : 'required' }} placeholder="Specification No">
        </div>
        <div class="col-md-5">
            <label class="form-label">STP Number <span class="text-danger">*</span></label>
            <input type="text" name="STPNo[]" class="form-control" {{ $hasRows ? '' : 'required' }} placeholder="STP No">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-del-product w-100" title="Remove">
                <i class="fa fa-remove"></i>
            </button>
        </div>
    </div>

    <div class="col-12">
        <button type="button" class="btn btn-outline-success btn-sm add-product">
            <i class="fa fa-plus"></i> Add Row
        </button>
    </div>

    <div class="col-12 d-flex justify-content-end mt-3">
        @if (isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4 && $protocol->ProtocolID != 10)
            <button type="button" class="btn btn-primary ajax-approval-modal-btn">Save changes</button>
        @else
            <button type="submit" class="btn btn-primary">Save changes</button>
        @endif
    </div>
</div>

@push('script')
<script>
    $(function() {
        $('.btn-del-product').hide();
        $(document).on('click', '.add-product', function() {
            var $tpl = $('.product-clone').first().clone();
            $tpl.removeClass('product-clone');
            $tpl.find('.btn-del-product').show();
            $('.product-clone').first().before($tpl);
        });
        $(document).on('click', '.btn-del-product', function() {
            $(this).closest('.product-row, .product-clone').not('.product-clone:last').remove();
        });
    });
</script>
@endpush
