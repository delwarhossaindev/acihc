<table class="pdf-tbl">
    <thead>
        <tr>
            <th>Type of stability Study</th>
            <th>Storage Conditions</th>
            <th>Duration</th>
            <th>Testing Time Points (months)</th>
            <th>No. of Time Points</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->statbilityStudy as $stab)
            @php
                $months    = $stab->study->details->pluck('StudyTypeMonth');
                $condition = \App\Models\Condition::where('ConditionID', $stab->ConditionID)->first();
                $duration  = $months->count() ? $months->last() : '';
            @endphp
            <tr>
                <td>{{ $stab->study->StudyTypeName ?? '' }}</td>
                <td>{{ $condition->ConditionName ?? '' }}</td>
                <td>{{ $duration ? $duration . ' months' : '' }}</td>
                <td>{{ $months->implode(',') }}</td>
                <td>{{ $months->count() }}</td>
            </tr>
        @empty
            <tr><td colspan="5">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
