@php
    if (isset($protocol)) {
        $product = $protocol->product;
    }
@endphp

@if (isset($protocol))
    <div class="row g-3">
        @php
            $batchs = \App\Models\Batch::where('ProtocolID', $protocol->ProtocolID)->get();
        @endphp
        @if (count($batchs) > 0)
            @foreach ($batchs as $item)
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="Test" class="form-label">Batch</label>
                        <input type="text" class="form-control" value="{{ $item->BatchName }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="Sku" class="form-label">Strength</label>
                        @php
                            $ProductDetail = App\Models\ProductDetail::where('SkuID', $item->SkuID)->first();
                        @endphp
                        <input type="text" class="form-control"
                            value="{{ $ProductDetail ? $ProductDetail['ProductStrength'] : null }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="Sku" class="form-label">Batch No</label>
                        <input type="text" class="form-control" value="{{ $item->BatchNo }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="Sku" class="form-label">Batch Size</label>
                        <input type="text" class="form-control" value="{{ $item->BatchSize }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="Sku" class="form-label">Mfg Date</label> (mm/dd/yy)
                        <input type="text" class="form-control" value="{{ $item->MfgDate }}">
                    </div>
                    <div class="col-md-5 mt-3">
                        <label for="Sku" class="form-label">Stability Initiation Date</label> (mm/dd/yy)
                        <input type="text" class="form-control input6" value="{{ $item->SIDate }}">
                    </div>
                </div>
            @endforeach
        @else
            Please create batch for this protocol first!
        @endif
    </div>
@else
    <p>Please create batch for this protocol first!</p>
@endif
