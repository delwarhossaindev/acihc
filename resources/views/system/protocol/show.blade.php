@php
    $approvalSteps = $protocol->approvalSteps()->with('assignedUser:id,name,designation')->get();
    $reviewerSteps = $approvalSteps->where('Role', \App\Models\ProtocolApproval::ROLE_REVIEWER)->values();
    $approverStep  = $approvalSteps->firstWhere('Role', \App\Models\ProtocolApproval::ROLE_APPROVER);

    $stepToCommentObj = function ($step) {
        if (! $step || $step->Decision === \App\Models\ProtocolApproval::DECISION_PENDING) {
            return null;
        }
        return (object) [
            'Comment'    => $step->Comment,
            'CreateDate' => $step->DecidedAt,
        ];
    };

    $reviewByOneStep   = $reviewerSteps->get(0);
    $reviewByTwoStep   = $reviewerSteps->get(1);

    $reviewByOneUser    = $reviewByOneStep?->assignedUser;
    $reviewByOneComment = $stepToCommentObj($reviewByOneStep);
    $reviewByOneUserID  = $reviewByOneStep?->AssignedUserID;

    $reviewByTwoUser    = $reviewByTwoStep?->assignedUser;
    $reviewByTwoComment = $stepToCommentObj($reviewByTwoStep);
    $reviewByTwoUserID  = $reviewByTwoStep?->AssignedUserID;

    $approvalByUser    = $approverStep?->assignedUser;
    $approvalByComment = $stepToCommentObj($approverStep);
    $approvalByUserID  = $approverStep?->AssignedUserID;

    $preparedByUser = $protocol->CreatedBy ? \App\Models\User::find($protocol->CreatedBy) : null;

    // Get the version count for the protocol
    $versionCount = \DB::table('ProtocolVersion')
        ->where('protocol_id', $protocol->ProtocolID)
        ->lockForUpdate()
        ->max('version_no');

    $versionCount = number_format((float) $versionCount, 2, '.', '') ?? number_format((float) 1.0, 2, '.', '');

    // Get the protocol status

    $ProtocolStatus = DB::table('ProtocolStatus')->where('ProtocolStatusID', $protocol->ProtocolStatusID)->first();

    // dd($ProtocolStatus->ProtocolStatus);

