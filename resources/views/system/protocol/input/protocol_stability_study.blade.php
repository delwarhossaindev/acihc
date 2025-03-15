@php
    $product = $protocol->product ?? null;
@endphp

@if (isset($protocol))
    <div class="row g-3">
        @foreach ($protocol->statbilityStudy as $key => $stStudy)
            <div class="row select_packaging_matirials stability_study duplicable">
                @php $testMonth = $stStudy->testingTimePoints->pluck('TestingMonth'); @endphp

                <div class="col-md-5 mt-3">
                    <label for="PackID" class="form-label">Stability Study <span style="color: red">*</span></label>
                    <select class="form-control pack name1" name="test{{ $key }}[StydyTypeID][]">
                        <option value="" selected disabled>Study Type</option>
                        @foreach (\App\Models\StudyType::all() as $stabilityStudy)
                            <option value="{{ $stabilityStudy->StudyTypeID }}" {{ $stStudy->StudyTypeID == $stabilityStudy->StudyTypeID ? 'selected' : '' }}>
                                {{ $stabilityStudy->StudyTypeName }} ({{ implode(' ', $stabilityStudy->details->pluck('StudyTypeMonth')->toArray()) }})
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>

                <div class="col-md-6 mt-3 primary-box">
                    <label for="" class="form-label">Storage Condition <span style="color: red">*</span></label>
                    <select class="form-control name2" name="test{{ $key }}[ConditionID][]">
                        <option value="" selected disabled>Storage Condition</option>
                        @foreach (\App\Models\Condition::all() as $condition)
                            <option value="{{ $condition->ConditionID }}" {{ $stStudy->ConditionID == $condition->ConditionID ? 'selected' : '' }}>
                                {{ $condition->ConditionName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>

                <div class="col-md-1" style="margin-top: 43px;">
                    <span class="btn btn-danger btn-xs pull-right btn-del-stability-study"><i class="fa fa-remove"></i></span>
                </div>
            </div>
        @endforeach

        @if ($protocol->statbilityStudy->isEmpty())
            <div class="row select_packaging_matirials stability_study duplicable">
                <div class="col-md-5 mt-3">
                    <label for="PackID" class="form-label">Stability Study <span style="color: red">*</span></label>
                    <select class="form-control pack name1" name="test[StydyTypeID][]" required>
                        <option value="" selected disabled>Study Type</option>
                        @foreach (\App\Models\StudyType::all() as $stabilityStudy)
                            <option value="{{ $stabilityStudy->StudyTypeID }}">
                                {{ $stabilityStudy->StudyTypeName }} ({{ implode(' ', $stabilityStudy->details->pluck('StudyTypeMonth')->toArray()) }})
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>

                <div class="col-md-6 mt-3 primary-box">
                    <label for="" class="form-label">Storage Condition <span style="color: red">*</span></label>
                    <select class="form-control name2" name="test[ConditionID][]" required>
                        <option value="" selected disabled>Storage Condition</option>
                        @foreach (\App\Models\Condition::all() as $condition)
                            <option value="{{ $condition->ConditionID }}">{{ $condition->ConditionName }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>

                <div class="col-md-1" style="margin-top: 43px;">
                    <span class="btn btn-danger btn-xs pull-right btn-del-stability-study"><i class="fa fa-remove"></i></span>
                </div>
            </div>
        @endif

        <div class="col-md-2" style="margin-left: 5px;">
            <span class="btn btn-success btn-xs add-stability-study"><i class="fa fa-add"></i></span>
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
    <p>Please create a protocol first!</p>
@endif

@push('script')
<script>
    $(document).ready(function() {
        function updateNames() {
            $(".stability_study").each(function(index) {
                $(this).find(".name1").attr("name", `test${index}[StydyTypeID][]`);
                $(this).find(".name2").attr("name", `test${index}[ConditionID][]`);
            });
        }

        // Hide the delete button for the first row
        $('.stability_study').each(function(index) {
            $(this).find('.btn-del-stability-study').toggle(index !== 0);
        });

        // Add new stability study row
        $(document).on('click', '.add-stability-study', function() {
            let $newRow = $(this).closest('.row').find('.duplicable:last').clone();
            $newRow.find('select').val(''); // Clear selected values
            $newRow.insertBefore($(this).closest('.col-md-2'));
            $newRow.find('.btn-del-stability-study').show();
            updateNames();
        });

        // Delete stability study row
        $(document).on('click', '.btn-del-stability-study', function() {
            $(this).closest('.stability_study').remove();
            updateNames();
        });
    });
</script>
@endpush
