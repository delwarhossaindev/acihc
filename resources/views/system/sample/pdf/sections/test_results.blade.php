@php
    use App\Models\Test;
    use App\Models\SubTest;

    $duration = $sampleReport->study->details->pluck('StudyTypeMonth');

    $resolveName = function ($detail) {
        if ($detail->SubTestID) {
            return optional(SubTest::where('SubTestID', $detail->SubTestID)->first())->SubTestName;
        }
        return optional(Test::where('TestID', $detail->TestID)->first())->TestName;
    };

    $regularRows = collect();
    $footerRows  = collect();
    foreach ($sampleReport->sampleReportDetails as $detail) {
        $name = $resolveName($detail);
        if (! $name) continue;
        if (str_contains($name, 'Date') || str_contains($name, 'AR. No')) {
            $footerRows->push(['name' => $name, 'detail' => $detail]);
        } else {
            $regularRows->push(['name' => $name, 'detail' => $detail]);
        }
    }
@endphp

<table class="pdf-tests">
    <thead>
        <tr>
            <th rowspan="2">Tests</th>
            <th rowspan="2">Specification</th>
            <th colspan="{{ max($duration->count(), 1) }}">Stability Study Data(Months)</th>
        </tr>
        <tr>
            @foreach ($duration as $month)
                <th>{{ $month }} M</th>
            @endforeach
            @if ($duration->isEmpty())
                <th>&nbsp;</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($regularRows as $i => $row)
            @php $values = is_iterable($row['detail']->Value) ? $row['detail']->Value : []; @endphp
            <tr>
                <td>{{ ($i + 1) }}. {{ $row['name'] }}</td>
                <td>{{ $row['detail']->Specification }}</td>
                @foreach ($values as $val)
                    <td class="center">{{ $val }}</td>
                @endforeach
            </tr>
        @endforeach
        @foreach ($footerRows as $row)
            @php $values = is_iterable($row['detail']->Value) ? $row['detail']->Value : []; @endphp
            <tr>
                <td colspan="2" class="center">{{ $row['name'] }}</td>
                @foreach ($values as $val)
                    <td class="center">{{ $val ?? 'N/A' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
