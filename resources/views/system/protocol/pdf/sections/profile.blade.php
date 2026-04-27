<table class="pdf-tbl">
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
            @php
                $productDetail = \App\Models\ProductDetail::where('SkuID', $package->SkuID)->first();
                $pack          = \App\Models\Pack::where('PackID', $package->PackID)->first();

                $namesFromIds = function ($ids) {
                    return collect($ids)
                        ->map(fn ($id) => optional(\App\Models\Packaging::where('PackagingID', $id)->first())->PackagingName)
                        ->filter()
                        ->implode(', ');
                };
                $primary   = $namesFromIds($package->primary->pluck('ContainerID'));
                $secondary = $namesFromIds($package->secondary->pluck('ContainerID'));
                $tertiary  = $namesFromIds($package->tertiary->pluck('ContainerID'));
            @endphp
            <tr>
                <td>{{ $productDetail->ProductStrength ?? '' }}</td>
                <td>{{ ($pack->PackValue ?? '') }}’s</td>
                <td>{{ $primary }}</td>
                <td>{{ $secondary ?: 'N/A' }}</td>
                <td>{{ $tertiary ?: 'N/A' }}</td>
            </tr>
        @empty
            <tr><td colspan="5">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
