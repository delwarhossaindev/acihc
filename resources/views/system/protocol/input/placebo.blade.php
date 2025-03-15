@php 
    if(isset($protocol)){
        $product = $protocol->product;
        $sdType = $protocol->statbilityStudy;
        if(isset($sdType)){
            $studyTypes = App\Models\StudyType::whereIn('StudyTypeID',$sdType->pluck('StudyTypeID'))->get();

            $months = $protocol->statbilityStudy->pluck('testingTimePoints')->flatten();
            $monthName = [];
            foreach ($months as $key => $month) {
                $monthName[$key] = $month->TestingMonth;
            }
            $SortedMonths = array_unique($monthName);
            sort($SortedMonths);
        }
        $loopCount = $protocol->protocolSkuUnitPack()->count();
    }
@endphp

@if(isset($protocol->statbilityStudy))
<div class="row g-3">
    @foreach ($protocol->protocolPlacebo as $key => $placebo)
    @php 
       $months = @App\Models\ProtocolPlaceboDetail::where('PlaceboID',$placebo->PlaceboID)->pluck('Month');
       $StudyTypes = @App\Models\ProtocolPlaceboDetail::where('PlaceboID',$placebo->PlaceboID)->pluck('StudyTypeID');
       $counts = @App\Models\ProtocolPlaceboDetail::where('PlaceboID',$placebo->PlaceboID)->pluck('Count');
       $Aditionals = @App\Models\ProtocolPlaceboDetail::where('PlaceboID',$placebo->PlaceboID)->pluck('AditionalSample');
    @endphp
        <div class="col-md-2 mt-3">
            <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="form-control SkuID" name="test{{ $key }}[SkuID][]" required>
                <option value="" selected disabled>Strength</option>
                @foreach ($product->details as $productDetail)
                    <option value="{{ $productDetail->SkuID }}" {{ $placebo->SkuID == $productDetail->SkuID ? 'selected' : '' }}>{{ $productDetail->ProductStrength }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3">
            <label for="PackID" class="form-label">Unit Pack</label><span style="color: red">*</span>
            <select class="form-control PackID" name="test{{ $key }}[PackID][]" required>
                <option value="" selected disabled>Select Pack</option>
                @foreach ($product->packs as $pack)
                <option value="{{ $pack->PackID }}" {{ $placebo->PackID == $pack->PackID ? 'selected' : '' }}>{{ $pack->PackValue }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div> 
        <div class="col-md-2 mt-3">
            <label for="PackBottleNumber" class="form-label">Month</label><span style="color: red">*</span>
            <select class="form-control Month" name="test{{ $key }}[Month][]" required>
                <option value="" selected disabled>Month</option>
                @foreach ($SortedMonths as $month)
                    <option value="{{ $month  }}" {{ in_array($month,array_unique($months->toArray())) ? 'selected' : ''}} >{{ $month }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3 testing-pack">
            <label for="StudTypeID" class="form-label">Condition</label> <span style="color: red">*</span>
            <select class="select2 form-select form-select-lg select2-hidden-accessible StudTypeID" multiple name="test{{ $key }}[StudTypeID][]" required>
                <option value="" disabled>Condition</option>
                @foreach ($studyTypes as $ss)
                    <option value="{{ $ss->StudyTypeID  }}" {{ in_array($ss->StudyTypeID,array_unique($StudyTypes->toArray())) ? 'selected' : ''}}>{{ $ss->StudyTypeName }}({{ implode( " ",$ss->details->pluck('StudyTypeMonth')->toArray()) }})</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        
        <div class="col-md-2 mt-3">
            <label for="Unit" class="form-label">No. Of Container</label> <span style="color: red">*</span>
            <input type="text" min="0" name="test{{ $key }}[Unit][]" class="form-control Unit" placeholder="Unit per test" required value="{{ implode(",",$counts->toArray()) }}">
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3">
            <label for="AditionalSample" class="form-label">Additional</label> 
            <input type="number" name="test{{ $key }}[AditionalSample][]" class="form-control AditionalSample" placeholder="Aditional" min="0" value="{{ implode(",",array_unique($Aditionals->toArray())) }}">
            <div class="invalid-tooltip">Required</div>
        </div> 
        
    @endforeach

    <div class="row placebo-design">
        <div class="col-md-2 mt-3">
            <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
            <select class="form-control SkuID" name="test[SkuID][]" {{ $protocol->protocolSkuUnitPack()->count() > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Strength</option>
                @foreach ($product->details as $productDetail)
                    <option value="{{ $productDetail->SkuID }}">{{ $productDetail->ProductStrength }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3">
            <label for="PackID" class="form-label">Unit Pack</label><span style="color: red">*</span>
            <select class="form-control PackID" name="test[PackID][]" {{ $protocol->protocolSkuUnitPack()->count() > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Select Pack</option>
                @foreach ($product->packs as $pack)
                <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div> 
        <div class="col-md-2 mt-3">
            <label for="PackBottleNumber" class="form-label">Month</label><span style="color: red">*</span>
            <select class="form-control Month" name="test[Month][]" {{ $protocol->protocolSkuUnitPack()->count() > 0 ? '' : 'required' }}>
                <option value="" selected disabled>Month</option>
                @foreach ($SortedMonths as $month)
                    <option value="{{ $month  }}">{{ $month }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3 testing-pack">
            <label for="StudTypeID" class="form-label">Condition</label> <span style="color: red">*</span>
            <select class="select2 form-select form-select-lg select2-hidden-accessible StudTypeID" multiple name="test[StudTypeID][]" {{ $protocol->protocolSkuUnitPack()->count() > 0 ? '' : 'required' }}>
                <option value="" disabled>Condition</option>
                @foreach ($studyTypes as $ss)
                    <option value="{{ $ss->StudyTypeID  }}">{{ $ss->StudyTypeName }}({{ implode( " ",$ss->details->pluck('StudyTypeMonth')->toArray()) }})</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3">
            <label for="Unit" class="form-label">No. Of Container</label> <span style="color: red">*</span>
            <input type="text" min="0" name="test[Unit][]" class="form-control Unit" placeholder="Unit per test" {{ $protocol->protocolSkuUnitPack()->count() > 0 ? '' : 'required' }} >
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col-md-2 mt-3">
            <label for="AditionalSample" class="form-label">Additional</label> 
            <input type="number" name="test[AditionalSample][]" class="form-control AditionalSample" placeholder="Aditional" min="0">
            <div class="invalid-tooltip">Required</div>
        </div>
        <div class="col" style="margin-top: 43px;">
            <span class="btn btn-danger btn-xs pull-right btn-del-placebo"><i class="fa fa-remove"></i></span>
        </div>
    </div>
    <div class="col-md-2" style="margin-left: 5px;">
        <span class="btn btn-success btn-xs add-placebo"><i class="fa fa-add"></i></span>
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
<p>Please create a protocol & statbilty study first!</p>
@endif

@push('script')
<script>
    $(function () {
        $('.btn-del-placebo').hide();
        $(document).on('click','.add-placebo', function(){
            $(this).parent().parent().find(".testing-pack select").select2("destroy");
            $(this).parent().parent().find(".placebo-design").clone().insertBefore($(this).parent()).removeClass("placebo-design").find(":not(select).form-control").val("");
            $(this).parent().parent().find(".testing-pack select").select2();
            $('.btn-del-placebo').fadeIn();
            $(this).parent().parent().find(".btn-del-placebo").click(function(e) {
                $(this).parent().parent().remove(); 
            });

            $( ".SkuID" ).each(
                function( index ) {
                    this.name = `${index}[SkuID][]`;
                }
            );
            $( ".PackID" ).each(
                function( index ) {
                    this.name = `${index}[PackID][]`;
                }
            );
            $( ".StudTypeID" ).each(
                function( index ) {
                    this.name = `${index}[StudTypeID][]`;
                }
            );
            $( ".Unit" ).each(
                function( index ) {
                    this.name = `${index}[Unit][]`;
                }
            );
            $( ".Month" ).each(
                function( index ) {
                    this.name = `${index}[Month][]`;
                }
            );
            $( ".AditionalSample" ).each(
                function( index ) {
                    this.name = `${index}[AditionalSample][]`;
                }
            );
        });
    });
</script>
@endpush