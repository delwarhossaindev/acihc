@php
    $product            = $protocol->product;
    $protocolAPIDetails = \App\Models\ProtocolApiDetail::where('ProtocolID', $protocol->ProtocolID)->get();
    $rows               = $protocolAPIDetails->isNotEmpty() ? $protocolAPIDetails : collect([null]);
@endphp

<div class="row g-3">
    @foreach ($rows as $item)
        <div class="row g-3 protocol-api align-items-end mb-2">
            <div class="col-md-4">
                <label class="form-label">API Details <span class="text-danger">*</span></label>
                <select class="form-select" name="ApiID[]" required>
                    <option value="" selected disabled>Select API Details</option>
                    @foreach ($product->apis as $api)
                        <option value="{{ $api->ApiDetailID }}" @selected($item && $api->ApiDetailID == $item->APIDetailID)>
                            {{ $api->ApiDetailName }} ({{ $api->APIDetailSource }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Batch/Lot No</label>
                <input type="text" name="BatchNo[]" class="form-control" value="{{ $item->BatchNo ?? '' }}" placeholder="Enter lot no with commas">
            </div>
            <div class="col-md-4">
                <label class="form-label">Exp / Retest Date of API</label>
                <input type="date" name="ExpDate[]" class="form-control" value="{{ $item->ExpDate ?? '' }}">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-del-api w-100" title="Remove">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    @endforeach

    <div class="col-12">
        <button type="button" class="btn btn-outline-success btn-sm add-api">
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
    $(document).ready(function() {
        $('.protocol-api:first .btn-del-api').hide();

        $(document).on('click', '.add-api', function() {
            var $tpl = $('.protocol-api:first').clone();
            $tpl.find('select, input').val('');
            $tpl.find('.btn-del-api').show();
            $('.protocol-api:last').after($tpl);
        });

        $(document).on('click', '.btn-del-api', function() {
            if ($('.protocol-api').length > 1) {
                $(this).closest('.protocol-api').remove();
            }
        });
    });
</script>
@endpush
