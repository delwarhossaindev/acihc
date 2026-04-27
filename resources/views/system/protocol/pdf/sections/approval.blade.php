<table class="pdf-tbl pdf-approval">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Designation</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Prepared By:</th>
            <td>{{ $preparedByUser->name ?? '' }}</td>
            <td>{{ $preparedByUser->designation ?? '' }}</td>
            <td>{{ $protocol->CreatedDate ? \Carbon\Carbon::parse($protocol->CreatedDate)->format('Y-m-d') : '' }}</td>
        </tr>
        <tr>
            <th rowspan="2">Reviewed By:</th>
            <td>{{ $reviewByOneComment && $reviewByOneUser ? $reviewByOneUser->name : '' }}</td>
            <td>{{ $reviewByOneComment && $reviewByOneUser ? $reviewByOneUser->designation : '' }}</td>
            <td>{{ $reviewByOneComment ? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->format('Y-m-d') : '' }}</td>
        </tr>
        <tr>
            <td>{{ $reviewByTwoComment && $reviewByTwoUser ? $reviewByTwoUser->name : '' }}</td>
            <td>{{ $reviewByTwoComment && $reviewByTwoUser ? $reviewByTwoUser->designation : '' }}</td>
            <td>{{ $reviewByTwoComment ? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->format('Y-m-d') : '' }}</td>
        </tr>
        <tr>
            <th>Approved By:</th>
            <td>{{ $approvalByComment && $approvalByUser ? $approvalByUser->name : '' }}</td>
            <td>{{ $approvalByComment && $approvalByUser ? $approvalByUser->designation : '' }}</td>
            <td>{{ $approvalByComment ? \Carbon\Carbon::parse($approvalByComment->CreateDate)->format('Y-m-d') : '' }}</td>
        </tr>
    </tbody>
</table>
