@php
    $skus       = $protocol->product->skus ?? collect();
    $skuCount   = $skus->count();
    $totalsByCol = array_fill(0, max($skuCount, 1), 0);
@endphp
<table class="pdf-tbl">
    <thead>
        <tr>
            <th>Test No.</th>
            <th>Test Parameters</th>
            <th colspan="{{ max($skuCount, 1) }}">(No. of Unit Per Test)</th>
        </tr>
        <tr>
            <th colspan="2">Strength</th>
            @foreach ($skus as $sku)
                @php
                    $detail = \App\Models\ProductDetail::where('SkuID', $sku->SkuID)->first();
                @endphp
                <th>{{ $detail->ProductStrength ?? '' }}</th>
            @endforeach
            @if ($skuCount === 0)
                <th>&nbsp;</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($protocol->tests as $key => $element)
            @php
                $testName = optional(\App\Models\Test::find($element->TestID))->TestName;
                $values   = json_decode($element->Value) ?: [];
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $testName }}</td>
                @foreach ($values as $i => $unit)
                    <td>{{ $unit }}</td>
                    @php
                        if (isset($totalsByCol[$i])) {
                            $totalsByCol[$i] += (int) $unit;
                        }
                    @endphp
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><strong>Total Number of Unit</strong></td>
            @foreach ($totalsByCol as $total)
                <td><strong>{{ $total }}</strong></td>
            @endforeach
        </tr>
        @php
            $bottleLabels = [];
            $bottleCounts = [];
            if (! is_null($protocol->protocolTestPackBottle)) {
                $bottleLabels = json_decode($protocol->protocolTestPackBottle->PackID) ?: [];
                $bottleCounts = json_decode($protocol->protocolTestPackBottle->NumberOfBottle) ?: [];
            }
        @endphp
        @if (! empty($bottleLabels))
            <tr>
                <td colspan="2"><strong>Total Number of Bottle/Blister/Samples</strong></td>
                @for ($i = 0; $i < max($skuCount, 1); $i++)
                    <td>
                        @if (isset($bottleLabels[0]))
                            For {{ $bottleLabels[0] }}{{ \Illuminate\Support\Str::endsWith($bottleLabels[0], 's') ? '' : 's' }}
                        @endif
                        @if (isset($bottleCounts[$i]) && is_iterable($bottleCounts[$i]))
                            <div>{{ collect($bottleCounts[$i])->implode(' / ') }}</div>
                        @endif
                    </td>
                @endfor
            </tr>
        @endif
    </tbody>
</table>
