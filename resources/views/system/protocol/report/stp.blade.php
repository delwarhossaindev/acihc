<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white">
    <thead>
        <tr>
            <th>Strength</th>
            <th>Specification No.</th>
            <th>Standard Test Procedure No.</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->protocolProductDetails as $item)
        <tr>
            <td align="center">{{ @App\Models\ProductDetail::where('SkuID',$item->SkuID)->first()['ProductStrength'] }} mg</td>
            <td align="center">{{ $item->SpecificationNo }}</td>
            @if($loop->first)
            <td align="center" rowspan="{{ $protocol->protocolProductDetails->count() }}">{{ $item->STPNo }}</td>
            @endif
        </tr>
        @empty
        @endforelse
        {{-- <tr>
            <td align="center">5 mg</td>
            <td align="center">000003163</td>
            <td align="center" rowspan="2">000003122</td>
        </tr>
        <tr>
            <td align="center">10 mg</td>
            <td align="center">000003164</td>
        </tr> --}}
    </tbody>
</table>