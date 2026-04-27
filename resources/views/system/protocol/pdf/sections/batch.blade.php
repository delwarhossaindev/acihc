@php
    $batches = \App\Models\Batch::where('ProtocolID', $protocol->ProtocolID)->get();
@endphp
<table class="pdf-tbl">
    <thead>
        <tr>
            <th>Batch Type</th>
            <th>Strength</th>
            <th>Batch No.</th>
            <th>Batch Size</th>
            <th>Mfg. Date</th>
            <th>Stability Initiation Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($batches as $batch)
            @php
                $productDetail = \App\Models\ProductDetail::where('SkuID', $batch->SkuID)->first();
            @endphp
            <tr>
                <td>{{ $batch->BatchName ?? 'N/A' }}</td>
                <td>{{ $productDetail->ProductStrength ?? '' }}</td>
                <td>{{ $batch->BatchNo }}</td>
                <td>{{ $batch->BatchSize }}</td>
                <td>{{ $batch->MfgDate ? \Carbon\Carbon::parse($batch->MfgDate)->format('M, Y') : '' }}</td>
                <td>{{ $batch->SIDate ? \Carbon\Carbon::parse($batch->SIDate)->toFormattedDateString() : '' }}</td>
            </tr>
        @empty
            <tr><td colspan="6">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
