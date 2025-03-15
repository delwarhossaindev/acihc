<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white" style="margin-top:2px;">
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
        @forelse ($protocol->statbilityStudy as $statbility)
            @php $duration = $statbility->study->details->pluck('StudyTypeMonth'); @endphp
            <tr>
                <td align="center">{{ $statbility->study->StudyTypeName }}</td>
                <td align="center">{{ \App\Models\Condition::where('ConditionID',$statbility->ConditionID)->first()['ConditionName'] }}</td>
                <td align="center">{{ $duration[count($duration)-1] }} months</td>
                <td align="center">{{ implode(',',$statbility->study->details->pluck('StudyTypeMonth')->toArray()) }}</td>
                <td align="center">{{ $statbility->study->details->pluck('StudyTypeMonth')->count() }}</td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>