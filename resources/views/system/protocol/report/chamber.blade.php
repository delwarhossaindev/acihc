<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white" style="margin-top:2px;">
    <thead>
        @php
            $duration = [];
            $PlaceboSkuUnitPack = \DB::table('PlaceboSkuUnitPack')->where('ProtocolID',$protocol->ProtocolID)->first();
            $PlaceboSkuUnitPackMonth = $PlaceboSkuUnitPack ? json_decode($PlaceboSkuUnitPack->Month) : [];
        @endphp
        @forelse($protocol->statbilityStudy as $statbility)
            @php
                $duration = $statbility->study->details->pluck('StudyTypeMonth');
            @endphp
        @empty
        @endforelse
        <tr>
            <th rowspan="2">Strength (mg)</th>
            <th rowspan="2">Count</th>
            @forelse($duration as $month)
                <th>{{ $month ?? null }} M</th>
            @empty
            @endforelse
            <th rowspan="2">Additional Sample</th>
            <th rowspan="2">Total</th>
        </tr>
        <tr>

         @if (isset($stabilityDesignTitle))
         @forelse($stabilityDesignTitle as $title)
         <th>
             {{ $title }}
         </th>
        @empty
        @endforelse
        @else
         @forelse($duration as $month)
                <th>
                    {{ study_month($month) }}
                </th>
            @empty
            @endforelse
        @endif


        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        @php
            $sum = 0;
            $PlaceboSum = 0;
            $months = [];
        @endphp
        @forelse ($protocol->protocolSkuUnitPack as $record)
            <tr>
                <td align="center">
                    {{ @App\Models\ProductDetail::where('SkuID', $record->SkuID)->first()['ProductStrength'] }}</td>
                <td align="center">{{ @App\Models\Pack::where('PackID', $record->PackID)->first()['PackValue'] }}’s</td>

                @foreach (json_decode($record->Month) as $key => $Month)
                    <td align="center">{{ $Month ?? null }}</td>
                    @php
                        $months = explode(',', $Month);
                        $sum += array_sum($months);
                    @endphp
                @endforeach
                <td align="center">{{ $record->Additional }}</td>
                <td align="center">{{ $sum + $record->Additional }}</td>
                @php
                    $sum = 0;
                @endphp
            </tr>
        @empty
        @endforelse
        @if ($PlaceboSkuUnitPack)
        <tr>
            <td align="center">Placebo*</td>
            <td align="center">N/A</td>
            @foreach ($PlaceboSkuUnitPackMonth as $key => $Month)
                <td align="center">{{ $Month ?? null }}</td>
                @php
                    $months = explode(',', $Month);
                    $PlaceboSum += array_sum($months);
                @endphp
            @endforeach
            <td align="center">{{ $PlaceboSkuUnitPack->Additional }}</td>
            <td align="center">{{ $PlaceboSum + $PlaceboSkuUnitPack->Additional }}</td>
        </tr>
    @endif

    </tbody>
</table>
