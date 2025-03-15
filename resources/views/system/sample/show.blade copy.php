@extends('admin.layouts.master')

@push('style')
<link rel="stylesheet" href="{{ asset('css/tagify/tagify.css') }}"/>
@endpush

@section('content')

    <h4 class="fw-bold py-1 mb-3">Create Report</h4>

    <x-alert.alert-component />
    
    @php 
        $protocol = $sample->protocol;
        $batchs     = @App\Models\Batch::query()->where('ProtocolID',$protocol->ProtocolID)
                        ->get()->unique('BatchNo');;
        $studyTypes = @App\Models\ProtocolStabilityStudy::query()
                        ->where('ProtocolID',$protocol->ProtocolID)
                        ->pluck('StudyTypeID')->toArray();
        $conditions = @App\Models\StudyType::query()
                        ->whereIn('StudyTypeID',$studyTypes)
                        ->get();
        
    @endphp
    
    <form 
        action="{{ route('sample.submit',$sample->SampleID) }}" 
        method="post"
        class="needs-validation" 
        role="form"
        novalidate
    >
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- <div class="col-md-2">
                    <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                        <select id="TestID" class="form-select custom-select TestID" required>
                        <option value="" selected disabled style="color:#002244;font-family: impact;">Select Test</option>
                        @foreach (\App\Models\Test::all() as $test)
                            <option value="t{{ $test->TestID }}">
                                {{ $test->TestName }}
                            </option>
                         @endforeach
                        <option value="" disabled style="color:#002244;font-family: impact;">Select Sub Test</option>
                        @foreach (\App\Models\SubTest::all() as $subTest)
                            <option value="sub{{ $subTest->SubtestID }}">
                                {{ $subTest->SubTestName }}
                            </option>       
                            
                         @endforeach
                    </select>
                </div> -->
                <div class="col-md-2">
                    <label for="BatchID" class="form-label">Batch</label><span style="color: red">*</span>
                    <select id="BatchID" class="form-select custom-select" required>
                        <option value="" selected disabled>Select Batch</option>
                        @foreach ($batchs as $batch)
                            <option value="{{ $batch->BatchID }}">
                                {{ $batch->BatchNo }}
                            </option>
                         @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="SkuID" class="form-label">Strength</label><span style="color: red">*</span>
                        <select id="SkuID" class="form-select custom-select" required name="SkuID">
                        <option value="" selected disabled>Select Strength</option>
                        @foreach ($protocol->product->details as $strength)
                            <option value="{{ $strength->SkuID }}">
                                {{ $strength->ProductStrength }} mg
                            </option>
                         @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="PackID" class="form-label">Unit Pack</label><span style="color: red">*</span>
                        <select id="PackID" class="form-select custom-select" required name="PackID">
                        <option value="" selected disabled>Select Pack</option>
                        @foreach (\App\Models\Pack::all() as $pack)
                            <option value="{{ $pack->PackID }}">
                                {{ $pack->PackValue }}
                            </option>
                         @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="StudyTypeID" class="form-label">Study Type</label><span style="color: red">*</span>
                        <select id="StudyTypeID" class="form-select custom-select" required>
                        <option value="" selected disabled>Select Batch</option>
                        @foreach ($conditions as $condition)
                            <option value="{{ $condition->StudyTypeID  }}">
                                {{ $condition->StudyTypeName }}({{ implode( " ",$condition->details->pluck('StudyTypeMonth')->toArray()) }})
                            </option>
                         @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="ConditionID" class="form-label">Condition</label><span style="color: red">*</span>
                        <select id="ConditionID" class="form-select custom-select" required>
                        <option value="" selected disabled>Select Condition</option>
                        @foreach (\App\Models\Condition::all() as $condition)
                            <option value="{{ $condition->ConditionID  }}">
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

    <div class="card mt-1 hideCard" style="display: none;">
        <div class="card-body addRow">
            
        </div>
    </div>
    <div class="flaot-right" style="display: none;">
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
            </div>
        </div>
       </div>
    </form>
