@extends('admin.layouts.master')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/tagify/tagify.css') }}" />
@endpush

@section('content')

    <div>
        <h4 class="fw-bold py-1 mb-3">Edit Report</h4>

        <x-alert.alert-component />

        @php
            $protocol = $sample->protocol;
            $batchs = \App\Models\Batch::where('ProtocolID', $protocol->ProtocolID)->get()->unique('BatchNo');
            $studyTypes = \App\Models\ProtocolStabilityStudy::where('ProtocolID', $protocol->ProtocolID)
                ->pluck('StudyTypeID')
                ->toArray();
            $conditions = \App\Models\StudyType::whereIn('StudyTypeID', $studyTypes)->get();

            // approval
            $reviewByOneUserID = null;
            $reviewByTwoUserID = null;
            $approvalByUserID = null;
            $reviewByOneComment = null;
            $reviewByTwoComment = null;
            $reviewByTwoComment = null;
            $approvalByComment = null;

            $reviewByOne = \App\Models\SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
                ->where('SampleApprovalTypeID', 1)
                ->first();

            $reviewByOneUserID = $reviewByOne->UserID ?? null;
            $reviewByOneUser = $reviewByOne ? \App\Models\User::find($reviewByOne->UserID) : null;
            $reviewByOneComment = $reviewByOne
                ? \App\Models\SampleReviewer::where('SampleReportID', $sampleReport->SampleReportID)
                    ->where('UserID', $reviewByOne->UserID)
                    ->first()
                : null;

            $reviewByTwo = \App\Models\SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
                ->where('SampleApprovalTypeID', 1)
                ->latest('CreateDate')
                ->first();

            $reviewByTwoUserID = $reviewByTwo->UserID ?? null;
            $reviewByTwoUser = $reviewByTwo ? \App\Models\User::find($reviewByTwo->UserID) : null;
            $reviewByTwoComment = $reviewByTwo
                ? \App\Models\SampleReviewer::where('SampleReportID', $sampleReport->SampleReportID)
                    ->where('UserID', $reviewByTwo->UserID)
                    ->first()
                : null;

            $approvalBy = \App\Models\SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
                ->where('SampleApprovalTypeID', 2)
                ->first();

            $approvalByUserID = $approvalBy->UserID ?? null;
            $approvalByUser = $approvalBy ? \App\Models\User::find($approvalBy->UserID) : null;
            $approvalByComment = $approvalBy
                ? \App\Models\SampleApprover::where('SampleReportID', $sampleReport->SampleReportID)
                    ->where('UserID', $approvalBy->UserID)
                    ->first()
                : null;

            $sampleReportDetailsCount = count($sampleReport->sampleReportDetails);

        @endphp



        <form action="{{ route('sampleReport.update', $sampleReport->SampleReportID) }}" method="post"
            class="needs-validation" role="form" novalidate>
            @csrf
            @method('PUT')




            <div class="card" style="background:#e0fafa;">
                <div class="card-body">
                    <div class="row">

                        <div class="col-8 mb-5">
                            <label for="Headline" class="form-label">Headline</label><span style="color: red">*</span>
                            <input type="text" class="form-control" id="Headline" name="Headline" placeholder="Headline"
                                value="{{ $sampleReport->Headline }}" required>
                        </div>
                        <div class="col-4"></div>

                        <div class="col-md-2">
                            <label for="BatchID" class="form-label">Batch</label><span style="color: red">*</span>
                            <select id="BatchID" class="form-select custom-select" required name="BatchID">
                                <option value="" disabled>Select Batch</option>
                                @foreach ($batchs as $batch)
                                    <option value="{{ $batch->BatchID }}"
                                        {{ $batch->BatchID == $sampleReport->BatchID ? 'selected' : '' }}>
                                        {{ $batch->BatchNo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="SkuID" class="form-label">Strength</label><span style="color: red">*</span>
                            <select id="SkuID" class="form-select custom-select" required name="SkuID">
                                <option value="" disabled>Select Strength</option>
                                @foreach ($protocol->product->details as $strength)
                                    <option value="{{ $strength->SkuID }}"
                                        {{ $strength->SkuID == $sampleReport->SkuID ? 'selected' : '' }}>
                                        {{ $strength->ProductStrength }} mg
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="PackID" class="form-label">Unit Pack</label><span style="color: red">*</span>
                            <select id="PackID" class="form-select custom-select" required name="PackID">
                                <option value="" disabled>Select Pack</option>
                                @foreach (\App\Models\Pack::all() as $pack)
                                    <option value="{{ $pack->PackID }}"
                                        {{ $pack->PackID == $sampleReport->PackID ? 'selected' : '' }}>
                                        {{ $pack->PackValue }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="StudyTypeID" class="form-label">Study Type</label><span style="color: red">*</span>
                            <select id="StudyTypeID" class="form-select custom-select" required name="StudyTypeID">
                                <option value="" disabled>Select Study Type</option>
                                @foreach ($conditions as $condition)
                                    <option value="{{ $condition->StudyTypeID }}"
                                        {{ $condition->StudyTypeID == $sampleReport->StudyTypeID ? 'selected' : '' }}>
                                        {{ $condition->StudyTypeName }}
                                        ({{ implode(' ', $condition->details->pluck('StudyTypeMonth')->toArray()) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="ConditionID" class="form-label">Condition</label><span style="color: red">*</span>
                            <select id="ConditionID" class="form-select custom-select" required name="ConditionID">
                                <option value="" disabled>Select Condition</option>
                                @foreach (\App\Models\Condition::all() as $condition)
                                    <option value="{{ $condition->ConditionID }}"
                                        {{ $condition->ConditionID == $sampleReport->ConditionID ? 'selected' : '' }}>
                                        {{ $condition->ConditionName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mt-2">
                            <div class="btn btn-secondary generate-form" style="margin-top: 20px;">Create Row</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-1 hideCard"
            style="{{ $sampleReport->sampleReportDetails->count() ? '' : 'display: none;' }}">

            <div class="card-body addRow" style="height: 500px; width: auto; overflow-y: scroll">
                    @foreach ($sampleReport->sampleReportDetails as $index => $value)
                        <br>
                        <div class="row" data-remove="{{ $index }}">


                            <input type="hidden" id="Headline" name="{{ $index }}[Headline][]"
                                value="{{ $sampleReport->Headline }}">
                            <input type="hidden" id="SkuID" name="{{ $index }}[SkuID][]"
                                value="{{ $sampleReport->SkuID }}">
                            <input type="hidden" id="BatchID" name="{{ $index }}[BatchID][]"
                                value="{{ $sampleReport->BatchID }}">
                            <input type="hidden" id="PackID" name="{{ $index }}[PackID][]"
                                value="{{ $sampleReport->PackID }}">
                            <input type="hidden" id="StudyTypeID" name="{{ $index }}[StudyTypeID][]"
                                value="{{ $sampleReport->StudyTypeID }}">
                            <input type="hidden" id="ConditionID" name="{{ $index }}[ConditionID][]"
                                value="{{ $sampleReport->ConditionID }}">
                            <b style="font-size: 16px; color: red;">{{ $index + 1 }}</b>
                            <div class="col-md-2">

                                <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                                <select id="TestID" class="form-select custom-select TestID"
                                    name="{{ $index }}[TestID][]" required>
                                    <option value="" selected disabled>Select Test</option>
                                    @foreach (\App\Models\Test::all() as $test)
                                        <option value="t{{ $test->TestID }}"
                                            @if (!$value->SubTestID) {{ $test->TestID == $value->TestID ? 'selected' : '' }} @endif>
                                            {{ $test->TestName }}
                                        </option>
                                    @endforeach
                                    <option value="" disabled>Select Sub Test</option>
                                    @foreach (\App\Models\SubTest::all() as $subTest)
                                        <option value="sub{{ $subTest->SubtestID }}"
                                            @if ($value->SubTestID) {{ $subTest->SubtestID == $value->SubTestID ? 'selected' : '' }} @endif>
                                            {{ $subTest->SubTestName }}
                                        </option>
                                    @endforeach
                                </select>


                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="Specification" class="form-label">Specifications</label><span
                                    style="color: red">*</span>
                                <input type="text" class="form-control" name="{{ $index }}[Specification][]"
                                    value="{{ $value->Specification }}" placeholder="Specification" required>
                            </div>

                            @php
                                $durations = $sampleReport->study->details->pluck('StudyTypeMonth');
                            @endphp

                            @foreach ($value->Value as $i => $val)
                                <div class="col-md-2">
                                    <label for="Value" class="form-label">{{ $durations[$i] ?? '' }}</label>
                                    <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="{{ $index }}[Value][]"
                                        value="{{ $val }}" placeholder="Enter Value">
                                </div>
                            @endforeach

                            <div class="col-md-1" style="margin-top: 43px;">
                                <span class="btn btn-danger btn-xs pull-right btn-del-api"><i
                                        class="fa fa-remove"></i></span>
                            </div>
                        </div>
                    @endforeach
                    <br>


                </div>

                @php
                $note = unserialize($sampleReport->Note);

                @endphp


                <div class="card-body ">
                    <h5>Note:</h5>
                    <input type="text" class="form-control" name="Note[]" value="{{ $note [0] ?? 'Detection limit for Atorvastatin RC D = 0.008232% and for Atorvastatin RC H = 0.031200%.' }}"  placeholder="Note Line One ">
                    <input type="text" class="form-control mt-1" name="Note[]" value="{{ $note [1] ?? 'Quantitation limit for Atorvastatin RC D = 0.012348% and for Atorvastatin RC H = 0.050200%.' }}" placeholder="Note Line Two ">
                    <input type="text" class="form-control mt-1" name="Note[]" value="{{ $note [2] ?? '*Atorvastatin related compound D undergoes transformation equilibrium to the atorvastatin epoxy THF analog. These two impurities are to be reported against combined specification i.e. (1.0% + 0.5% = 1.5%) under atorvastatin related compound D.' }}" placeholder="Note Line Three ">
                    <input type="text" class="form-control mt-1" name="Note[]" value="{{ $note [3] ?? '** Microbial enumeration test and tests for special microorganism to be performed initially and yearly at 25±2 °C / 60±5 % RH condition.' }}" placeholder="Note Line Four ">
                    <input type="text" class="form-control mt-1" name="Note[]" value="{{ $note [4] ?? 'BRL = Below Reporting Level. The reporting level for impurities is 0.1%.' }}" placeholder="Note Line Five ">
                </div>


                <div class="float-right"
                    style="{{ $sampleReport->sampleReportDetails->count() ? '' : 'display: none;' }}">
                    <div class="row">
                        <div class="col-md-2 text-right" style="margin: 9px;">
                            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Update</button>
                        </div>
                    </div>
                </div>

        </form>


        <br>
    </div>
    <hr>

    <div >
        <h4 class="fw-bold py-1 mb-3">Sample Report Approval</h4>

        <form action="{{ route('sample.approval.store', $sampleReport->SampleReportID) }}" method="post"
            class="needs-validation" novalidate>
            @csrf
            <div class="row">
                @if ($reviewByOneUserID == auth()->user()->id && !$reviewByOneComment)
                    <div class="col-6">
                        <input type="hidden" name="reviewByOne" value="{{ $reviewByOne }}">
                        <input type="hidden" name="reviewByOneUser" value="{{ $reviewByOneUser }}">
                        <p>Name: {{ $reviewByOneUser->name ?? null }} &nbsp; &nbsp; Designation:
                            {{ $reviewByOneUser->designation ?? null }}</p>

                        <label class="form-label">Comment Review (One) </label>
                        <textarea id="commentOne" name="commentOne" class="form-control" rows="2" placeholder="Comment Review One"></textarea>
                    </div>

                    <div class="col-6"></div>
                @else
                    <div class="col-6">
                        <label class="form-label">Comment Review (One) </label>
                        <p>Name: {{ $reviewByOneUser->name ?? null }} &nbsp; &nbsp; Designation:
                            {{ $reviewByOneUser->designation ?? null }}</p>
                        @if (!$reviewByOneComment)
                            <p>Review One Pending !</p>
                        @else
                            <p>Comment: {{ $reviewByOneComment->Comment }} <br> Review One Complete !</p>
                        @endif
                    </div>

                    <div class="col-6"></div>
                @endif

                @if ($reviewByTwoUserID == auth()->user()->id && !$reviewByTwoComment)
                    <div class="col-6">
                        <br>
                        <input type="hidden" name="reviewByTwo" value="{{ $reviewByTwo }}">
                        <input type="hidden" name="reviewByTwoUser" value="{{ $reviewByTwoUser }}">
                        <p>Name: {{ $reviewByTwoUser->name ?? null }} &nbsp; &nbsp; Designation:
                            {{ $reviewByTwoUser->designation ?? null }}</p>
                        <label class="form-label">Comment Review (Two) </label>
                        <textarea id="commentTwo" name="commentTwo" class="form-control" rows="2" placeholder="Comment Review Two"></textarea>
                    </div>
                    <div class="col-6"></div>
                @else
                    <div class="col-6">
                        <br>
                        <label class="form-label">Comment Review (Two) </label>
                        <p>Name: {{ $reviewByTwoUser->name ?? null }} &nbsp; &nbsp; Designation:
                            {{ $reviewByTwoUser->designation ?? null }}</p>

                        @if (!$reviewByTwoComment)
                            <p>Review Two Pending !</p>
                        @else
                            <p>Comment: {{ $reviewByTwoComment->Comment }} <br> Review Two Complete !</p>
                        @endif
                    </div>

                    <div class="col-6"></div>
                @endif





                @if ($approvalByUserID == auth()->user()->id && !$approvalByComment && $reviewByTwoComment && $reviewByOneComment)
                    <div class="col-6">
                        <br>
                        <input type="hidden" name="approvalBy" value="{{ $approvalBy }}">
                        <input type="hidden" name="approvalByUser" value="{{ $approvalByUser }}">
                        <p>Name: {{ $approvalByUser->name ?? null }} &nbsp; &nbsp; Designation:
                            {{ $approvalByUser->designation ?? null }}</p>

                        <label class="form-label">Approval Comment : </label>
                        <textarea id="approvalComment" name="approvalComment" class="form-control" rows="2"
                            placeholder="Approval Comment"></textarea>
                    </div>

                    <div class="col-6">

                    </div>
                    <div class="col-6">
                        <label class="form-label">Approval</label>
                        <select class="form-control custom-select" name="Approval" required>
                            <option value="Approved">Approved</option>
                            <option value="Decline">Decline</option>
                        </select>
                    </div>

                    <div class="col-6">

                    </div>
                @else
                    <div class="col-6">
                        <br>
                        <label class="form-label">Approval Comment : </label>
                        <p>Name: {{ $approvalByUser->name ?? null }} &nbsp; &nbsp; Designation:
                            {{ $approvalByUser->designation ?? null }}</p>
                        @if (!$approvalByComment)
                            <p>Approval Pending !</p>
                        @else
                            <p>Comment: {{ $approvalByComment->Comment }} </p>
                            @if ($sampleReport->SampleReportStatusID == 4)
                                <p
                                    style="background-color: green; color: white; padding: 15px 25px; border-radius: 15px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); text-align: center; font-size: 16px;">
                                    Approval Complete!
                                </p>
                            @else
                                <p
                                    style="background-color: red; color: white; padding: 15px 25px; border-radius: 15px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); text-align: center; font-size: 16px;">
                                    This Sample Decline!
                                </p>
                            @endif
                        @endif
                    </div>

                    <div class="col-6">

                    </div>

                @endif
            </div>
            @if (!in_array($sampleReport->SampleReportStatusID, [4, 5]))
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            @endif

        </form>


    </div>


@endsection

@push('script')
    <script type="text/javascript">
        let html = '';
        let click = {{ $sampleReportDetailsCount + 1 }};
        let type = 'text';
        let placeholder = '';

        $('body').on('click', '.btn-del-api', function() {
            $(this).closest('.row').remove();
        });

        const getTemplate = () => {
            let SkuID = $('#SkuID').children("option:selected").val();
            let Headline = $('#Headline').val();
            let PackID = $('#PackID').children("option:selected").val();
            let BatchID = $('#BatchID').children("option:selected").val();
            let ConditionID = $('#ConditionID').children("option:selected").val();
            let StudyTypeID = $('#StudyTypeID').children("option:selected").val();

            let template = `<br><div class="row" data-remove="${click}">
            <input type="hidden" id="Headline" name="${click}[Headline][]" value="${Headline}">
            <input type="hidden" id="SkuID" name="${click}[SkuID][]" value="${SkuID}">
            <input type="hidden" id="BatchID" name="${click}[BatchID][]" value="${BatchID}">
            <input type="hidden" id="PackID" name="${click}[PackID][]" value="${PackID}">
            <input type="hidden" id="StudyTypeID" name="${click}[StudyTypeID][]" value="${StudyTypeID}">
            <input type="hidden" id="ConditionID" name="${click}[ConditionID][]" value="${ConditionID}">
            ${test}
            <div class="col-md-3 mb-2">
                <label for="Specification" class="form-label">Specifications</label><span style="color: red">*</span>
                <input type="text" class="form-control" id="Specification" name="${click}[Specification][]" placeholder="Specification" required>
            </div>
                ${html}
                <div class="col-md-1" style="margin-top: 43px;">
                            <span class="btn btn-danger btn-xs pull-right btn-del-api"><i class="fa fa-remove"></i></span>
                </div>
            </div>`;

            $('.hideCard').show();
            $('.float-right').show();
            $(".addRow").append(template);
            click++;
        }

        $('body').on('click', '.generate-form', function() {

            let BatchID = $('#BatchID').children("option:selected").val();
            let Headline = $('#Headline').val();
            let SkuID = $('#SkuID').children("option:selected").val();
            let PackID = $('#PackID').children("option:selected").val();
            let StudyTypeID = $('#StudyTypeID').children("option:selected").val();
            let ConditionID = $('#ConditionID').children("option:selected").val();

            if (!BatchID) {
                alert('Please select Batch!')
                return false;
            }

            if (!Headline) {
                alert('Please select Headline!')
                return false;
            }

            if (!SkuID) {
                alert('Please select Strength!')
                return false;
            }

            if (!PackID) {
                alert('Please select Unit Pack!')
                return false;
            }

            if (!StudyTypeID) {
                alert('Please select study type!')
                return false;
            }

            if (!ConditionID) {
                alert('Please select Condition!')
                return false;
            }

            // $('#BatchID').attr('disabled',true);
            // $('#SkuID').attr('disabled',true);
            // $('#PackID').attr('disabled',true);
            // $('#StudyTypeID').attr('disabled',true);
            // $('#ConditionID').attr('disabled',true);

            let url = "{{ route('ajax.condition') }}";
            let path = "{{ route('ajax.test.type') }}";

            $.ajax({
                type: 'GET',
                data: {
                    'StudyTypeID': StudyTypeID
                },
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    test =
                        `
                              <b style="font-size: 16px; color: red;">${click}</b>
                            <div class="col-md-2">
                            <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                            <select id="TestID" class="form-select custom-select TestID" name="${click}[TestID][]" required>
                                <option value="" selected disabled style="color:#002244;font-family: impact;">Select Test</option>`;

                    $.each(res.Test, function(key, value) {
                        test += `<option  value="t${value.TestID}">${value.TestName}</option>`;
                    });

                    test +=
                        `<option value="" disabled style="color:#002244;font-family: impact;">Select Sub Test</option>`;

                    $.each(res.SubTest, function(key, value) {
                        test +=
                            `<option  value="sub${value.SubTestID}">${value.SubTestName}</option>`;
                    });

                    test += `</select></div>`;


                    $.each(res.month, (key, value) => {
                        html += `<div class="col-md-2">
                        <label for="Value" class="form-label">${value}</label>
                        <span style="color: red">*</span>`;
                        html += `<input type="${type}" class="form-control" id="Value" name="${click}[Value][]"
                     placeholder="Conforms"
                     style="margin-right:15px;" value="${placeholder}">
                    </div>`;
                    });


                },
            });

            setTimeout(() => {
                getTemplate();
            }, 1000);

            html = '';
            test = '';
            type = '';
            placeholder = '';
        });
    </script>
@endpush
