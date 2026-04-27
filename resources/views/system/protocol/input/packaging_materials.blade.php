@php
    $product    = $protocol->product;
    $ptSkuCount = $protocol->sku->count();
@endphp

<div class="row g-3">
    @foreach ($protocol->sku as $key => $value)
        @php $packIds = $value->perUnitContainer->pluck('PackID')->toArray(); @endphp
        <div class="row g-3 align-items-end material-row mb-2">
            <div class="col-md-6">
                <label class="form-label">Strength <span class="text-danger">*</span></label>
                <select class="form-select dynamic-order1" name="test{{ $key }}[SkuID][]" required>
                    <option value="" selected disabled>Strength</option>
                    @foreach ($product->skus as $sku)
                        <option value="{{ $sku->SkuID }}" @selected($value->SkuID == $sku->SkuID)>{{ $sku->ProductStrength }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 pack-box">
                <label class="form-label">Unit Pack <span class="text-danger">*</span></label>
                <select class="select2 form-select pack dynamic-order2" name="test{{ $key }}[PackID][]" required>
                    <option value="" disabled>Unit Pack</option>
                    @foreach ($product->packs as $pack)
                        <option value="{{ $pack->PackID }}" @selected(in_array($pack->PackID, $packIds))>{{ $pack->PackValue }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 container-box">
                <label class="form-label">Packaging Type <span class="text-danger">*</span></label>
                <select class="select2 form-select dynamic-order3" name="test{{ $key }}[ContainerType][]" required>
                    <option value="" disabled selected>Select Packaging</option>
                    @foreach (\App\Models\Container::all() as $container)
                        @php
                            $names   = $container->packaging->pluck('PackagingName')->implode('-');
                            $sources = $container->packaging->pluck('PackagingSource')->filter()->implode('-');
                        @endphp
                        <option value="{{ $container->ContainerID }}" @selected($value->ContainerID == $container->ContainerID)>
                            {{ $container->ContainerType }} {{ $names ? '== '.$names : '' }} {{ $sources ? '== '.$sources : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach

    <div class="row g-3 align-items-end select_packaging_matirials duplicable mb-2">
        <div class="col-md-6">
            <label class="form-label">Strength <span class="text-danger">*</span></label>
            <select class="form-select dynamic-order1" name="test[SkuID][]" {{ $ptSkuCount > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Strength</option>
                @foreach ($product->skus as $sku)
                    <option value="{{ $sku->SkuID }}">{{ $sku->ProductStrength }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 pack-box">
            <label class="form-label">Unit Pack <span class="text-danger">*</span></label>
            <select class="select2 form-select pack dynamic-order2" name="test[PackID][]" {{ $ptSkuCount > 0 ? '' : 'required' }}>
                <option value="" disabled>Unit Pack</option>
                @foreach ($product->packs as $pack)
                    <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-11 container-box">
            <label class="form-label">Packaging Type <span class="text-danger">*</span></label>
            <select class="select2 form-select dynamic-order3" name="test[ContainerType][]" {{ $ptSkuCount > 0 ? '' : 'required' }}>
                <option value="" disabled selected>Select Packaging</option>
                @foreach (\App\Models\Container::all() as $container)
                    @php $names = $container->packaging->pluck('PackagingName')->implode('-'); @endphp
                    <option value="{{ $container->ContainerID }}">
                        {{ $container->ContainerType }} {{ $names ? '== '.$names : '' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-del w-100" title="Remove">
                <i class="fa fa-remove"></i>
            </button>
        </div>
    </div>

    <div class="col-12">
        <button type="button" class="btn btn-outline-success btn-sm add-feature" id="add-feature">
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
        $('.btn-del').hide();
        $(document).on('click', '.add-feature', function() {
            var $parent = $(this).parent().parent();
            $parent.find('.container-box select').select2('destroy');
            $parent.find('.pack-box select').select2('destroy');
            $parent.find('.duplicable').clone()
                .insertBefore($(this).parent())
                .removeClass('duplicable')
                .find(':not(select).form-control').val('');
            $parent.find('.container-box select').select2();
            $parent.find('.pack-box select').select2();
            $('.btn-del').fadeIn();
            $parent.find('.btn-del').click(function() {
                $(this).closest('.material-row, .select_packaging_matirials').remove();
            });
            $('.dynamic-order1').each(function(i) { this.name = i + '[SkuID][]'; });
            $('.dynamic-order2').each(function(i) { this.name = i + '[PackID][]'; });
            $('.dynamic-order3').each(function(i) { this.name = i + '[ContainerType][]'; });
        });
    });
</script>
@endpush