@endsection

@push('script')
<script type="text/javascript">
    
    var html = '';
    var click = 0;
    var type = 'text';
    var placeholder = '';
    
    $('body').on('click','.btn-del-api', function(){
        $(this).parent().parent().remove(); remove
    });

    const getTemplate = () => {
       // let TestID = $('#TestID').children("option:selected").val();
        let SkuID = $('#SkuID').children("option:selected").val();
        let PackID = $('#PackID').children("option:selected").val();
        let BatchID = $('#BatchID').children("option:selected").val();
        let ConditionID = $('#ConditionID').children("option:selected").val();
        let StudyTypeID = $('#StudyTypeID').children("option:selected").val();

        var template = `<div class="row" data-remove="${click}">
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
        $('.flaot-right').show();
        $(".addRow").append(template);
        click++;
    }

    $('body').on('click','.generate-form',function(){
        
        //let TestID = $('#TestID').children("option:selected").val();

        let BatchID = $('#BatchID').children("option:selected").val();
        let SkuID = $('#SkuID').children("option:selected").val();
        let PackID = $('#PackID').children("option:selected").val();
        let StudyTypeID = $('#StudyTypeID').children("option:selected").val();
        let ConditionID = $('#ConditionID').children("option:selected").val();
        
        // if(!TestID){
        //    alert('Please select Test!')
        //    return false;
        // }

        if(!BatchID){
           alert('Please select Batch!')
           return false;
        }

        if(!SkuID){
           alert('Please select Strength!')
           return false;
        }

        if(!PackID){
           alert('Please select Unit Pack!')
           return false;
        }

        if(!StudyTypeID){
           alert('Please select study type!')
           return false;
        }

        if(!ConditionID){
           alert('Please select Condition!')
           return false;
        }
        
        $('#BatchID').attr('disabled',true);
        $('#SkuID').attr('disabled',true);
        $('#PackID').attr('disabled',true);
        $('#StudyTypeID').attr('disabled',true);
        $('#ConditionID').attr('disabled',true);

        url = "{{ route('ajax.condition') }}";
        path = "{{ route('ajax.test.type') }}";

        // $.ajax({
        //     type: 'GET',
        //     data: {'TestID': TestID},
        //     url: path,
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success: function(res) {
        //         if(res.type == 'text') {
        //             type = 'text';
        //             placeholder = 'Conforms'
        //         }
        //         else if(res.type == 'min_max_avg'){
        //             type = 'text';
        //             placeholder = 'min_max_avg'
        //         }else if(res.type == 'date') {
        //             var nowDate = new Date(); 
        //             var date = nowDate.getFullYear()+'/'+(nowDate.getMonth()+1)+'/'+nowDate.getDate(); 
        //             type = 'date';
        //             placeholder = date;
        //         }else{
        //             type = 'text';
        //             placeholder = ''
        //         }
        //     },
        // });

        $.ajax({
            type: 'GET',
            data: {'StudyTypeID': StudyTypeID},
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                 test = `<div class="col-md-2">
                            <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                            <select id="TestID" class="form-select custom-select TestID" name="${click}[TestID][]" required>
                                <option value="" selected disabled style="color:#002244;font-family: impact;">Select Test</option>`;
                                
                        $.each(res.Test, function(key, value) {
                            test += `<option  value="${value.TestID}">${value.TestName}</option>`;
                        });

                        test += `<option value="" disabled style="color:#002244;font-family: impact;">Select Sub Test</option>`;
                        
                        $.each(res.SubTest, function(key, value) {
                            test += `<option  value="${value.SubTestID}">${value.SubTestName}</option>`;
                        });

                        test += `</select></div>`;
              

              $.each(res.month, (key, value) => {
                    html += `<div class="col-md-2">
                        <label for="Value" class="form-label">${value}</label>
                        <span style="color: red">*</span>`;
                    html += `<input type="${type}" class="form-control" id="Value" name="${click}[Value][]"
                     placeholder="${placeholder}"
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
