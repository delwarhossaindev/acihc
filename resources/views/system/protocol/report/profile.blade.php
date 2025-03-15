<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white" style="margin-top:2px;">
    <thead>
        <tr>
            <th>Strength</th>
            <th>Pack Details</th>
            <th>Pack 1 (Primary Packaging)</th>
            <th>Pack 2 (Secondary Packaging)</th>
            <th>Pack 3 (Tertiary Packaging)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->packagings as $package)
            <tr>
                <td align="center">
                    @php
                        $ProductDetail = App\Models\ProductDetail::where('SkuID', $package->SkuID)->first();
                    @endphp
                    {{ $ProductDetail ? $ProductDetail['ProductStrength'] : null }} mg</td>
                <td align="center">{{ \App\Models\Pack::where('PackID', $package->PackID)->first()['PackValue'] }}’s</td>
                <td align="center">
                    @forelse ($package->primary->pluck('ContainerID') as $item)
                        {{ App\Models\Packaging::where('PackagingID', $item)->first()['PackagingName'] }} @if (!$loop->last)
                            ,
                        @endif
                    @empty
                    @endforelse
                </td>
                <td align="center">
                    @forelse ($package->secondary->pluck('ContainerID') as $item)
                        {{ App\Models\Packaging::where('PackagingID', $item)->first()['PackagingName'] ?? 'N/A' }}
                        @if (!$loop->last)
                            ,
                        @endif
                    @empty
                    @endforelse
                </td>
                <td align="center">
                    @forelse ($package->tertiary->pluck('ContainerID') as $item)
                        {{ App\Models\Packaging::where('PackagingID', $item)->first()['PackagingName'] ?? 'N/A' }}
                        @if (!$loop->last)
                            ,
                        @endif
                    @empty
                    @endforelse
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
