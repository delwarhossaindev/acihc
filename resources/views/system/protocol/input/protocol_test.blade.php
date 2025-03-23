
    @php
        if(isset($protocol)) {
            if(isset($protocol->protocolTestPackBottle->NumberOfBottle)){
                $bottles = json_decode($protocol->protocolTestPackBottle->NumberOfBottle);
            }
        }
        $count = 0;
    @endphp

    @if(isset($protocol))
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                    <select id="TestID" class="form-select custom-select TestID" {{ $protocol->tests->count() > 0 ? '' : 'required' }}>
                        <option value="" selected disabled style="color: #002244; font-weight:bold;">Select Test</option>
                        @foreach (\App\Models\Test::orderBy('TestName','asc')->get() as $test)
                        <option value="t{{ $test->TestID }}">{{ $test->TestName }}</option>
                        @endforeach
                        {{-- <option value="" disabled style="color: #002244; font-weight:bold;">Select Sub Test</option>
                        @foreach (\App\Models\SubTest::all() as $subTest)
                        <option value="sub{{ $subTest->SubtestID }}">{{ $subTest->SubTestName }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <div class="btn btn-secondary generate-form" style="margin-top: 20px;">Create Row</div>
                </div>
            </div>
        </div>
    </div>

    @if($protocol->tests->count() > 0)
    <div class="card mt-1">
        <div class="card-body">

                @foreach($protocol->tests as $key => $test)
                <div class="row">
                @php $strengths = json_decode($test->Value) @endphp
                    <input type="hidden" id="TestID" name="{{ $count }}[TestID][]" value="t{{ $test->TestID }}">
                    <div class="col-md-4 mb-2">
                        <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                        <input type="text" class="form-control" value="{{ App\Models\Test::find($test->TestID)->TestName }}" required>
                    </div>
                    @forelse ($protocol->product->skus as $key => $item)
                    <div class="col-md-@if($protocol->product->skus->count() == '1'){{ '8' }}
                        @elseif($protocol->product->skus->count() == '2'){{ '3' }}
                        @elseif($protocol->product->skus->count() == '3'){{ '1' }}
                        @endif">
                    <label for="Value" class="form-label">{{ App\Models\ProductDetail::where('SkuID',$item->SkuID)->first()['ProductStrength'] }} mg</label>
                        <span style="color: red">*</span>
                        <input type="number" class="form-control" id="Value" name="{{ $count }}[Value][]" placeholder="Unit per test" required style="margin-right:15px;" value="{{ $strengths[$key] ?? null }}">
                    </div>
                    @empty
                    @endforelse
                    @php
                        $count++;
                    @endphp

                      <div class="col-md-1" style="margin-top: 43px;">
                        <span class="btn btn-danger btn-xs pull-right btn-del-test"><i class="fa fa-remove"></i></span>
                    </div>
                </div>
                @endforeach

                @foreach($protocol->subtests as $key => $subtest)
                <div class="row">
                @php $strengths = json_decode($subtest->Value) @endphp
                    <input type="hidden" id="TestID" name="{{ $count }}[TestID][]" value="sub{{ $subtest->SubTestID }}">
                    <div class="col-md-4 mb-2">
                        <label for="TestID" class="form-label">Sub Test</label><span style="color: red">*</span>
                        <input type="text" class="form-control" value="{{ App\Models\Subtest::find($subtest->SubTestID)->SubTestName }}" required>
                    </div>
                    @forelse ($protocol->product->skus as $key => $item)
                    <div class="col-md-@if($protocol->product->skus->count() == '1'){{ '8' }}
                        @elseif($protocol->product->skus->count() == '2'){{ '3' }}
                        @elseif($protocol->product->skus->count() == '3'){{ '1' }}
                        @endif">
                    <label for="Value" class="form-label">{{ App\Models\ProductDetail::where('SkuID',$item->SkuID)->first()['ProductStrength'] }} mg</label>
                        <span style="color: red">*</span>
                        <input type="number" class="form-control" id="Value" name="{{ $count }}[Value][]" placeholder="Unit per test" required style="margin-right:15px;" value="{{ $strengths[$key] ?? null }}">
                    </div>
                    @empty
                    @endforelse
                    @php
                        $count++;
                    @endphp
                     <div class="col-md-1" style="margin-top: 43px;">
                        <span class="btn btn-danger btn-xs pull-right btn-del-test"><i class="fa fa-remove"></i></span>
                    </div>
                </div>
                @endforeach

        </div>
    </div>
    @endif

    @if($protocol->tests->count() > 0)
    <div class="card mt-1">
        <div class="card-body">
            <div class="row">

                <div class="col-md-2">
                    <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
                    @if(!is_null($protocol->protocolTestPackBottle))
                    @foreach (json_decode($protocol->protocolTestPackBottle->PackID) as $key => $bottle)
                    <select class="form-control mt-1" name="test[PackID][]">
                        <option value="" selected disabled>Unit Pack</option>
                        @foreach ($protocol->product->packs as $pack)
                            <option value="{{ $pack->PackValue }}" {{ $bottle == $pack->PackValue ? 'selected' : '' }}>{{ $pack->PackValue }}</option>
                        @endforeach
                    </select>
                    @endforeach
                    @endif
                </div>

                @forelse ($protocol->product->skus as $key => $item)
                <div class="mt-1 col-md-@if($protocol->product->skus->count() == '1'){{ '10' }}
                    @elseif($protocol->product->skus->count() == '2'){{ '5' }}
                    @elseif($protocol->product->skus->count() == '3'){{ '3' }}
                    @endif">
                    <label for="">Unit Per Test</label><span style="color: red">({{ App\Models\ProductDetail::where('SkuID',$item->SkuID)->first()['ProductStrength'] }}) mg</span>
                    @if(isset($protocol->protocolTestPackBottle->NumberOfBottle))
                    @if(isset($bottles[$key]))
                        @foreach ($bottles[$key] as $key => $item)
                        @if($item)
                        <input type="number" name="test[UnitPerTest][{{ $key }}][]" class="form-control mt-1" placeholder="Enter value" value="{{ $item }}">
                        @endif
                        @endforeach
                    @endif
                    @endif
                </div><br>
                @empty
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <div class="card mt-1 hideCard" style="display: none;">
        <div class="card-body addRow"></div>
        <hr>
        <div class="card-body">
            <div class="row test-duplicable">
                <div class="col-md-4 pack-box">
                    <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
                    <select class="select2 form-select form-select-lg select2-hidden-accessible pack pack-order" name="test[PackID][]">
                        <option value="" selected disabled>Unit Pack</option>
                        @foreach ($protocol->product->packs as $pack)
                            <option value="{{ $pack->PackValue }}">{{ $pack->PackValue }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-tooltip">Required</div>
                </div>

                @forelse ($protocol->product->skus as $key => $item)
                <div class="col mt-1">
                    <label for="">Unit Per Test</label><span style="color: red">({{ App\Models\ProductDetail::where('SkuID',$item->SkuID)->first()['ProductStrength'] }}) mg</span>
                    <input type="number" name="test[UnitPerTest][{{ $key }}][]" class="form-control unit_per_test" placeholder="Enter values with commas">
                    <div class="invalid-tooltip">Required</div>
                </div>
                @empty
                @endforelse
                <div class="col" style="margin-top: 43px;">
                    <span class="btn btn-danger btn-xs pull-right btn-del-test"><i class="fa fa-remove"></i></span>
                </div>
            </div>
            <div class="col-md-2" style="margin-left: 5px;">
                <span class="btn btn-success btn-xs add-test"><i class="fa fa-add"></i></span>
            </div>
        </div>
    </div>

    {{-- @if($protocol->tests->count() > 0) --}}
    {{-- style="display: {{ $protocol->tests->count() > 0 ? 'unset' : 'none' }};" --}}
    <div class="flaot-right">
        <div class="row">
            <div class="col-md-3">
                @if(isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)

                <button type="submit" class="btn btn-primary" id="saveChangesBtnTest" style="visibility: hidden;">Save changes</button>
                <button data-toggle='modal' data-target='#dynamicApprovalModal'  class='btn btn-primary  dynamic-approval-modal-btn ajax-approval-modal-btn'>Save changes</button>
                @else
        <button type="submit" class="btn btn-primary disabled-button" style="margin-top: 20px;" {{ $protocol->tests->count() > 0 ? '' : 'disabled' }}>Save Changes</button>
        @endif

            </div>
        </div>
    </div>
    {{-- @endif --}}

    @endif <!-- Root protocol exixting checking if -->
    <input id="count" value="{{ $count }}" type="hidden" />
@push('script')
<script type="text/javascript">

    $(document).on('click','.add-test', function(){
        $(this).parent().parent().find(".pack-box select").select2("destroy");
        $(this).parent().parent().find(".test-duplicable").clone().insertBefore($(this).parent()).removeClass("test-duplicable").find(":not(select).form-control").val("");
        $(this).parent().parent().find(".pack-box select").select2();
        $('.btn-del-test').fadeIn();
        $(this).parent().parent().find(".btn-del-test").click(function(e) {
            $(this).parent().parent().remove();
        });
    });

    var html = '';
    var click = $('#count').val() == '0' ? 0 : $('#count').val();

    $('body').on('click','.btn-del-api', function(){
        $(this).parent().parent().remove();
    });

    const getTemplate = () => {
        let TestID = $('#TestID').children("option:selected").val();
        let TestName = $('#TestID').children("option:selected").text();
        var template = `<div class="row" data-remove="${click}">
            <input type="hidden" id="TestID" name="${click}[TestID][]" value="${TestID}">
            <div class="col-md-4 mb-2">
                <label for="TestID" class="form-label">Test</label><span style="color: red">*</span>
                <input type="text" class="form-control" value="${TestName}" required>
            </div>
                ${html}
            </div>`;

        $('.hideCard').show();
        $('.flaot-right').show();
        $(".addRow").append(template);
        click++;
    }

    $('body').on('click','.generate-form',function(){
        $('.disabled-button').attr('disabled',false);
        let ProtocolID = "{{ isset($protocol) ? $protocol->ProtocolID : '' }}";
        $.ajax({
            type: 'GET',
            data: {'ProtocolID': ProtocolID},
            url: "{{ route('ajax.strength') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                $.each(res.strengths, (key, value) => {
                    html += `<div class="col-md-2">
                        <label for="Value" class="form-label">${value} mg</label>
                        <span style="color: red">*</span>`;
                    html += `<input type="number" class="form-control" id="Value" name="${click}[Value][]" required style="margin-right:15px;">
                    </div>`;
                });
                html += `<div class="col-md-1" style="margin-top: 43px;">
                            <span class="btn btn-danger btn-xs pull-right btn-del-api"><i class="fa fa-remove"></i></span>
                        </div>`;
            },
        });
        setTimeout(() => {
            getTemplate();
        }, 1000);
        html = '';
    });

     // Delete Test
     $(document).on('click', '.btn-del-test', function() {
        $(this).closest('.row').remove();
    });
</script>
@endpush
