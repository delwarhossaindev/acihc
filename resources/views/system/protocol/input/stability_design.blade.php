@php
    $product   = $protocol->product;
    $sdType    = $protocol->statbilityStudy;
    $loopCount = $protocol->protocolSkuUnitPack()->count();
    $getData   = \DB::table('StabilityDesignTitle')->where('ProtocolID', $protocol->ProtocolID)->first();
    $stabilityDesignTitle = isset($getData->Title) ? unserialize($getData->Title) : null;

    $firstStudy = $sdType->first();
    $duration   = $firstStudy && $firstStudy->study && $firstStudy->study->details
        ? $firstStudy->study->details->pluck('StudyTypeMonth')
        : collect();

    $placeboRow              = \DB::table('PlaceboSkuUnitPack')->where('ProtocolID', $protocol->ProtocolID)->first();
    $PlaceboSkuUnitPackMonth = $placeboRow ? json_decode($placeboRow->Month) : [];
    $PlaceboAdditional       = $placeboRow->Additional ?? null;
@endphp

@if ($protocol->statbilityStudy()->count() > 0)
    <div class="row g-3">
        @foreach ($duration as $key => $item)
            <div class="col-md-2">
                <label class="form-label">{{ $item }} Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title[]" value="{{ $stabilityDesignTitle[$key] ?? null }}" required>
            </div>
        @endforeach

        <div class="col-md-2">
            <label class="form-label">Additional Sample <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="additionalSample" value="{{ $getData->AdditionalSample ?? null }}" required>
        </div>

        <div class="col-12"><hr class="my-2"></div>

        @if ($loopCount > 0)
            @foreach ($protocol->protocolSkuUnitPack as $key => $protocolSkuUnitPack)
                @php $monthArray = json_decode($protocolSkuUnitPack->Month, true); @endphp

                <div class="row g-3 align-items-end stability-chamber-design mb-2">
                    <div class="col-md-2">
                        <label class="form-label">Strength <span class="text-danger">*</span></label>
                        <select class="form-select SkuID" name="0[SkuID][]" required>
                            <option value="" selected disabled>Strength</option>
                            @foreach ($product->details as $pd)
                                <option value="{{ $pd->SkuID }}" @selected($protocolSkuUnitPack->SkuID == $pd->SkuID)>{{ $pd->ProductStrength }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unit Pack <span class="text-danger">*</span></label>
                        <select class="form-select PackID" name="0[PackID][]" required>
                            <option value="" selected disabled>Pack</option>
                            @foreach ($product->packs as $pack)
                                <option value="{{ $pack->PackID }}" @selected($protocolSkuUnitPack->PackID == $pack->PackID)>{{ $pack->PackValue }}</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach ($duration as $key1 => $item)
                        <div class="col-md-2">
                            <label class="form-label">{{ $item }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control StudyTypeMonth" name="0[StudyTypeMonth][]" value="{{ $monthArray[$key1] ?? '' }}" required>
                        </div>
                    @endforeach

                    <div class="col-md-2">
                        <label class="form-label">Additional</label>
                        <input type="text" class="form-control" name="0[Additional][]" value="{{ $protocolSkuUnitPack->Additional }}">
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-del-chamber w-100" title="Remove">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Placebo Strength</label>
                </div>
                @foreach ($duration as $key2 => $item)
                    <div class="col-md-2">
                        <label class="form-label">{{ $item }}</label>
                        <input type="text" class="form-control PlaceboMonth" name="PlaceboMonth[]" value="{{ $PlaceboSkuUnitPackMonth[$key2] ?? '' }}">
                    </div>
                @endforeach
                <div class="col-md-2">
                    <label class="form-label">Placebo Additional</label>
                    <input type="text" class="form-control" name="PlaceboAdditional" value="{{ $PlaceboAdditional ?? 0 }}">
                </div>
            </div>
        @else
            <div class="row g-3 align-items-end stability-chamber-design mb-2">
                <div class="col-md-2">
                    <label class="form-label">Strength <span class="text-danger">*</span></label>
                    <select class="form-select SkuID" name="0[PlaceboSkuID][]" required>
                        <option value="" selected disabled>Strength</option>
                        @foreach ($product->details as $pd)
                            <option value="{{ $pd->SkuID }}">{{ $pd->ProductStrength }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Unit Pack <span class="text-danger">*</span></label>
                    <select class="form-select PackID" name="0[PackID][]" required>
                        <option value="" selected disabled>Pack</option>
                        @foreach ($product->packs as $pack)
                            <option value="{{ $pack->PackID }}">{{ $pack->PackValue }}</option>
                        @endforeach
                    </select>
                </div>
                @foreach ($duration as $key => $item)
                    <div class="col-md-2">
                        <label class="form-label">{{ $item }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control StudyTypeMonth" name="0[StudyTypeMonth][]" required>
                    </div>
                @endforeach
                <div class="col-md-2">
                    <label class="form-label">Additional</label>
                    <input type="text" class="form-control" name="0[Additional][]">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-del-chamber w-100" title="Remove">
                        <i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>

            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Placebo Strength</label>
                </div>
                @foreach ($duration as $key => $item)
                    <div class="col-md-2">
                        <label class="form-label">{{ $item }}</label>
                        <input type="text" class="form-control PlaceboMonth" name="PlaceboMonth[]">
                    </div>
                @endforeach
                <div class="col-md-2">
                    <label class="form-label">Placebo Additional</label>
                    <input type="text" class="form-control" name="PlaceboAdditional">
                </div>
            </div>
        @endif

        <div class="col-12">
            <button type="button" class="btn btn-outline-success btn-sm btn-add-chamber">
                <i class="fa fa-plus"></i> Add Row
            </button>
        </div>

        <div class="col-12 d-flex justify-content-end mt-3">
            @if (isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)
                <button type="button" class="btn btn-primary ajax-approval-modal-btn">Save changes</button>
            @else
                <button type="submit" class="btn btn-primary">Save changes</button>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-info">Please create a protocol &amp; stability study first!</div>
@endif

@push('script')
<script>
    $(function() {
        $('.btn-del-chamber').hide();
        $('body').on('click', '.btn-add-chamber', function() {
            var $parent = $(this).closest('.row');
            var $tpl = $('.stability-chamber-design').first().clone();
            $tpl.find(':not(select).form-control').val('');
            $tpl.find('.btn-del-chamber').show();
            $('.stability-chamber-design').last().after($tpl);
        });
        $(document).on('click', '.btn-del-chamber', function() {
            if ($('.stability-chamber-design').length > 1) {
                $(this).closest('.stability-chamber-design').remove();
            }
        });
    });
</script>
@endpush
