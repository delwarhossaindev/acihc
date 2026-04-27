@php
    $duration = collect();
    foreach ($protocol->statbilityStudy as $stab) {
        $duration = $stab->study->details->pluck('StudyTypeMonth');
    }

    $placeboPack       = \DB::table('PlaceboSkuUnitPack')->where('ProtocolID', $protocol->ProtocolID)->first();
    $placeboMonths     = $placeboPack && $placeboPack->Month ? json_decode($placeboPack->Month) : [];
@endphp

<table class="pdf-tbl">
    <thead>
        <tr>
            <th rowspan="2">Strength (mg)</th>
            <th rowspan="2">Count</th>
            @foreach ($duration as $month)
                <th>{{ $month }} M</th>
            @endforeach
            <th rowspan="2">Additional<br>Sample<br>({{ $getData->AdditionalSample ?? '' }})</th>
            <th rowspan="2">Total Amount</th>
        </tr>
        <tr>
            @if (isset($stabilityDesignTitle))
                @foreach ($stabilityDesignTitle as $title)
                    <th>{{ $title }}</th>
                @endforeach
            @else
                @foreach ($duration as $month)
                    <th>{{ function_exists('study_month') ? study_month($month) : $month }}</th>
                @endforeach
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($protocol->protocolSkuUnitPack as $record)
            @php
                $strength = optional(\App\Models\ProductDetail::where('SkuID', $record->SkuID)->first())->ProductStrength;
                $packVal  = optional(\App\Models\Pack::where('PackID', $record->PackID)->first())->PackValue;
                $sum      = 0;
                $months   = json_decode($record->Month) ?? [];
            @endphp
            <tr>
                <td>{{ $strength }}</td>
                <td>{{ $packVal }}’s</td>
                @foreach ($months as $month)
                    <td>{{ $month }}</td>
                    @php
                        $monthVals = array_map('floatval', explode(',', (string) $month));
                        $sum += array_sum($monthVals);
                    @endphp
                @endforeach
                <td>{{ $record->Additional }}</td>
                @php
                    $extraVals = array_map('floatval', explode(',', str_replace(' ', '', (string) $record->Additional)));
                    $extra     = array_sum($extraVals);
                @endphp
                <td>{{ $sum + $extra }}</td>
            </tr>
        @endforeach

        @if ($placeboPack)
            @php $placeboSum = 0; @endphp
            <tr>
                <td>Placebo*</td>
                <td>N/A</td>
                @foreach ($placeboMonths as $month)
                    <td>{{ $month }}</td>
                    @php
                        $vals = array_map('floatval', explode(',', (string) $month));
                        $placeboSum += array_sum($vals);
                    @endphp
                @endforeach
                <td>{{ $placeboPack->Additional }}</td>
                @php
                    $extraVals = array_map('floatval', explode(',', str_replace(' ', '', (string) $placeboPack->Additional)));
                    $placeboExtra = array_sum($extraVals);
                @endphp
                <td>{{ $placeboSum + $placeboExtra }}</td>
            </tr>
        @endif
    </tbody>
</table>
