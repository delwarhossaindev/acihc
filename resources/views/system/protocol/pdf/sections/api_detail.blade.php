<table class="pdf-tbl">
    <thead>
        <tr>
            <th>API</th>
            <th>Source of API</th>
            <th>Batch/Lot No.</th>
            <th>Exp. Date/ Retest Date of API</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($protocol->apis as $api)
            <tr>
                <td>{{ $api->api->ApiDetailName ?? '' }}</td>
                <td>{{ $api->api->APIDetailSource ?? '' }}</td>
                <td>{{ $api->BatchNo ?? 'N/A' }}</td>
                <td>{{ $api->ExpDate ? \Carbon\Carbon::parse($api->ExpDate)->toFormattedDateString() : 'N/A' }}</td>
            </tr>
        @empty
            <tr><td colspan="4">&nbsp;</td></tr>
        @endforelse
    </tbody>
</table>
