<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white"
style="margin-top:2px;">
<thead>
    <tr>
        <th>Packaging Material</th>
        <th>Components</th>
    </tr>
</thead>
@php 
  $containerIDs = @App\Models\ProtocolSkuPack::where('ProtocolID',$protocol->ProtocolID)->pluck('ContainerID')->toArray();
  $containers = @App\Models\Container::whereIn('ContainerID',array_unique($containerIDs))
                    ->with('packaging')
                    ->get();
@endphp
<tbody>
    @forelse ($containers as $container)
       @foreach ($container->packaging as $packagingProfile)
        <tr>
            <td align="center">{{ $packagingProfile->PackagingName }}</td>
            <td align="center">
                <p style="text-align:left;">Source: {{ $packagingProfile->PackagingSource ?? 'N/A' }}
                </p>
                <p style="text-align:left;">DMF: {{ $packagingProfile->PackagingDMF ?? 'N/A'}}</p>
                <p style="text-align:left;">Resin: {{ $packagingProfile->PackagingResin ?? 'N/A' }}</p>
                <p style="text-align:left;">Colorant: {{ $packagingProfile->PackagingColorant ?? 'N/A' }}
                </p>
            </td>
        </tr>
       @endforeach
    @empty
    @endforelse
</tbody>
</table>