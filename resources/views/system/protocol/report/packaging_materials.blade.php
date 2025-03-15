<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white">
    <thead>
        <tr>
            <th>Strength</th>
            <th>No. of units per packs</th>
            <th>Type of Packing</th>
            <th>Container / Closure system</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->sku as $packaging)
            <tr>
                <td align="center">
                    @php
                        $ProductDetail = App\Models\ProductDetail::where('SkuID', $packaging->SkuID)->first();
                    @endphp
                    {{ $ProductDetail ? $ProductDetail['ProductStrength'] : null }}
                    mg
                </td>
                <td align="center">{{ $packaging->perUnit->pack->PackValue ?? 'N/A' }}’s</td>
                <td align="center">
                    {{ App\Models\Container::where('ContainerID', $packaging->ContainerID)->first()['ContainerType'] }}
                </td>
                @php
                    $packagings = App\Models\Container::where('ContainerID', $packaging->ContainerID)
                        ->with('packaging')
                        ->first();
                @endphp
                <td align="center">
                    {{ implode(',', $packagings->packaging->pluck('PackagingName')->toArray()) }}
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
