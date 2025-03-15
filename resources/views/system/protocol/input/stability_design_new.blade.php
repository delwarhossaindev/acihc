@php
    if (isset($protocol)) {
        $product = $protocol->product;
        $sdType = $protocol->statbilityStudy;
        if (isset($sdType)) {
            $studyTypes = App\Models\StudyType::whereIn('StudyTypeID', $sdType->pluck('StudyTypeID'))->get();

            $months = $protocol->statbilityStudy->pluck('testingTimePoints')->flatten();
            $monthName = [];
            foreach ($months as $key => $month) {
                $monthName[$key] = $month->TestingMonth;
            }
            $SortedMonths = array_unique($monthName);
            sort($SortedMonths);
        }
        $loopCount = $protocol->protocolSkuUnitPack()->count();

        $getData = \DB::table('StabilityDesignTitle')
            ->where('ProtocolID', $protocol->ProtocolID)
            ->first();

        $stabilityDesignTitle = isset($getData->Title) ? unserialize($getData->Title) : null;
    }
@endphp

@if (isset($protocol) && $protocol->statbilityStudy()->count() > 0)
    <div class="row ">

        @forelse ($protocol->statbilityStudy as $statbility)
            @php
                $duration = $statbility->study->details->pluck('StudyTypeMonth');
            @endphp
        @empty
        @endforelse

        @foreach ($duration as $key => $item)
            <div class="col-md-2 mt-3">
                <label for="Value" class="form-label">{{ $item }} Title</label>
                <span style="color: red">*</span>
                <input type="text" class="form-control" name="title[]" value="{{ $stabilityDesignTitle[$key] ?? null }}"
                    required style="margin-right:15px;">
            </div>
        @endforeach



        <hr style="margin-top:30px;">

        <div class="col-12">

            @if (isset($protocol->protocolSkuUnitPack) && $protocol->protocolSkuUnitPack()->count() > 0)

                @foreach ($protocol->protocolSkuUnitPack as $key => $protocolSkuUnitPack)

                @php
                    $monthArray = json_decode($protocolSkuUnitPack->Month, true);
                @endphp

                    <div class="row stability-chamber-design">
                        <div class="col-md-2 mt-3">
                            <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
                            <select class="form-control SkuID" name="0[SkuID][]" required>
                                <option value="" selected disabled>Strength</option>
                                @foreach ($product->details as $productDetail)
                                    <option value="{{ $productDetail->SkuID }}" {{ $protocolSkuUnitPack->SkuID == $productDetail->SkuID ? 'selected' : '' }}>{{ $productDetail->ProductStrength }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="PackID" class="form-label">Unit Pack</label><span style="color: red">*</span>
                            <select class="form-control PackID" name="0[PackID][]" required>
                                <option value="" selected disabled>Pack</option>
                                @foreach ($product->packs as $pack)
                                    <option value="{{ $pack->PackID }}" {{ $protocolSkuUnitPack->PackID == $pack->PackID ? 'selected' : '' }}>{{ $pack->PackValue }}</option>
                                @endforeach
                            </select>
                        </div>

                        @forelse ($protocol->statbilityStudy as $statbility)
                            @php
                                $duration = $statbility->study->details->pluck('StudyTypeMonth');
                            @endphp
                        @empty
                        @endforelse
                        @foreach ($duration as $key1 => $item)
                        <div class="col-md-2 mt-3">
                            <label for="Value" class="form-label">{{ $item }}</label>
                            <span style="color: red">*</span>
                            <input type="text" class="form-control StudyTypeMonth"
                                name="0[StudyTypeMonth][]"
                                value="{{ $monthArray[$key1] ?? '' }}"
                                required style="margin-right:15px;">
                        </div>
                    @endforeach

                        <div class="col-md-2 mt-3">
                            <label for="Value" class="form-label">Additional</label>
                            <input type="number" class="form-control" id="Additional"  name="0[Additional][]"
                            value = {{ $protocolSkuUnitPack->Additional }}
                                style="margin-right:15px;">
                        </div>
                        <div class="col" style="margin-top: 43px;">
                            <span class="btn btn-danger btn-xs pull-right btn-del-chamber"><i
                                    class="fa fa-remove"></i></span>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-2 mt-3">
                        <label class="form-label" style="margin-top: 34px">Placebo Strength</label>
                    </div>
                    @foreach ($duration as $key => $item)
                        <div class="col-md-2 mt-3">
                            <label for="Value" class="form-label">{{ $item }}</label>
                            <input type="text" class="form-control PlaceboMonth" name="PlaceboMonth[]"
                               style="margin-right:15px;">
                        </div>
                    @endforeach

                    <div class="col-md-2 mt-3">
                        <label for="Value" class="form-label">Placebo Additional</label>
                        <input type="number" class="form-control" id="Additional" name="PlaceboAdditional"
                            style="margin-right:15px;">
                    </div>
                </div>
            @else
                <div class="row stability-chamber-design">
                    <div class="col-md-2 mt-3">
                        <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
                        <select class="form-control SkuID" name="0[PlaceboSkuID][]" required>
                            <option value="" selected disabled>Strength</option>
                            @foreach ($product->details as $productDetail)
                                <option value="{{ $productDetail->SkuID }}">{{ $productDetail->ProductStrength }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-3">
                        <label for="PackID" class="form-label">Unit Pack</label><span style="color: red">*</span>
                        <select class="form-control PackID" name="0[PackID][]" required>
                            <option value="" selected disabled>Pack</option>
                            @foreach ($product->packs as $pack)
                                <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                            @endforeach
                        </select>
                    </div>

                    @forelse ($protocol->statbilityStudy as $statbility)
                        @php
                            $duration = $statbility->study->details->pluck('StudyTypeMonth');
                        @endphp
                    @empty
                    @endforelse

                    @foreach ($duration as $key => $item)
                        <div class="col-md-2 mt-3">
                            <label for="Value" class="form-label">{{ $item }}</label>
                            <span style="color: red">*</span>
                            <input type="text" class="form-control StudyTypeMonth" name="0[StudyTypeMonth][]"
                                required style="margin-right:15px;">
                        </div>
                    @endforeach

                    <div class="col-md-2 mt-3">
                        <label for="Value" class="form-label">Additional</label>
                        <input type="number" class="form-control" id="Additional" name="0[Additional][]"
                            style="margin-right:15px;">
                    </div>
                    <div class="col" style="margin-top: 43px;">
                        <span class="btn btn-danger btn-xs pull-right btn-del-chamber"><i
                                class="fa fa-remove"></i></span>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-2 mt-3">
                        <label class="form-label" style="margin-top: 34px">Placebo Strength</label>
                    </div>
                    @foreach ($duration as $key => $item)
                        <div class="col-md-2 mt-3">
                            <label for="Value" class="form-label">{{ $item }}</label>
                            <input type="text" class="form-control PlaceboMonth" name="PlaceboMonth[]"
                               style="margin-right:15px;">
                        </div>
                    @endforeach

                    <div class="col-md-2 mt-3">
                        <label for="Value" class="form-label">Placebo Additional</label>
                        <input type="number" class="form-control" id="Additional" name="PlaceboAdditional"
                            style="margin-right:15px;">
                    </div>
                </div>

            @endif

            <div class="col-md-2" style="margin-left: 5px;margin-top: 43px;">
                <span class="btn btn-success btn-xs btn-add-chamber"><i class="fa fa-add"></i></span>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
@else
    <p>Please create a protocol & statbilty study first!</p>
@endif

@push('script')
    <script>
        $(function() {
            $('.btn-del-chamber').hide();
            var click = 0;
            $('body').on('click', '.btn-add-chamber', function() {
                click++;
                $(this).parent().parent().find(".stability-chamber-design").clone().insertBefore($(this)
                        .parent()).removeClass("stability-chamber-design").find(":not(select).form-control")
                    .val("");
                $('.btn-del-chamber').fadeIn();
                $(this).parent().parent().find(".btn-del-chamber").click(function(e) {
                    $(this).parent().parent().remove();
                });

                // $( ".SkuID" ).each(
                //     function( index ) {
                //         this.name = `${click}[SkuID][]`;
                //     }
                // );

                // $( ".PackID" ).each(
                //     function( index ) {
                //         this.name = `${click}[PackID][]`;
                //     }
                // );

                // $( ".StudyTypeMonth" ).each(
                //     function( index ) {
                //         this.name = `${click}[StudyTypeMonth][${click}][]`;
                //     }
                // );

            });
        });
    </script>
@endpush
