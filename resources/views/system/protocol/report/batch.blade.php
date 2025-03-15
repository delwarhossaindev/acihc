<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white" style="margin-top:2px;">
    @php
        $batchs = \App\Models\Batch::where('ProtocolID', $protocol->ProtocolID)->get();
    @endphp
    <thead>
        <tr>
            <th>Batch</th>
            <th>Strength</th>
            <th>Batch No.</th>
            <th>Batch Size</th>
            <th>Mfg. Date</th>
            <th>Stability Initiation Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($batchs as $batch)
            <tr>
                <td align="center">{{ $batch->BatchName ?? 'N/A' }}</td>
                <td align="center">
                    @php
                        $ProductDetail = App\Models\ProductDetail::where('SkuID', $batch->SkuID)->first();
                    @endphp
                    {{ $ProductDetail ? $ProductDetail['ProductStrength'] : null }} mg</td>
                <td align="center">{{ $batch->BatchNo }}</td>
                <td align="center">{{ $batch->BatchSize }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($batch->MfgDate)->toFormattedDateString() }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($batch->SIDate)->toFormattedDateString() }}</td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
