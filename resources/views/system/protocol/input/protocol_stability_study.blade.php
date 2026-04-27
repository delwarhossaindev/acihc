@php
    $studyTypes = \App\Models\StudyType::with('details')->get();
    $conditions = \App\Models\Condition::all();
    $hasRows    = $protocol->statbilityStudy->count() > 0;
@endphp

<div class="row g-3">
    @foreach ($protocol->statbilityStudy as $key => $stStudy)
        <div class="row g-3 align-items-end stability_study mb-2">
            <div class="col-md-5">
                <label class="form-label">Stability Study <span class="text-danger">*</span></label>
                <select class="form-select pack name1" name="test{{ $key }}[StydyTypeID][]">
                    <option value="" selected disabled>Study Type</option>
                    @foreach ($studyTypes as $st)
                        @php $months = $st->details->pluck('StudyTypeMonth')->implode(' '); @endphp
                        <option value="{{ $st->StudyTypeID }}" @selected($stStudy->StudyTypeID == $st->StudyTypeID)>
                            {{ $st->StudyTypeName }} ({{ $months }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Storage Condition <span class="text-danger">*</span></label>
                <select class="form-select name2" name="test{{ $key }}[ConditionID][]">
                    <option value="" selected disabled>Storage Condition</option>
                    @foreach ($conditions as $c)
                        <option value="{{ $c->ConditionID }}" @selected($stStudy->ConditionID == $c->ConditionID)>{{ $c->ConditionName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-del-stability-study w-100" title="Remove">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    @endforeach

    @if (! $hasRows)
        <div class="row g-3 align-items-end stability_study duplicable mb-2">
            <div class="col-md-5">
                <label class="form-label">Stability Study <span class="text-danger">*</span></label>
                <select class="form-select pack name1" name="test[StydyTypeID][]" required>
                    <option value="" selected disabled>Study Type</option>
                    @foreach ($studyTypes as $st)
                        @php $months = $st->details->pluck('StudyTypeMonth')->implode(' '); @endphp
                        <option value="{{ $st->StudyTypeID }}">{{ $st->StudyTypeName }} ({{ $months }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Storage Condition <span class="text-danger">*</span></label>
                <select class="form-select name2" name="test[ConditionID][]" required>
                    <option value="" selected disabled>Storage Condition</option>
                    @foreach ($conditions as $c)
                        <option value="{{ $c->ConditionID }}">{{ $c->ConditionName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-del-stability-study w-100" title="Remove">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="col-12">
        <button type="button" class="btn btn-outline-success btn-sm add-stability-study">
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
        function updateNames() {
            $('.stability_study').each(function(i) {
                $(this).find('.name1').attr('name', 'test' + i + '[StydyTypeID][]');
                $(this).find('.name2').attr('name', 'test' + i + '[ConditionID][]');
            });
        }

        $('.stability_study').each(function(i) {
            $(this).find('.btn-del-stability-study').toggle(i !== 0);
        });

        $(document).on('click', '.add-stability-study', function() {
            var $tpl = $('.stability_study').last().clone();
            $tpl.find('select').val('');
            $tpl.find('.btn-del-stability-study').show();
            $('.stability_study').last().after($tpl);
            updateNames();
        });

        $(document).on('click', '.btn-del-stability-study', function() {
            if ($('.stability_study').length > 1) {
                $(this).closest('.stability_study').remove();
                updateNames();
            }
        });
    });
</script>
@endpush
