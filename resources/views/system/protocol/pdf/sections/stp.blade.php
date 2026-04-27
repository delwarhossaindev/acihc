<table class="pdf-tbl">
    <thead>
        <tr>
            <th>Strength</th>
            <th>Specification No.</th>
            <th>Standard Test Procedure No.</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->protocolProductDetails as $item)
            @php
                $product = \App\Models\ProductDetail::where('SkuID', $item->SkuID)->first();
            @endphp
            <tr>
                <td>{{ $product->ProductStrength ?? '' }}</td>
                <td>{{ $item->SpecificationNo }}</td>
                <td>{{ $item->STPNo }}</td>
            </tr>
        @empty
            <tr><td colspan="3">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