@endphp



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <title></title>
    <meta charset="utf-8">
    <style type="text/css">
        @page {
            size: A4;
            margin: 60px;



        }

        body {
            font-family: 'myEnglishFont', Arial, sans-serif;
            font-size: 16px;
            color: black;
            counter-reset: page;
            /* Initialize page counter */
            counter-increment: page;
        }

        table.white {
            background-color: #ffffff;
            color: #000000;
           font-size: 14px;
            border-collapse: collapse;
            font-family: 'myEnglishFont', Arial, sans-serif;
        }

        .responsibility>ul>li {
            font-weight: normal !important;
        }

        TH.white {
            background-color: #FFFFFF;
            color: #000000;
           font-size: 14px;
            font-weight: 600;
            border: #000000 1px solid;
            padding: 1px;
        }

        TD.white {
            background-color: #FFFFFF;
            color: #000000;
           font-size: 14px;
            font-weight: 500;
            border: #000000 1px solid;
            padding-left: 1px;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        p {
           font-size: 14px;
            font-weight: normal;
            text-align: start;

        }

        li {
           font-size: 14px;
        }

        .front-page {
            page-break-after: always;
            height: 80vh;
        }

        .center-flex {
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .print-button {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background-color: #74992e;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
                margin-top: 220px;
                margin-right: 30px;
                margin-left: 30px;
            }
        }

        /* Add dynamic page number */
        /* tfoot td::after {
            content: "Page " counter(page) " of 8";
            font-size: 12px;
            display: block;
            margin-top: 5px;
        } */
    </style>
</head>


<body>
    <!--Page Starts-->
    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <div class="no-print" style="position: absolute; top: 20px; right: 20px; z-index: 9999; display: flex; gap: 8px;">
                    <button onclick="window.print()"
                        style="background-color: #74992e; color: white; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; font-size: 14px;">
                        🖨 Print
                    </button>
                    <a href="{{ route('protocol.pdf', $protocol->ProtocolID) }}" target="_blank" rel="noopener"
                        style="background-color: #c0392b; color: white; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; font-size: 14px; text-decoration: none; display: inline-block;">
                        📄 Open PDF
                    </a>
                    <a href="{{ route('protocol.pdf', $protocol->ProtocolID) }}?download=1"
                        style="background-color: #2c3e50; color: white; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; font-size: 14px; text-decoration: none; display: inline-block;">
                        ⬇ Download PDF
                    </a>
                </div>
                <center>
                    <!-- front page start-->
                    {{-- <div class="front-page " style="page-break-before: always; text-align: center; ">
                        <div>
                            <div
                                style="margin-top: 200px; font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #000; ">
                                <h2 style="text-align: center; margin-bottom: 10px; margin-top: 60px;">Subject:
                                    <span style="font-weight: normal;">{{ $protocol->Title }}</span>
                                </h2>

                                <p style="text-align: center; margin: 0;">
                                    <strong>Number : </strong>STB/PROT/{{ sprintf('%04d', $protocol->ProtocolID) }}
                                </p>
                                <p style="text-align: center; margin-top: 0;">
                                    <strong>Version : </strong>{{ $versionCount }}
                                </p>

                                <br><br>

                                <div style="margin-right: 100px; margin-left: 100px; ">

                                    <p><strong>Prepared by : </strong> <span
                                            style="color: ;">{{ $preparedByUser ? $preparedByUser->name : '' }}</span>
                                    </p>
                                    <p><strong>Prepared Date : </strong>
                                        {{ $protocol->CreatedDate ? \Carbon\Carbon::parse($protocol->CreatedDate)->timezone('Asia/Dhaka')->format('M d, Y') : '' }}
                                    </p>

                                    <p><strong>Reviewed by : </strong> <span
                                            style="color: ;">{{ $reviewByOneComment ? $reviewByOneUser->name : '' }}</span>
                                    </p>
                                    <p><strong>Reviewed Date : </strong>
                                        {{ $reviewByOneComment ? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->timezone('Asia/Dhaka')->format('M d, Y') : '' }}
                                    </p>

                                    <p><strong>Reviewed by : </strong>
                                        {{ $reviewByTwoComment ? $reviewByTwoUser->name : '' }}</p>
                                    <p><strong>Reviewed Date :
                                        </strong>{{ $reviewByTwoComment ? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->timezone('Asia/Dhaka')->format('M d, Y') : '' }}
                                    </p>

                                    <p><strong>Approved by :
                                        </strong>{{ $approvalByComment ? $approvalByUser->name : '' }}</p>
                                    <p><strong>Approved Date :
                                        </strong>{{ $approvalByComment ? \Carbon\Carbon::parse($approvalByComment->CreateDate)->timezone('Asia/Dhaka')->format('M d, Y') : '' }}
                                    </p>
                                </div>
                                <div
                                    style="position: absolute; left: -40px; top: 600px; transform: rotate(-90deg); font-size: 15px; font-weight: bold;">
                                    {{ $ProtocolStatus->ProtocolStatus ?? '' }} Copy
                                </div>
                            </div>


                        </div>
                        <div>

                        </div>
                    </div> --}}
                    <!-- front page end-->
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>

                            <tr>

                                <th>
                                    <div style="text-align: center;">
                                        @include('system.protocol.report.hero')
                                    </div>
                                </th>

                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <th>

                                    <div class="" style="page-break-before: always; text-align: center;">
                                        <div
                                            style="float:left; width:99%; border:0px solid #000;  page-break-before: always;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">1. Purpose:
                                                </p>
                                                <p style="text-align:left;font-size: 14px; font-weight:400">
                                                    {{ $protocol->Purpose }}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">2. Scope:
                                                    (Mark &check; Where Applicable)
                                                </p>
                                                <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                                                    class="white text-center align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="font-size:16px;">Exhibit
                                                                Batch</th>
                                                            <th class="text-center" style="font-size:16px;">Commercial
                                                                Validation<br>Batch</th>
                                                            <th class="text-center" style="font-size:16px;">Annual
                                                                Stability</th>
                                                            <th class="text-center" style="font-size:16px;">If others,
                                                                Specify</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="text-center align-middle">
                                                            <td height="35" class="text-center align-middle fs-4">
                                                                <span
                                                                    style="text-align: center; display: block;">{!! $protocol->ExhibitBatch == 'Y' ? '&check;' : 'Not applicable' !!}</span>
                                                            </td>
                                                            <td class="text-center align-middle fs-4">
                                                                <span style="text-align: center; display: block;">
                                                                    {!! $protocol->CommercialValidationBatch == 'Y' ? '&check;' : 'Not applicable' !!}</span>
                                                            </td>
                                                            <td class="text-center align-middle fs-4">
                                                                <span
                                                                    style="text-align: center; display: block;">{!! $protocol->AnnualStability == 'Y' ? '&check;' : 'Not applicable' !!}</span>
                                                            </td>
                                                            <td class="text-center align-middle fs-4">
                                                                @if ($protocol->Other == 'Y')
                                                                    <span
                                                                        style="text-align: center; display: block;">&check;</span>
                                                                @elseif ($protocol->Other == 'N')
                                                                    <span
                                                                        style="text-align: center; display: block;">Not
                                                                        applicable</span>
                                                                @else
                                                                    <span
                                                                        style="text-align: center; display: block;">{!! $protocol->Other !!}</span>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- <div style="position: absolute; left: -60px; top: 2000px; transform: rotate(-90deg); font-size: 15px; font-weight: bold; z-index: 7;">
                                            Approved Copy
                                        </div> -->
                                        <div style="float:left; width:99%; border:0px solid #000;">

                                            <div style="float:left; border-right:0px solid #000; text-align:left;"
                                                class="responsibility">
                                                <p style="text-align:left; font-size: 16px; font-weight:600;">
                                                    3. Responsibilities:
                                                </p>
                                                <p style="text-align:left;font-size: 14px; font-weight: normal;">
                                                    {!! $protocol->Responsibilities !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <p style="text-align:left; font-size: 16px; font-weight:600">4. Reference:
                                            </p>
                                            <p style="text-align:left;font-size: 14px; font-weight:400">
                                                {{ $protocol->Reference ?? '' }}
                                            </p>

                                        </div>

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">5. Market:
                                                </p>
                                                <p style="text-align:left;font-size: 14px; font-weight:400">

                                                    The product is intended for
                                                    {{ isset($protocol->market->MarketName) ? $protocol->market->MarketName : '' }}.

                                                </p>
                                            </div>
                                        </div>

                                        {{-- <div style="text-align:center;">
                                            <p style=" font-size: 12px; margin-bottom: 0px;">000000650/3.01/9.1 </p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">This is a confidential property of ACI HealthCare Limited.</p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">page 1 of 8</p>

                                        </div> --}}


                                    </div>


                                    <div style="page-break-before: always; text-align: center;">
                                        <span style=" page-break-before: always;"></span>
                                        @include('system.protocol.report.manufacturer')

                                        <p style="text-align:left; font-size: 16px; font-weight:600">7. Specification and
                                            STP Reference:</p>

                                        @include('system.protocol.report.stp')


                                        <p style="text-align: start;"> <b>Note :</b> Current approved version to be
                                            followed at the time of execution.</p>


                                        <p style="text-align:left; font-size: 16px; font-weight:600">8. API Details:</p>

                                        @include('system.protocol.report.api_detail')

                                        <p style="text-align:left; font-size: 16px; font-weight:600">9. Primary Packaging
                                            Materials Details:</p>

                                        @include('system.protocol.report.packaging_materials')


                                        {{-- <div style="text-align:center;">
                                            <p style=" font-size: 12px; margin-bottom: 0px;">000000650/3.01/9.1 </p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">This is a confidential property of ACI HealthCare Limited.</p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">page 2 of 8</p>

                                        </div> --}}

                                    </div>

                                    <div style="page-break-before: always; text-align: center;">
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">
                                                    10. Packaging Profile:</p>
                                            </div>
                                        </div>
                                        @include('system.protocol.report.profile')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">a.
                                                    Packaging component details:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.component')

                                        {{-- <div style="text-align:center;">
                                            <p style=" font-size: 12px; margin-bottom: 0px;">000000650/3.01/9.1 </p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">This is a confidential property of ACI HealthCare Limited.</p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">page 3 of 8</p>

                                        </div> --}}
                                    </div>

                                    <div style="page-break-before: always; text-align: center;">
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">11. Batch
                                                    Details for Stability Study:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.batch')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">12.
                                                    Stability Study:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.stability_study')
                                        <br>

                                        {{-- <img src="{{ asset('table.png') }}" alt="Table Image" style="width:99%; height: 600px;"> --}}


                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">13.
                                                    Quantity
                                                    of Samples Required for test in QC:</p>
                                            </div>
                                        </div>


                                        @include('system.protocol.report.test')

                                         {{-- <p style="text-align: start;"> <b>Note :</b> {{ $protocol->TestNote }}</p> --}}


                                        {{-- <div style="text-align:center;">
                                            <p style=" font-size: 12px; margin-bottom: 0px;">000000650/3.01/9.1 </p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">This is a confidential property of ACI HealthCare Limited.</p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">page 4 of 8</p>

                                        </div> --}}

                                    </div>


                                    <div style="float:left; width:99%; border:0px solid #000;">
                                        <div style="float:left; width:99%; border-right:0px solid #000;">
                                            <p style="text-align:left; font-size: 16px; font-weight:600">14.
                                                Stability Design and Number of Container/ Blister/Samples to be
                                                Incubated in Stability Chamber:</p>
                                        </div>
                                    </div>


                                    @include('system.protocol.report.chamber')

                                    <div style="float:left; width:99%; border:0px solid #000;">
                                        <div style="float:left; width:99%; border-right:0px solid #000;">
                                            <p style="text-align:left; font-size: 16px; font-weight:600">Note:</p>
                                            <p style="text-align:left;font-size: 14px; font-weight:400">
                                            <ol
                                                style="text-align:left;font-size: 14px; font-weight:400; list-style-type: lower-roman;">
                                                <!-- <li>Additional Study Sample will be pulled out and tested only if
                                                        needed.</li>
                                                    <li>*The Placebo should be subjected to stability studies for the
                                                        “Organic impurities test”.</li>
                                                    <li>Intermediate (IN) conditions will be withdrawn only if any
                                                        significant change or OOS found during Accelerated (AC) Study.
                                                    </li> -->
                                                {!! $protocol->Note !!}
                                            </ol>
                                            </p>
                                        </div>
                                    </div>
                                    <div style="page-break-before: always; text-align: center;">
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size: 16px; font-weight:600">15.
                                                    Stability specification and analysis report, Sampling plan and
                                                    reconciliation:</p>
                                                <p style="text-align:left;font-size: 14px; font-weight:400">
                                                    {{ $protocol->AnalysisReport }}
                                                </p>
                                            </div>
                                        </div>

                                        <img src="{{ asset('table.png') }}" alt="Table Image"
                                            style="width:99%; height: 500px;">

                                        <br>
                                        <br>
                                        <br>


                                        <img src="{{ asset('table.png') }}" alt="Table Image"
                                            style="width:99%; height: 500px;">

                                        <br>
                                        <br>
                                        <br>

                                        <img src="{{ asset('table.png') }}" alt="Table Image"
                                            style="width:99%; height: 500px;">

                                        <br>
                                        <br>
                                        <br>

                                        <img src="{{ asset('table.png') }}" alt="Table Image"
                                            style="width:99%; height: 500px;">

                                        @include('system.protocol.report.footer')


                                        {{-- <div style="text-align:center;">
                                            <p style=" font-size: 12px; margin-bottom: 0px;">000000650/3.01/9.1 </p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">This is a confidential property of ACI HealthCare Limited.</p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">page 4 of 8</p>

                                        </div> --}}
                                    </div>

                                </th>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: center;">
                                    <p style=" font-size: 12px; margin-bottom: 0px; text-align: center;">
                                        {{ $protocol->FooterSectionNo }}</p>
                                    <p
                                        style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px; text-align: center;">
                                        This is a confidential property of ACI HealthCare Limited.</p>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>
    <!--Page END-->
</body>

</html>
