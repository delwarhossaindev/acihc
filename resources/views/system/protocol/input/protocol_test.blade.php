@php
    $bottles = isset($protocol->protocolTestPackBottle->NumberOfBottle)
        ? json_decode($protocol->protocolTestPackBottle->NumberOfBottle)
        : null;
    $count = 0;
    $skus  = $protocol->product->skus;
    $skuColMd = match ($skus->count()) {
        1 => 7,
        2 => 3,
        3 => 1,
        default => 2,
    };
@endphp

<div class="card mb-2">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-9">
                <label class="form-label">Test <span class="text-danger">*</span></label>
                <select id="TestID" class="form-select TestID" {{ $protocol->tests->count() > 0 ? '' : 'required' }}>
                    <option value="" selected disabled>Select Test</option>
                    @foreach (\App\Models\Test::orderBy('TestName', 'asc')->get() as $test)
                        <option value="t{{ $test->TestID }}">{{ $test->TestName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-secondary generate-form w-100">Create Row</button>
            </div>
        </div>
    </div>
</div>

@if ($protocol->tests->count() > 0)
    <div class="card mt-2">
        <div class="card-body">
            @foreach ($protocol->tests as $key => $test)
                @php $strengths = json_decode($test->Value); @endphp
                <div class="row g-3 align-items-end mb-2">
                    <input type="hidden" name="{{ $count }}[TestID][]" value="t{{ $test->TestID }}">
                    <div class="col-md-4">
                        <label class="form-label">Test <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ \App\Models\Test::find($test->TestID)->TestName ?? '' }}" required readonly>
                    </div>
                    @forelse ($skus as $skuKey => $item)
                        @php $strength = \App\Models\ProductDetail::where('SkuID', $item->SkuID)->first()->ProductStrength ?? ''; @endphp
                        <div class="col-md-{{ $skuColMd }}">
                            <label class="form-label">{{ $strength }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="{{ $count }}[Value][]" placeholder="Unit per test" required value="{{ $strengths[$skuKey] ?? null }}">
                        </div>
                    @empty
                    @endforelse
                    @php $count++; @endphp
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-del-test w-100" title="Remove">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            @foreach ($protocol->subtests as $key => $subtest)
                @php $strengths = json_decode($subtest->Value); @endphp
                <div class="row g-3 align-items-end mb-2">
                    <input type="hidden" name="{{ $count }}[TestID][]" value="sub{{ $subtest->SubTestID }}">
                    <div class="col-md-4">
                        <label class="form-label">Sub Test <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ \App\Models\Subtest::find($subtest->SubTestID)->SubTestName ?? '' }}" required readonly>
                    </div>
                    @forelse ($skus as $skuKey => $item)
                        @php $strength = \App\Models\ProductDetail::where('SkuID', $item->SkuID)->first()->ProductStrength ?? ''; @endphp
                        <div class="col-md-{{ $skuColMd }}">
                            <label class="form-label">{{ $strength }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="{{ $count }}[Value][]" placeholder="Unit per test" required value="{{ $strengths[$skuKey] ?? null }}">
                        </div>
                    @empty
                    @endforelse
                    @php $count++; @endphp
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-del-test w-100" title="Remove">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Unit Pack <span class="text-danger">*</span></label>
                    @if (! is_null($protocol->protocolTestPackBottle))
                        @foreach (json_decode($protocol->protocolTestPackBottle->PackID) as $bottle)
                            <select class="form-select mt-1" name="test[PackID][]" required>
                                <option value="" selected disabled>Unit Pack</option>
                                @foreach ($protocol->product->packs as $pack)
                                    <option value="{{ $pack->PackValue }}" @selected($bottle == $pack->PackValue)>{{ $pack->PackValue }}</option>
                                @endforeach
                            </select>
                        @endforeach
                    @endif
                </div>

                @forelse ($skus as $skuKey => $item)
                    @php $strength = \App\Models\ProductDetail::where('SkuID', $item->SkuID)->first()->ProductStrength ?? ''; @endphp
                    <div class="col-md-{{ $skus->count() == 1 ? 10 : ($skus->count() == 2 ? 5 : 3) }}">
                        <label class="form-label">Unit Per Test <span class="text-danger">({{ $strength }})</span></label>
                        @if (isset($bottles[$skuKey]))
                            @foreach ($bottles[$skuKey] as $bk => $bv)
                                @if ($bv)
                                    <input type="number" name="test[UnitPerTest][{{ $bk }}][]" class="form-control mt-1" placeholder="Enter value" value="{{ $bv }}">
                                @endif
                            @endforeach
                        @endif
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endif

<div class="card mt-2 hideCard" style="display: none;">
    <div class="card-body addRow"></div>
    <hr>
    <div class="card-body">
        <div class="row g-3 align-items-end test-duplicable">
            <div class="col-md-4 pack-box">
                <label class="form-label">Unit Pack <span class="text-danger">*</span></label>
                <select class="select2 form-select pack pack-order" name="test[PackID][]">
                    <option value="" selected disabled>Unit Pack</option>
                    @foreach ($protocol->product->packs as $pack)
                        <option value="{{ $pack->PackValue }}">{{ $pack->PackValue }}</option>
                    @endforeach
                </select>
            </div>

            @forelse ($skus as $skuKey => $item)
                @php $strength = \App\Models\ProductDetail::where('SkuID', $item->SkuID)->first()->ProductStrength ?? ''; @endphp
                <div class="col">
                    <label class="form-label">Unit Per Test <span class="text-danger">({{ $strength }}) mg</span></label>
                    <input type="number" name="test[UnitPerTest][{{ $skuKey }}][]" class="form-control unit_per_test" placeholder="Enter values with commas">
                </div>
            @empty
            @endforelse
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-del-test w-100" title="Remove">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-outline-success btn-sm add-test">
                <i class="fa fa-plus"></i> Add Row
            </button>
        </div>
    </div>
</div>

<div class="flaot-right d-flex justify-content-end mt-3">
    @if (isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4 && $protocol->ProtocolID != 10)
        <button type="button" class="btn btn-primary ajax-approval-modal-btn">Save changes</button>
    @else
        <button type="submit" class="btn btn-primary disabled-button" {{ $protocol->tests->count() > 0 ? '' : 'disabled' }}>Save Changes</button>
    @endif
</div>

<input id="count" value="{{ $count }}" type="hidden">

@push('script')
<script type="text/javascript">
    $(document).on('click', '.add-test', function() {
        var $parent = $(this).parent().parent();
        $parent.find('.pack-box select').select2('destroy');
        $parent.find('.test-duplicable').clone()
            .insertBefore($(this).parent())
            .removeClass('test-duplicable')
            .find(':not(select).form-control').val('');
        $parent.find('.pack-box select').select2();
        $('.btn-del-test').fadeIn();
    });

    var html = '';
    var click = $('#count').val() == '0' ? 0 : $('#count').val();

    const getTemplate = () => {
        let TestID = $('#TestID').children('option:selected').val();
        let TestName = $('#TestID').children('option:selected').text();
        var template = `<div class="row g-3 align-items-end mb-2" data-remove="${click}">
            <input type="hidden" name="${click}[TestID][]" value="${TestID}">
            <div class="col-md-4">
                <label class="form-label">Test <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="${TestName}" required readonly>
            </div>
            ${html}
        </div>`;

        $('.hideCard').show();
        $('.flaot-right').show();
        $('.addRow').append(template);
        click++;
    }

    $('body').on('click', '.generate-form', function() {
        $('.disabled-button').attr('disabled', false);
        let ProtocolID = "{{ $protocol->ProtocolID }}";
        $.ajax({
            type: 'GET',
            data: { 'ProtocolID': ProtocolID },
            url: "{{ route('ajax.strength') }}",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                $.each(res.strengths, (key, value) => {
                    html += `<div class="col-md-2">
                        <label class="form-label">${value} mg <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="${click}[Value][]" required>
                    </div>`;
                });
                html += `<div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-del-test w-100"><i class="fa fa-remove"></i></button>
                </div>`;
            },
        });
        setTimeout(() => {
            getTemplate();
        }, 1000);
        html = '';
    });

    $(document).on('click', '.btn-del-test', function() {
        $(this).closest('.row').remove();
    });
</script>
@endpush
