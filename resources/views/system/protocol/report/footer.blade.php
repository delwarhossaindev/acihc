@php
$reviewByOne = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
    ->where('ProtocolApprovalTypeID', 1)
    ->first();
$reviewByOneUserID = $reviewByOne->UserID ?? null;
$reviewByOneUser = $reviewByOne ? \App\Models\User::find($reviewByOne->UserID) : null;
$reviewByOneComment = $reviewByOne ? \App\Models\ProtocolReviewer::where('ProtocolID', $protocol->ProtocolID)
    ->where('UserID', $reviewByOne->UserID)
    ->first() : null;

$reviewByTwo = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
    ->where('ProtocolApprovalTypeID', 1)
    ->latest('CreateDate')
    ->first();

$reviewByTwoUserID = $reviewByTwo->UserID ?? null;
$reviewByTwoUser = $reviewByTwo ? \App\Models\User::find($reviewByTwo->UserID) : null;
$reviewByTwoComment = $reviewByTwo ? \App\Models\ProtocolReviewer::where('ProtocolID', $protocol->ProtocolID)
    ->where('UserID', $reviewByTwo->UserID)
    ->first() : null;

$approvalBy = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
    ->where('ProtocolApprovalTypeID', 2)
    ->first();

$approvalByUserID = $approvalBy->UserID ?? null;
$approvalByUser = $approvalBy ? \App\Models\User::find($approvalBy->UserID) : null;
$approvalByComment = $approvalBy ? \App\Models\ProtocolApprover::where('ProtocolID', $protocol->ProtocolID)
    ->where('UserID', $approvalBy->UserID)
    //->where('ProtocolStatusID', 4)
    ->first() : null;

$preparedByUser = $protocol->CreatedBy ? \App\Models\User::find($protocol->CreatedBy) : null;

@endphp

<table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
    <thead>
        <tr>
            <th>
                <center>
                    {{-- <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size:20px; font-weight:600">16.Sampling Plan:</p>
                        </div>
                    </div>
                    @include('system.protocol.report.image') --}}

                    <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size:20px; font-weight:600">15.
                                Stability Specifications And Analysis Report:</p>
                            <p style="text-align:left; font-size:18px; font-weight:400">
                                {{ $protocol->AnalysisReport }}
                            </p>
                        </div>
                    </div>

                    <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size:20px; font-weight:600">16.
                                Reporting:</p>
                            <p style="text-align:left; font-size:18px; font-weight:400">
                                {{ $protocol->Reporting }}
                            </p>
                        </div>
                    </div>

                    <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size:20px; font-weight:600">17.
                                Conclusion:</p>
                            <p style="text-align:left; font-size:18px; font-weight:400">
                                {{ $protocol->Conclusion }}
                            </p>
                        </div>
                    </div>

                    <div style="float:left; width:99%; border:0px solid #000; margin-bottom:500px;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size:20px; font-weight:600">18. Revision
                                History:</p>
                            <p style="text-align:left; font-size:18px; font-weight:400">
                                {{ $protocol->RevisionHistory }}
                            </p>

                        <p style="text-align:left; font-size:20px; font-weight:600">19. Approval</p>
                        <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                            class="white">
                            <thead>
                                <tr>
                                    <th class="text-center" style="font-size:18px;"></th>
                                    <th class="text-center" style="font-size:18px;">Name</th>
                                    <th class="text-center" style="font-size:18px;">Designation</th>
                                    <th class="text-center" style="font-size:18px;">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center" height="35">Prepared By:</th>
                                    <td class="text-center">{{  $preparedByUser ? $preparedByUser->name : ''  }}</td>
                                    <td class="text-center">{{  $preparedByUser ? $preparedByUser->designation : ''  }}</td>
                                    <td class="text-center">{{  $protocol->CreatedDate ? \Carbon\Carbon::parse($protocol->CreatedDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : ''  }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" height="35" rowspan="2">Reviewed By:</th>
                                    <td class="text-center">{{  $reviewByOneComment ? $reviewByOneUser->name : ''  }}</td>
                                    <td class="text-center">{{  $reviewByOneComment ? $reviewByOneUser->designation : ''  }}</td>
                                    <td class="text-center">{{ $reviewByOneComment ? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">{{  $reviewByTwoComment ? $reviewByTwoUser->name : ''  }}</td>
                                    <td class="text-center">{{  $reviewByTwoComment ? $reviewByTwoUser->designation : ''  }}</td>
                                    <td class="text-center">{{ $reviewByTwoComment ? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" height="35">Approved By:</th>
                                    <td class="text-center">{{  $approvalByComment ? $approvalByUser->name : ''  }}</td>
                                    <td class="text-center">{{  $approvalByComment ? $approvalByUser->designation : ''  }}</td>
                                    <td class="text-center">{{ $approvalByComment ? \Carbon\Carbon::parse($approvalByComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A') : '' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- <p style="text-align:left; font-size:20px; font-weight:600">20. About</p> -->

                        </div>
                    </div>



                </center>
            </th>
        </tr>
    </thead>


</table>
