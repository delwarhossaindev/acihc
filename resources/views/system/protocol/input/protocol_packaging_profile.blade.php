@php
    $product   = $protocol->product;
    $hasRows   = $protocol->packagings->count() > 0;
    $packagings = \App\Models\Packaging::all();
@endphp

<div class="row g-3">
    @foreach ($protocol->packagings as $key => $packaging)
        @php
            $primary   = $packaging->primary->pluck('ContainerID')->toArray();
            $secondary = $packaging->secondary->pluck('ContainerID')->toArray();
            $tertiary  = $packaging->tertiary->pluck('ContainerID')->toArray();
        @endphp
        <div class="row g-3 align-items-end packaging-row mb-2">
            <div class="col-md-2">
                <label class="form-label">Strength <span class="text-danger">*</span></label>
                <select class="form-select name0" name="test{{ $key }}[SkuID][]">
                    <option value="" selected disabled>Strength</option>
                    @foreach ($product->skus as $sku)
                        <option value="{{ $sku->SkuID }}" @selected($packaging->SkuID == $sku->SkuID)>{{ $sku->ProductStrength }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">Unit <span class="text-danger">*</span></label>
                <select class="form-select pack name1" name="test{{ $key }}[PackID][]" required>
                    <option value="" selected disabled>Unit</option>
                    @foreach ($product->packs as $pack)
                        <option value="{{ $pack->PackID }}" @selected($packaging->PackID == $pack->PackID)>{{ $pack->PackValue }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 primary-box">
                <label class="form-label">Primary Packaging <span class="text-danger">*</span></label>
                <select class="select2 form-select name2" multiple name="test{{ $key }}[Primary][]" required>
                    @foreach ($packagings as $pkg)
                        <option value="{{ $pkg->PackagingID }}" @selected(in_array($pkg->PackagingID, $primary))>{{ $pkg->PackagingName }} === {{ $pkg->PackagingSource }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 secondary-box">
                <label class="form-label">Secondary Packaging</label>
                <select class="select2 form-select name3" multiple name="test{{ $key }}[Secondary][]">
                    @foreach ($packagings as $pkg)
                        <option value="{{ $pkg->PackagingID }}" @selected(in_array($pkg->PackagingID, $secondary))>{{ $pkg->PackagingName }} === {{ $pkg->PackagingSource }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 tertiary-box">
                <label class="form-label">Tertiary Packaging</label>
                <select class="select2 form-select name4" multiple name="test{{ $key }}[Tertiary][]">
                    @foreach ($packagings as $pkg)
                        <option value="{{ $pkg->PackagingID }}" @selected(in_array($pkg->PackagingID, $tertiary))>{{ $pkg->PackagingName }} === {{ $pkg->PackagingSource }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach

    <div class="row g-3 align-items-end select_packaging_matirials duplicable mb-2">
        <div class="col-md-1">
            <label class="form-label">Snt <span class="text-danger">*</span></label>
            <select class="form-select name0" name="test[SkuID][]" {{ $hasRows ? '' : 'required' }}>
                <option value="" selected disabled>Snt</option>
                @foreach ($product->skus as $sku)
                    <option value="{{ $sku->SkuID }}">{{ $sku->ProductStrength }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label class="form-label">Unit <span class="text-danger">*</span></label>
            <select class="form-select pack name1" name="test[PackID][]" {{ $hasRows ? '' : 'required' }}>
                <option value="" selected disabled>Unit</option>
                @foreach ($product->packs as $pack)
                    <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 primary-box">
            <label class="form-label">Primary Packaging <span class="text-danger">*</span></label>
            <select class="select2 form-select name2" multiple name="test[Primary][]" {{ $hasRows ? '' : 'required' }}>
                @foreach ($packagings as $pkg)
                    <option value="{{ $pkg->PackagingID }}">{{ $pkg->PackagingName }} === {{ $pkg->PackagingSource }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 secondary-box">
            <label class="form-label">Secondary Packaging</label>
            <select class="select2 form-select name3" multiple name="test[Secondary][]">
                @foreach ($packagings as $pkg)
                    <option value="{{ $pkg->PackagingID }}">{{ $pkg->PackagingName }} === {{ $pkg->PackagingSource }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 tertiary-box">
            <label class="form-label">Tertiary Packaging</label>
            <select class="select2 form-select name4" multiple name="test[Tertiary][]">
                @foreach ($packagings as $pkg)
                    <option value="{{ $pkg->PackagingID }}">{{ $pkg->PackagingName }} === {{ $pkg->PackagingSource }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-del-packaging w-100" title="Remove">
                <i class="fa fa-remove"></i>
            </button>
        </div>
    </div>

    <div class="col-12">
        <button type="button" class="btn btn-outline-success btn-sm" id="add-packaging-profile">
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
        $('.btn-del-packaging').hide();
        $(document).on('click', '#add-packaging-profile', function() {
            var $parent = $(this).parent().parent();
            $parent.find('.primary-box select, .secondary-box select, .tertiary-box select').select2('destroy');
            $parent.find('.duplicable').clone()
                .insertBefore($(this).parent())
                .removeClass('duplicable')
                .find(':not(select).form-control').val('');
            $parent.find('.primary-box select, .secondary-box select, .tertiary-box select').select2();
            $('.btn-del-packaging').fadeIn();
            $parent.find('.btn-del-packaging').click(function() {
                $(this).closest('.packaging-row, .select_packaging_matirials').remove();
            });
            $('.name0').each(function(i) { this.name = i + '[SkuID][]'; });
            $('.name1').each(function(i) { this.name = i + '[PackID][]'; });
            $('.name2').each(function(i) { this.name = i + '[Primary][]'; });
            $('.name3').each(function(i) { this.name = i + '[Secondary][]'; });
            $('.name4').each(function(i) { this.name = i + '[Tertiary][]'; });
        });
    });
</script>
@endpush
