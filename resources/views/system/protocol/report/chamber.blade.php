<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white" style="margin-top:2px;">
    <thead>
        @php
            $duration = [];
            $PlaceboSkuUnitPack = \DB::table('PlaceboSkuUnitPack')->where('ProtocolID', $protocol->ProtocolID)->first();
            $PlaceboSkuUnitPackMonth = $PlaceboSkuUnitPack ? json_decode($PlaceboSkuUnitPack->Month) : [];

            // dd($protocol->statbilityStudy);

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
            <th rowspan="2">Additional<br>Sample<br>({{ $getData->AdditionalSample ?? null }})</th>
            <th rowspan="2">Total Amount</th>
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
            // dd($protocol->protocolSkuUnitPack);
        @endphp
        @forelse ($protocol->protocolSkuUnitPack as $record)

            @php
                $sum = 0;
            @endphp

            <tr>
                <td align="center">
                    {{ @App\Models\ProductDetail::where('SkuID', $record->SkuID)->first()['ProductStrength'] }}</td>
                <td align="center">{{ @App\Models\Pack::where('PackID', $record->PackID)->first()['PackValue'] }}’s</td>

                @foreach (json_decode($record->Month) ?? [] as $key => $Month)
                    <td align="center">{{ $Month ?? null }}</td>
                    @php
                        $months = array_map('floatval', explode(',', (string) $Month));
                        $sum += array_sum($months);
                    @endphp
                @endforeach
                <td align="center">{{ $record->Additional }}</td>
                @php
                    $numberAdditional = array_map('floatval', explode(',', str_replace(' ', '', (string) $record->Additional)));
                    $sumAdditional = array_sum($numberAdditional);
                @endphp

                <td align="center">{{ $sum + $sumAdditional }}</td>


            </tr>
        @empty
        @endforelse
        @if ($PlaceboSkuUnitPack)
            <tr>
                <td align="center">Placebo*</td>
                <td align="center">N/A</td>
                @foreach ($PlaceboSkuUnitPackMonth ?? [] as $key => $Month)
                    <td align="center">{{ $Month ?? null }}</td>
                    @php
                        $months = array_map('floatval', explode(',', (string) $Month));
                        $PlaceboSum += array_sum($months);
                    @endphp
                @endforeach
                <td align="center">{{ $PlaceboSkuUnitPack->Additional }}</td>
                @php
                    $numberPlaceboAdditional = array_map('floatval', explode(',', str_replace(' ', '', (string) $PlaceboSkuUnitPack->Additional)));
                    $sumPlaceboAdditional = array_sum($numberPlaceboAdditional);
                @endphp

                <td align="center">{{ $PlaceboSum + $sumPlaceboAdditional }}</td>

            </tr>
        @endif

    </tbody>
</table>
