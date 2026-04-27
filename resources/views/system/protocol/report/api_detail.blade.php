<table border="1" width="1000px" cellspacing="1" cellpadding="3" class="white">
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
            <td align="center" >{{ $api->api->ApiDetailName }}</td>
            <td align="center" >{{ $api->api->APIDetailSource }}</td>
            <td align="center" >{{ $api->BatchNo ?? 'N/A' }}</td>
            <td align="center" >{{ \Carbon\Carbon::parse($api->ExpDate)->toFormattedDateString() ?? 'N/A'}}</td>
        </tr>

        {{-- @if($loop->last)
        <tr>
            <td align="center">{{ $api->api->BatchNo ?? 'N/A' }}</td>
        </tr>
        @endif --}}
        @empty
        @endforelse
    </tbody>
</table>