<table class="pdf-tbl">
    <thead>
        <tr>
            <th>Strength</th>
            <th>No. of units per packs</th>
            <th>Type of Packing</th>
            <th>Container / Closure system / Blister</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->sku as $packaging)
            @php
                $productDetail = \App\Models\ProductDetail::where('SkuID', $packaging->SkuID)->first();
                $container     = \App\Models\Container::with('packaging')->where('ContainerID', $packaging->ContainerID)->first();
                $packagingNames = $container && $container->packaging
                    ? $container->packaging->pluck('PackagingName')->implode(', ')
                    : '';
            @endphp
            <tr>
                <td>{{ $productDetail->ProductStrength ?? '' }}</td>
                <td>{{ ($packaging->perUnit->pack->PackValue ?? 'N/A') }}’s</td>
                <td>{{ $container->ContainerType ?? '' }}</td>
                <td>{{ $packagingNames }}</td>
            </tr>
        @empty
            <tr><td colspan="4">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
