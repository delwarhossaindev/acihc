@php
    $batches = \App\Models\Batch::where('ProtocolID', $protocol->ProtocolID)->get();
@endphp

<div class="row g-3">
    @forelse ($batches as $item)
        @php
            $strength = optional(\App\Models\ProductDetail::where('SkuID', $item->SkuID)->first())->ProductStrength ?? '';
        @endphp
        <div class="col-12">
            <div class="card border">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Batch</label>
                            <input type="text" class="form-control" value="{{ $item->BatchName }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Strength</label>
                            <input type="text" class="form-control" value="{{ $strength }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Batch No</label>
                            <input type="text" class="form-control" value="{{ $item->BatchNo }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Batch Size</label>
                            <input type="text" class="form-control" value="{{ $item->BatchSize }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mfg Date</label>
                            <input type="text" class="form-control" value="{{ $item->MfgDate }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stability Initiation Date</label>
                            <input type="text" class="form-control" value="{{ $item->SIDate }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info mb-0">Please create batch for this protocol first!</div>
        </div>
    @endforelse
</div>
