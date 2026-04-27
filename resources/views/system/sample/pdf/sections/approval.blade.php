<table class="pdf-approval">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Designation</th>
            <th>Date &amp; Time</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Prepared By:</th>
            <td>{{ $preparedByUser->name ?? '' }}</td>
            <td>{{ $preparedByUser->designation ?? '' }}</td>
            <td>{{ $sampleReport->CreatedAt ? \Carbon\Carbon::parse($sampleReport->CreatedAt)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : '' }}</td>
        </tr>
        <tr>
            <th rowspan="2">Reviewed By:</th>
            <td>{{ $reviewByOneComment && $reviewByOneUser ? $reviewByOneUser->name : '' }}</td>
            <td>{{ $reviewByOneComment && $reviewByOneUser ? $reviewByOneUser->designation : '' }}</td>
            <td>{{ $reviewByOneComment ? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : '' }}</td>
        </tr>
        <tr>
            <td>{{ $reviewByTwoComment && $reviewByTwoUser ? $reviewByTwoUser->name : '' }}</td>
            <td>{{ $reviewByTwoComment && $reviewByTwoUser ? $reviewByTwoUser->designation : '' }}</td>
            <td>{{ $reviewByTwoComment ? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : '' }}</td>
        </tr>
        <tr>
            <th>Approved By:</th>
            <td>{{ $approvalByComment && $approvalByUser ? $approvalByUser->name : '' }}</td>
            <td>{{ $approvalByComment && $approvalByUser ? $approvalByUser->designation : '' }}</td>
            <td>{{ $approvalByComment ? \Carbon\Carbon::parse($approvalByComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : '' }}</td>
        </tr>
    </tbody>
</table>
