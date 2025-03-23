@php
   if(isset($protocol)){
        $product = $protocol->product;
    }
@endphp

@if(isset($protocol))
<div class="row g-3">
    @if($protocol->packagings->count() > 0)
    @foreach ($protocol->packagings as $key => $packaging)
    @php
        $primary = $packaging->primary->pluck('ContainerID');
        $secondary = $packaging->secondary->pluck('ContainerID');
        $tertiary = $packaging->tertiary->pluck('ContainerID');
        //dd($ContainerID);
    @endphp
        <div class="col-md-2 mt-3">
            <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="custom-select form-control name0" name="test{{ $key }}[SkuID][]" id="SkuID">
                <option value="" selected disabled>Strength</option>
                @foreach ($product->skus as $sku)
                <option value="{{ $sku->SkuID }}" {{ $packaging->SkuID == $sku->SkuID ? 'selected' : '' }}>{{ $sku->ProductStrength }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-1 mt-3">
            <label for="PackID" class="form-label">Unit</label> <span style="color: red">*</span>
            <select class="form-control pack name1" name="test{{ $key }}[PackID][]" required>
                <option value="" selected disabled>Unit</option>
                @foreach ($product->packs as $pack)
                    <option value="{{ $pack->PackID }}" {{ $packaging->PackID == $pack->PackID ? 'selected' : '' }}>{{ $pack->PackValue }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-3 mt-3 primary-box">
            <label for="" class="form-label">Primary Packaging</label> <span style="color: red">*</span>
            <select class="select2 form-select form-select-lg select2-hidden-accessible name2" multiple name="test{{ $key }}[Primary][]" required id="">
                <option value="" disabled>Primary</option>
                @foreach (\App\Models\Packaging::all() as $packaging)
                <option value="{{ $packaging->PackagingID }}" {{ in_array($packaging->PackagingID, $primary->toArray(), ) ? 'selected' : '' }}>{{ $packaging->PackagingName .'==='. $packaging->PackagingSource}}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-3 mt-3 secondary-box">
            <label for="PackID" class="form-label">Secondary Packaging</label>
            <select class="select2 form-select form-select-lg select2-hidden-accessible name3" multiple name="test{{ $key }}[Secondary][]">
                <option value="" disabled>Secondary</option>
                @foreach (\App\Models\Packaging::all() as $packaging)
                <option value="{{ $packaging->PackagingID }}" {{ in_array($packaging->PackagingID, $secondary->toArray(), ) ? 'selected' : '' }}>{{ $packaging->PackagingName .'==='. $packaging->PackagingSource}}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-3 mt-3 tertiary-box">
            <label for="ContainerType" class="form-label">Tertiary Packaging</label>
            <select class="select2 form-select form-select-lg select2-hidden-accessible name4" multiple name="test{{ $key }}[Tertiary][]">
                <option value="" disabled>Tertiary</option>
                @foreach (\App\Models\Packaging::all() as $packaging)
                <option value="{{ $packaging->PackagingID }}" {{ in_array($packaging->PackagingID, $tertiary->toArray(), ) ? 'selected' : '' }}>{{ $packaging->PackagingName .'==='. $packaging->PackagingSource}}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
    @endforeach
    @endif

    <div class="row select_packaging_matirials duplicable">
        <div class="col-md-1 mt-3">
            <label for="SkuID" class="form-label">Snt</label> <span style="color: red">*</span>
            <select class="custom-select form-control name0" name="test[SkuID][]" id="SkuID" {{ $protocol->packagings->count() > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Snt</option>
                @foreach ($product->skus as $sku)
                <option value="{{ $sku->SkuID }}">{{ $sku->ProductStrength }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-1 mt-3">
            <label for="PackID" class="form-label">Unit</label> <span style="color: red">*</span>
            <select class="form-control pack name1" name="test[PackID][]" {{ $protocol->packagings->count() > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Unit</option>
                @foreach ($product->packs as $pack)
                    <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-3 mt-3 primary-box">
            <label for="" class="form-label">Primary Packaging</label> <span style="color: red">*</span>
            <select class="select2 form-select form-select-lg select2-hidden-accessible name2" multiple name="test[Primary][]" {{ $protocol->packagings->count() > 0 ? '' : 'required' }} id="">
                <option value="" disabled>Primary</option>
                @foreach (\App\Models\Packaging::all() as $packaging)
                <option value="{{ $packaging->PackagingID }}">{{ $packaging->PackagingName .'==='. $packaging->PackagingSource}}
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-3 mt-3 secondary-box">
            <label for="PackID" class="form-label">Secondary Packaging</label>
            <select class="select2 form-select form-select-lg select2-hidden-accessible name3" multiple name="test[Secondary][]">
                <option value="" disabled>Secondary</option>
                @foreach (\App\Models\Packaging::all() as $packaging)
                <option value="{{ $packaging->PackagingID }}">{{ $packaging->PackagingName .'==='. $packaging->PackagingSource}}
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-3 mt-3 tertiary-box">
            <label for="ContainerType" class="form-label">Tertiary Packaging</label>
            <select class="select2 form-select form-select-lg select2-hidden-accessible name4" multiple name="test[Tertiary][]">
                <option value="" disabled>Tertiary</option>
                @foreach (\App\Models\Packaging::all() as $packaging)
                <option value="{{ $packaging->PackagingID }}">{{ $packaging->PackagingName .'==='. $packaging->PackagingSource}}
                @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col-md-1" style="margin-top: 40px">
            <span class="btn btn-danger btn-xs pull-right btn-del-packaging"><i class="fa fa-remove"></i></span>
        </div>
    </div>
    <div class="col-md-2 mt-3" style="margin-left: 5px;">
        <span class="btn btn-success btn-xs" id="add-packaging-profile"><i class="fa fa-add"></i></span>
    </div>
    <div class="modal-footer">
        @if(isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)

        <button type="submit" class="btn btn-primary" id="saveChangesBtnPackagingProfile" style="visibility: hidden;">Save changes</button>
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
        $('.btn-del-packaging').hide();
        $(document).on('click','#add-packaging-profile', function(){
            $(this).parent().parent().find(".primary-box select").select2("destroy");
            $(this).parent().parent().find(".secondary-box select").select2("destroy");
            $(this).parent().parent().find(".tertiary-box select").select2("destroy");
            $(this).parent().parent().find(".duplicable").clone().insertBefore($(this).parent()).removeClass("duplicable").find(":not(select).form-control").val("");
            $(this).parent().parent().find(".primary-box select").select2();
            $(this).parent().parent().find(".secondary-box select").select2();
            $(this).parent().parent().find(".tertiary-box select").select2();
            $('.btn-del-packaging').fadeIn();
            $(this).parent().parent().find(".btn-del-packaging").click(function(e) {
                $(this).parent().parent().remove();
            });
            $( ".name0" ).each(
                function( index ) {
                    this.name = `${index}[SkuID][]`;
                }
            );
            $( ".name1" ).each(
                function( index ) {
                    this.name = `${index}[PackID][]`;
                }
            );
            $( ".name2" ).each(
                function( index ) {
                    this.name = `${index}[Primary][]`;
                }
            );
            $( ".name3" ).each(
                function( index ) {
                    this.name = `${index}[Secondary][]`;
                }
            );
            $( ".name4" ).each(
                function( index ) {
                    this.name = `${index}[Tertiary][]`;
                }
            );
        });
    });
</script>
@endpush
