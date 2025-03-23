@php
    if (isset($protocol)) {
        $product = $protocol->product;
        $ptSkuCount = $protocol->sku->count();
    }
@endphp

@if (isset($protocol))
    <div class="row g-3">
        <div class="row">
            @if ($ptSkuCount > 0)
                @foreach ($protocol->sku as $key => $value)
                    @php
                        $PackID = $value->perUnitContainer->pluck('PackID');
                    @endphp
                    <div class="col-md-6 mt-3">
                        <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
                        <select class="custom-select form-control dynamic-order1" name="test{{ $key }}[SkuID][]"
                            required id="SkuID">
                            <option value="" selected disabled>Strength</option>
                            @foreach ($product->skus as $sku)
                                <option value="{{ $sku->SkuID }}"
                                    {{ $value->SkuID == $sku->SkuID ? 'selected' : '' }}>{{ $sku->ProductStrength }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-tooltip">Required</div>
                    </div>
                    <div class="col-md-6 mt-3 pack-box">
                        <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
                        <select class="select2 form-select form-select-lg select2-hidden-accessible pack dynamic-order2"
                            name="test{{ $key }}[PackID][]" required>
                            <option value="" disabled>Unit Pack</option>
                            @foreach ($product->packs as $pack)
                                <option value="{{ $pack->PackID }}"
                                    {{ in_array($pack->PackID, $PackID->toArray()) ? 'selected' : '' }}>
                                    {{ $pack->PackValue }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-tooltip">Required</div>
                    </div>
                    <div class="col-md-12 mt-3 container-box">
                        <label for="ContainerType" class="form-label">Packaging Type</label> <span
                            style="color: red">*</span>
                        <select class="select2 form-select form-select-lg select2-hidden-accessible dynamic-order3"
                            name="test{{ $key }}[ContainerType][]" required>
                            <option value="" disabled selected>Select Packaging</option>
                            @foreach (\App\Models\Container::all() as $container)
                                <option value="{{ $container->ContainerID }}"
                                    {{ $value->ContainerID == $container->ContainerID ? 'selected' : '' }}>
                                    {{ $container->ContainerType . '====' . implode('-', $container->packaging->pluck('PackagingName')->toArray()) }}
                                    @foreach ($container->packaging as $packaging)
                                        {{ '====' . $packaging->PackagingSource }}
                                    @endforeach
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-tooltip">This field is required</div>
                    </div>
                @endforeach
            @endif
            <div class="row select_packaging_matirials duplicable">
                <div class="col-md-6 mt-3">
                    <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
                    <select class="custom-select form-control dynamic-order1" name="test[SkuID][]"
                        {{ $ptSkuCount > 0 ? '' : 'required' }} id="SkuID">
                        <option value="" selected disabled>Strength</option>
                        @foreach ($product->skus as $sku)
                            <option value="{{ $sku->SkuID }}">{{ $sku->ProductStrength }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>
                <div class="col-md-6 mt-3 pack-box">
                    <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
                    <select class="select2 form-select form-select-lg select2-hidden-accessible pack dynamic-order2"
                        name="test[PackID][]" {{ $ptSkuCount > 0 ? '' : 'required' }}>
                        <option value="" disabled>Unit Pack</option>
                        @foreach ($product->packs as $pack)
                            <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>
                <div class="col-md-11 mt-3 container-box">
                    <label for="ContainerType" class="form-label">Packaging Type</label> <span
                        style="color: red">*</span>
                    <select class="select2 form-select form-select-lg select2-hidden-accessible dynamic-order3"
                        name="test[ContainerType][]" {{ $ptSkuCount > 0 ? '' : 'required' }}>
                        <option value="" disabled selected>Select Packaging</option>
                        @foreach (\App\Models\Container::all() as $container)
                            <option value="{{ $container->ContainerID }}">
                                {{ $container->ContainerType . '====' . implode('-', $container->packaging->pluck('PackagingName')->toArray()) . '====' . (isset($packaging) ? $packaging->PackagingSource : '') }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">This field is required</div>
                </div>

                <div class="col-md-1" style="margin-top: 43px;">
                    <span class="btn btn-danger btn-xs pull-right btn-del"><i class="fa fa-remove"></i></span>
                </div>
            </div>
            <div class="col-md-2 mt-3" style="margin-left: 5px;">
                <span class="btn btn-success btn-xs add-feature" id="add-feature"><i class="fa fa-add"></i></span>
            </div>
            @if(isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)

            <button type="submit" class="btn btn-primary" id="saveChangesBtnPackagingMaterials" style="visibility: hidden;">Save changes</button>
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
        $(function() {
            $('.btn-del').hide();
            $(document).on('click', '.add-feature', function() {
                $(this).parent().parent().find(".container-box select").select2("destroy");
                $(this).parent().parent().find(".pack-box select").select2("destroy");
                $(this).parent().parent().find(".duplicable").clone().insertBefore($(this).parent())
                    .removeClass("duplicable").find(":not(select).form-control").val("");
                $(this).parent().parent().find(".container-box select").select2();
                $(this).parent().parent().find(".pack-box select").select2();
                $('.btn-del').fadeIn();
                $(this).parent().parent().find(".btn-del").click(function(e) {
                    $(this).parent().parent().remove();
                });
                $(".dynamic-order1").each(
                    function(index) {
                        this.name = `${index}[SkuID][]'`;
                    }
                );
                $(".dynamic-order2").each(
                    function(index) {
                        this.name = `${index}[PackID][]'`;
                    }
                );
                $(".dynamic-order3").each(
                    function(index) {
                        this.name = `${index}[ContainerType][]'`;
                    }
                );
            });
        });
    </script>
@endpush
