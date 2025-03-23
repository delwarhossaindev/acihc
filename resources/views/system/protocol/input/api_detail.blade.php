@php
    if (isset($protocol)) {
        $product = $protocol->product;
        $protocolAPIDetails = \App\Models\ProtocolApiDetail::where('ProtocolID', $protocol->ProtocolID)->get();

        $ptCount = $protocolAPIDetails->count();
    }
@endphp

@if (isset($protocol))
    <div class="row g-3">
        @if ($ptCount > 0)
            @foreach ($protocolAPIDetails as $key => $item)
                <div class="row protocol-api">
                    <div class="col-md-4 mt-3">
                        <label for="ApiID" class="form-label">API DETAILS <span style="color: red">*</span></label>
                        <select class="form-control Test" name="ApiID[]" required>
                            <option value="" selected disabled>Select API Details</option>
                            @foreach ($product->apis as $api)
                                <option value="{{ $api->ApiDetailID }}" {{ $api->ApiDetailID == $item->APIDetailID ? 'selected' : '' }}>
                                    {{ $api->ApiDetailName.'('.$api->APIDetailSource.')' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-tooltip">Required</div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="BatchNo" class="form-label">Batch/Lot No</label>
                        <input type="text" name="BatchNo[]" class="form-control" value="{{ $item->BatchNo }}" placeholder="Enter lot no with commas">
                        <div class="invalid-tooltip">Required</div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="ExpDate" class="form-label">Exp/ Retest Date of API (mm/dd/yy)</label>
                        <input type="date" name="ExpDate[]" class="form-control" value="{{ $item->ExpDate }}" placeholder="09/13/2022">
                        <div class="invalid-tooltip">Required</div>
                    </div>
                    <div class="col-md-1" style="margin-top: 43px;">
                        <span class="btn btn-danger btn-xs pull-right btn-del-api"><i class="fa fa-remove"></i></span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row protocol-api">
                <div class="col-md-4 mt-3">
                    <label for="ApiID" class="form-label">API DETAILS <span style="color: red">*</span></label>
                    <select class="form-control Test" name="ApiID[]" required>
                        <option value="" selected disabled>Select API Details</option>
                        @foreach ($product->apis as $api)
                            <option value="{{ $api->ApiDetailID }}">{{ $api->ApiDetailName }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>
                <div class="col-md-3 mt-3">
                    <label for="BatchNo" class="form-label">Batch/Lot No</label>
                    <input type="text" name="BatchNo[]" class="form-control" placeholder="Enter lot no with commas">
                    <div class="invalid-tooltip">Required</div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="ExpDate" class="form-label">Exp/ Retest Date of API (mm/dd/yy)</label>
                    <input type="date" name="ExpDate[]" class="form-control" placeholder="09/13/2022">
                    <div class="invalid-tooltip">Required</div>
                </div>
                <div class="col-md-1" style="margin-top: 43px;">
                    <span class="btn btn-danger btn-xs pull-right btn-del-api"><i class="fa fa-remove"></i></span>
                </div>
            </div>
        @endif
        <div class="col-md-12 text-right" style="margin-left: 5px;">
            <span class="btn btn-success btn-xs add-api"><i class="fa fa-add"></i></span>
        </div>

        <div class="modal-footer">
            @if(isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)

            <button type="submit" class="btn btn-primary" id="saveChangesBtnApiDetails" style="visibility: hidden;">Save changes</button>
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
    $(document).ready(function() {
        // Hide the delete button for the first row initially
        $('.protocol-api:first .btn-del-api').hide();

        // Function to add new API set
        function addNewApiSet() {
            var newApi = $('.protocol-api:first').clone();
            newApi.find('select, input').val(''); // Clear input values
            newApi.find('.btn-del-api').show(); // Show delete button for new entries

            // Attach delete event handler
            newApi.find('.btn-del-api').on('click', function() {
                $(this).closest('.protocol-api').remove();
            });

            // Append new API set after the last existing set
            $('.protocol-api:last').after(newApi);
        }

        // Add new API set when 'Add API' button is clicked
        $(document).on('click', '.add-api', function() {
            addNewApiSet();
        });

        // Delete API set
        $(document).on('click', '.btn-del-api', function() {
            $(this).closest('.protocol-api').remove();
        });
    });
</script>
@endpush
