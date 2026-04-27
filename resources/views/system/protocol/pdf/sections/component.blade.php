@php
    $containerIDs = \App\Models\ProtocolSkuPack::where('ProtocolID', $protocol->ProtocolID)
        ->pluck('ContainerID')->toArray();
    $containers = \App\Models\Container::whereIn('ContainerID', array_unique($containerIDs))
        ->with('packaging')->get();
@endphp
<table class="pdf-tbl">
    <thead>
        <tr>
            <th style="width:40%;">Packaging Material</th>
            <th>Details information</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($containers as $container)
            @foreach ($container->packaging as $pkg)
                <tr>
                    <td>{{ $pkg->PackagingName }}</td>
                    <td class="text-left">
                        <div>Source: {{ $pkg->PackagingSource ?? 'N/A' }}</div>
                        <div>DMF: {{ $pkg->PackagingDMF ?? 'N/A' }}</div>
                        <div>Resin: {{ $pkg->PackagingResin ?? 'N/A' }}</div>
                        <div>Colorant: {{ $pkg->PackagingColorant ?? 'N/A' }}</div>
                    </td>
                </tr>
            @endforeach
        @empty
            <tr><td colspan="2">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
