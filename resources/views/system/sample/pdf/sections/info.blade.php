@php
    use App\Models\ProtocolProductDetail;
    use Carbon\Carbon;
@endphp
<table class="pdf-info">
    <tr>
        <th>Product Name:</th>
        <td colspan="3">{{ $sampleReport->sample->product->ProductName ?? '' }}</td>
    </tr>
    <tr>
        <th>Batch No:</th>
        <td>{{ optional($sampleReport->batch)->BatchNo ?? 'N/A' }}</td>
        <th>Strorage Conditions:</th>
        <td>{{ $sampleReport->condition->ConditionName ?? '' }}</td>
    </tr>
    <tr>
        <th>Batch Size:</th>
        <td>{{ optional($sampleReport->batch)->BatchSize ?? 'N/A' }}</td>
        <th>Mfg Date:</th>
        <td>{{ optional($sampleReport->batch)->MfgDate ? Carbon::parse($sampleReport->batch->MfgDate)->toFormattedDateString() : 'N/A' }}</td>
    </tr>
    <tr>
        <th>Protocol No:</th>
        <td>STB/PROT/{{ sprintf('%04d', $sampleReport->sample->protocol->ProtocolID) }},Rev:{{ $versionCount }}</td>
        <th>Expiry Date:</th>
        <td>{{ optional($sampleReport->batch)->ExpDate ? Carbon::parse($sampleReport->batch->ExpDate)->toFormattedDateString() : 'To Be Defined' }}</td>
    </tr>
    <tr>
        <th>Specification No:</th>
        <td>{{ $sampleReport->sample->SpecificationNo ?: optional(ProtocolProductDetail::where('ProtocolID', $sampleReport->sample->protocol->ProtocolID)->first())->SpecificationNo }}</td>
        <th>Pakaging Date:</th>
        <td>{{ $sampleReport->sample->PackagingDate ? Carbon::parse($sampleReport->sample->PackagingDate)->toFormattedDateString() : '' }}</td>
    </tr>
    <tr>
        <th>STP No:</th>
        <td>{{ $sampleReport->sample->STPNo ?: optional(ProtocolProductDetail::where('ProtocolID', $sampleReport->sample->protocol->ProtocolID)->first())->STPNo }}</td>
        <th>Stability Initiation Date:</th>
        <td>{{ optional($sampleReport->batch)->SIDate ? Carbon::parse($sampleReport->batch->SIDate)->toFormattedDateString() : 'N/A' }}</td>
    </tr>
    <tr>
        <th>Name Of the API:</th>
        <td>{{ implode(',', $ApiDetailName) }}</td>
        <th>Reason of the Stability:</th>
        <td>{{ optional($sampleReport->batch)->BatchName ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>API Manufacturer:</th>
        <td>{{ implode(',', $APIDetailSource) }}</td>
        <th>API Lot No:</th>
        <td>{{ implode(',', $ApiLot) }}</td>
    </tr>
    <tr>
        <th>Mfg. & Packaging Site:</th>
        <td colspan="3">ACI HealthCare Limited, Sonargaon Museum Gate-1 Road, Treepordi, Sonargaon, Narayanganj, 1440, Bangladesh (BGD)</td>
    </tr>
    <tr>
        <th>Description of Pack:</th>
        <td colspan="3">{{ optional($sampleReport->batch)->DescriptionOfPack ?? 'N/A' }}</td>
    </tr>
    @if ($containersCount > 0)
        @php $first = true; @endphp
        @foreach ($containers as $container)
            @foreach ($container->packaging as $pkg)
                <tr>
                    @if ($first)
                        <th rowspan="{{ $containersCount }}">Description of the Primary Packaging Material</th>
                        @php $first = false; @endphp
                    @endif
                    <td colspan="3" class="pdf-info-pkg">
                        <div><strong>{{ $pkg->PackagingName }}</strong></div>
                        <div>Source: {{ $pkg->PackagingSource ?? 'N/A' }}</div>
                        <div>DMF: {{ $pkg->PackagingDMF ?? 'N/A' }}</div>
                        <div>Resin: {{ $pkg->PackagingResin ?? 'N/A' }}</div>
                        <div>Colorant: {{ $pkg->PackagingColorant ?? 'N/A' }}</div>
                    </td>
                </tr>
            @endforeach
        @endforeach
    @endif
</table>
