@php
    use Carbon\Carbon;
    use App\Models\ProtocolProductDetail;
    use App\Models\ApiDetail;
    use App\Models\Test;
    use App\Models\SubTest;

    $versionCount = \DB::table('ProtocolVersion')
        ->where('protocol_id', $sampleReport->sample->protocol->ProtocolID)
        ->lockForUpdate()
        ->max('version_no');

     $versionCount =     number_format((float)$versionCount, 2, '.', '') ?? number_format((float)1.00, 2, '.', '') ; 

    //Sample Report

    $reviewByOne = \App\Models\SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
        ->where('SampleApprovalTypeID', 1)
        ->first();
    $reviewByOneUserID = $reviewByOne->UserID ?? null;
    $reviewByOneUser = $reviewByOne ? \App\Models\User::find($reviewByOne->UserID) : null;
    $reviewByOneComment = $reviewByOne
        ? \App\Models\SampleReviewer::where('SampleReportID', $sampleReport->SampleReportID)
            ->where('UserID', $reviewByOne->UserID)
            ->first()
        : null;

    $reviewByTwo = \App\Models\SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
        ->where('SampleApprovalTypeID', 1)
        ->latest('CreateDate')
        ->first();

    $reviewByTwoUserID = $reviewByTwo->UserID ?? null;
    $reviewByTwoUser = $reviewByTwo ? \App\Models\User::find($reviewByTwo->UserID) : null;
    $reviewByTwoComment = $reviewByTwo
        ? \App\Models\SampleReviewer::where('SampleReportID', $sampleReport->SampleReportID)
            ->where('UserID', $reviewByTwo->UserID)
            ->first()
        : null;

    $approvalBy = \App\Models\SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
        ->where('SampleApprovalTypeID', 2)
        ->first();

    $approvalByUserID = $approvalBy->UserID ?? null;
    $approvalByUser = $approvalBy ? \App\Models\User::find($approvalBy->UserID) : null;
    $approvalByComment = $approvalBy
        ? \App\Models\SampleApprover::where('SampleReportID', $sampleReport->SampleReportID)
            ->where('UserID', $approvalBy->UserID)
            //->where('ProtocolStatusID', 4)
            ->first()
        : null;

    $preparedByUser = $sampleReport->UserID ? \App\Models\User::find($sampleReport->UserID) : null;
    $duration = $sampleReport->study->details->pluck('StudyTypeMonth');

  $containerIDs = @App\Models\ProtocolSkuPack::where('ProtocolID',$sampleReport->sample->protocol->ProtocolID)->pluck('ContainerID')->toArray();
  $containers = @App\Models\Container::whereIn('ContainerID',array_unique($containerIDs))
                    ->with('packaging')
                    ->get();
  $containersCount = 0;
  foreach ($containers as $container){ 
  foreach ($container->packaging as $packagingProfile){ 
    $containersCount++;
    }}
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>Sample Report</title>
    <meta charset="utf-8">
    <style type="text/css">
        @page {
            size: A4 portrait; /* Explicitly set orientation */
    margin: 20mm 15mm 15mm 15mm;
        }

        @font-face {
            font-family: 'myEnglishFont';
            src: url('path-to-your-font-file.woff2') format('woff2');
            font-weight: 600;
            font-style: normal;
        }

        table.white {
            background-color: #ffffff;
            color: #000000;
            font-size: 11px;
            border-collapse: collapse;
            font-family: 'myEnglishFont', Arial, sans-serif;
        }

        th.white,
        td.white {
            background-color: #ffffff;
            color: #000000;
            font-size: 10px;
            font-weight: 500;
            border: 1px solid #000000;
            padding: 1px;
        }

        td {
            font-weight: normal;
        }

        body {
            position: relative;
            margin: 0;
            padding: 0;
        }

        .print-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            font-weight: 500;
            background-color: white;
            padding: 5px 0;
            z-index: 9999; /* Ensure footer is on top */
        }
        @media print {
            .page-break { 
                page-break-before: always;
                margin-top:220px
            }
           
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <tbody>
                            <tr>
                                <th>
                                    <center style="position: fixed; top:0; z-index:9999;background:#fff">
                                        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
                                            <tr>
                                                <td rowspan="2"
                                                    style="width: 86px; border-right: 1px solid #000; height: 111px; text-align: center;">
                                                    <img src="{{ asset('logo.png') }}" width="60" height="60" />
                                                </td>

                                                <th
                                                    style="width: 46%; border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center; font-size: 15px; padding: 15px;">
                                                    ACI HealthCare Limited
                                                </th>
                                                <th
                                                    style="width: 45%; border-bottom: 1px solid #000; text-align: center; font-size: 15px; padding: 15px;">
                                                    Page 1 of 3 <br>
                                                    <p>Report No:
                                                        STB/REPORT/{{ sprintf('%04d', $sampleReport->SampleReportID) }}
                                                    </p>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th
                                                    style="border-right: 1px solid #000; border-left: 1px solid #000; font-size: 15px; padding: 10px; text-align: center;">
                                                    {{ $sampleReport->Headline ?? $sampleReport->sample->protocol->product->ProductName }}
                                                </th>

                                                <th style="text-align: center; font-size: 15px; padding: 15px;">
                                                    Quality Control
                                                </th>
                                            </tr>
                                        </table>
                                        <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                                            class="white" style="margin-top:3%;">
                                            <tr>
                                                <th align="left"> Product Name:</th>
                                                <td align="left" colspan="3">
                                                    {{ $sampleReport->sample->protocol->product->ProductName ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th align="left"> Batch No:</th>
                                                <td align="left">
                                                    {{ isset($sampleReport->batch) ? $sampleReport->batch->BatchNo : 'N/A' }}
                                                </td>
                                                <th align="left">Strorage Conditions:</th>
                                                <td align="left">{{ $sampleReport->condition->ConditionName }}</td>
                                            </tr>

                                        </table>
                                    </center>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <center style="margin-top: 220px">
                                        <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                                            class="white" style="margin-top:3%;">
                                            <tr>
                                                <th align="left"> Batch Size:</th>
                                                <td align="left" colspan="3">
                                                    {{ isset($sampleReport->batch) ? $sampleReport->batch->BatchSize : 'N/A' }}
                                                </td>
                                                <th align="left"> Mfg Date:</th>
                                                <td align="left" colspan="3">
                                                    {{ isset($sampleReport->batch) ? Carbon::parse($sampleReport->batch->MfgDate)->toFormattedDateString() : 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th align="left"> Protocol No:</th>
                                                <td align="left" colspan="3">
                                                    STB/PROT/{{ sprintf('%04d', $sampleReport->sample->protocol->ProtocolID) }},Rev:{{ $versionCount }}
                                                </td>
                                                <th align="left"> Expiry Date:</th>
                                                <td align="left" colspan="3">
                                                    {{ isset($sampleReport->batch) ? Carbon::parse($sampleReport->batch->ExpDate)->toFormattedDateString() : 'To Be Defined' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th align="left">Specification No:</th>
                                                <td align="left" colspan="3">
                                                    {{ $sampleReport->sample->SpecificationNo ? $sampleReport->sample->SpecificationNo : ProtocolProductDetail::where('ProtocolID', $sampleReport->sample->protocol->ProtocolID)->first()['SpecificationNo'] }}
                                                </td>
                                                <th align="left">Pakaging Date:</th>
                                                <td align="left" colspan="3">
                                                    {{ Carbon::parse($sampleReport->sample->PackagingDate)->toFormattedDateString() ?? '' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th align="left">STP No:</th>
                                                <td align="left" colspan="3">
                                                    {{ $sampleReport->sample->STPNo ? $sampleReport->sample->STPNo : ProtocolProductDetail::where('ProtocolID', $sampleReport->sample->protocol->ProtocolID)->first()['STPNo'] }}
                                                </td>
                                                <th align="left">Stability Initiation Date:</th>
                                                <td align="left" colspan="3">
                                                    {{ isset($sampleReport->batch) ? Carbon::parse($sampleReport->batch->SIDate)->toFormattedDateString() : 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th align="left">Name Of the API:</th>
                                                <td align="left" colspan="3">
                                                    @foreach ($sampleReport->sample->protocol->protocolApiDetails->pluck('APIDetailID') as $api)
                                                        {{ ApiDetail::where('ApiDetailID', $api)->first()->ApiDetailName }},
                                                    @endforeach
                                                </td>
                                                <th align="left">Reason of the Stability:</th>
                                                <td align="left" colspan="3">
                                                    {{ isset($sampleReport->batch) ? $sampleReport->batch->BatchName : 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th align="left">API Manufacturer:</th>
                                                <td align="left" colspan="5" style="width:40%">
                                                    @foreach ($sampleReport->sample->protocol->protocolApiDetails->pluck('APIDetailID') as $api)
                                                        {{ ApiDetail::where('ApiDetailID', $api)->first()->APIDetailSource }},
                                                    @endforeach
                                                </td>

                                            </tr>
                                            <tr>
                                                <th align="left">Description of Pack:</th>
                                                <td align="left" colspan="5" style="width:40%">
                                                    {{ isset($sampleReport->batch) ? $sampleReport->batch->DescriptionOfPack : 'N/A' }}
                                                </td>
                                            </tr>

                                            @forelse ($containers as $container)
                                                    @foreach ($container->packaging as $key => $packagingProfile)
                                                  
                                                        
                                                        <tr>
                                                            @if ($key==0)
                                                                
                                                            <th align="left" style="width:20%" rowspan="{{ $containersCount }}">Description of the
                                                                Primary Packaging Material</th>
                                                                
                                                            @endif
                                                            <td align="left" colspan="5">
                                                                <p><strong>{{ $packagingProfile->PackagingName }}</strong></p>
                                                                <p style="text-align:left;">Source: {{ $packagingProfile->PackagingSource ?? 'N/A' }}
                                                                </p>
                                                                <p style="text-align:left;">DMF: {{ $packagingProfile->PackagingDMF ?? 'N/A'}}</p>
                                                                <p style="text-align:left;">Resin: {{ $packagingProfile->PackagingResin ?? 'N/A' }}</p>
                                                                <p style="text-align:left;">Colorant: {{ $packagingProfile->PackagingColorant ?? 'N/A' }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @empty
                                            @endforelse

                                           
                                        </table>
                                    </center>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <center style="text-align: center;" class="page-break">
                                        @php
                                            $duration = $sampleReport->study->details->pluck('StudyTypeMonth');
                                        @endphp
                                        <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                                            class="white" style="margin-top:2px; margin-top:3%;">
                                            <thead>
                                                <tr>
                                                  
                                                    <th rowspan="2">Tests</th>
                                                    <th rowspan="2">Specification</th>
                                                    <th colspan="{{ count($duration) }}">Stability Study Data(Months)
                                                    </th>
                                                </tr>
                                                <tr>
                                                    @forelse($duration as $month)
                                                        <th>{{ $month }} M</th>
                                                    @empty
                                                    @endforelse
                                                </tr>
                                            </thead>
                                            <tbody>
                                               

                                                @forelse ($sampleReport->sampleReportDetails as $detail)


                                                    @php

                                                        if ($detail->SubTestID) {
                                                            $data = SubTest::where('SubTestID', $detail->SubTestID)->first()['SubTestName'];
                                                        } else {
                                                            $data = Test::where('TestID', $detail->TestID)->first()['TestName'];
                                                        }

                                                    @endphp

                                                    @if (str_contains($data, 'Date') || str_contains($data, 'AR No'))
                                                        @continue
                                                    @endif
                                                    <tr>
                                                        <td style="text-align:left;">{{ $loop->index + 1 . '.' }}

                                                            @if ($detail->SubTestID)
                                                                {{ SubTest::where('SubTestID', $detail->SubTestID)->first()['SubTestName'] }}
                                                            @else
                                                                {{ Test::where('TestID', $detail->TestID)->first()['TestName'] }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $detail->Specification }}</td>
                                                        @foreach ($detail->Value as $key => $item)
                                                            @if ($detail->SubTestID)
                                                                @if (SubTest::where('SubTestID', $detail->SubTestID)->first()['SubTestName'] == 'Dissolution Rate')
                                                                    <td style="text-align:center;">
                                                                        <!-- {{ 'Min-Max-Avg | ' . $item }} -->
                                                                          {{ $item }}
                                                                    </td>
                                                                @else
                                                                    <td style="text-align:center;">{{ $item }}
                                                                    </td>
                                                                @endif
                                                            @else
                                                                @if (Test::where('TestID', $detail->TestID)->first()['TestName'] == 'Dissolution Rate')
                                                                    <td style="text-align:center;">
                                                                        <!-- {{ 'Min-Max-Avg | ' . $item }} -->
                                                                          {{ $item }}
                                                                    </td>
                                                                @else
                                                                    <td style="text-align:center;">{{ $item }}
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @empty
                                                @endforelse

                                                @forelse ($sampleReport->sampleReportDetails as $detail)
                                                    @if ($detail->SubTestID)
                                                        @if (str_contains(SubTest::where('SubTestID', $detail->SubTestID)->first()['SubTestName'], 'Date') ||
                                                                str_contains(SubTest::where('SubTestID', $detail->SubTestID)->first()['SubTestName'], 'AR No'))
                                                            <tr>
                                                                <th colspan="2" style="text-align: center">{{ SubTest::where('SubTestID', $detail->SubTestID)->first()['SubTestName'] }}</th>
                                                                <!-- <td>{{ $detail->Specification }}</td> -->
                                                                @foreach ($detail->Value as $key => $item)
                                                                    <th>{{ $item ?? 'N/A' }}</th>
                                                                @endforeach
                                                            </tr>
                                                        @endif
                                                    @else
                                                        @if (str_contains(Test::where('TestID', $detail->TestID)->first()['TestName'], 'Date') ||
                                                                str_contains(Test::where('TestID', $detail->TestID)->first()['TestName'], 'AR No'))
                                                            <tr>
                                                                <th colspan="2" style="text-align: center">{{ Test::where('TestID', $detail->TestID)->first()['TestName'] }}</th>
                                                              
                                                                @foreach ($detail->Value as $key => $item)
                                                                    <th>{{ $item ?? 'N/A' }}</th>
                                                                @endforeach
                                                            </tr>
                                                        @endif
                                                    @endif


                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </center>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    @php
                                    $note = unserialize($sampleReport->Note);
                                    @endphp
                                    <center  style="text-align: center;" class="page-break">
                                                <p style="text-align:left; font-size:14px; font-weight:600">Note:
                                                </p>
                                                <p style="text-align:left; font-size:12px; font-weight:400">
                                                <ol
                                                    style="text-align:left; font-size:12px; font-weight:400; list-style-type: lower-roman;">
                                                    <li>{{ $note [0] ?? 'Detection limit for Atorvastatin RC D = 0.008232% and for Atorvastatin RC H = 0.031200%.' }}</li>
                                                    <li>{{ $note [1] ?? 'Quantitation limit for Atorvastatin RC D = 0.012348% and for Atorvastatin RC H = 0.050200%.' }}</li>
                                                    <li>{{ $note [2] ?? '*Atorvastatin related compound D undergoes transformation equilibrium to the atorvastatin epoxy THF analog. These two impurities are to be reported against combined specification i.e. (1.0% + 0.5% = 1.5%) under atorvastatin related compound D.' }}</li>
                                                    <li>{{ $note [3] ?? '** Microbial enumeration test and tests for special microorganism to be performed initially and yearly at 25±2 °C / 60±5 % RH condition.' }}</li>
                                                    <li>{{ $note [4] ?? 'BRL = Below Reporting Level. The reporting level for impurities is 0.1%.' }}.</li>
                                                    <li>LOQ = Limit of Quantitation.</li>
                                                    <li>LOD = Limit of Detection.</li>
                                                    <li>API = Active Pharmaceuticals Ingredients</li>
                                                    <li>Rev = Revision</li>
                                                    <li>ND = Not Detected</li>
                                                    <li>N/A = Not Applicable</li>
                                                    <li>AR No. = Analytical Reference Number</li>
                                                    <li>Mfg. = Manufacturing</li>
                                                    <li>CR = Child Resistance</li>
                                                    <li>Avg = Average</li>
                                                    <li>Min = Minimum</li>
                                                    <li>Max = Maximum</li>
                                                </ol>
                                                </p>
                                        <!--Signature -->
                                        <div 
                                            style=" border:0px solid #000; margin-bottom:50px;">
                                            <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                                                class="white">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"></th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Designation</th>
                                                        <th class="text-center">Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th height="20">Prepared By:</th>
                                                        <td style="text-align: center;">
                                                            {{ $preparedByUser ? $preparedByUser->name : '' }}</td>
                                                        <td style="text-align: center;">
                                                            {{ $preparedByUser ? $preparedByUser->designation : '' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ $sampleReport->CreatedAt? \Carbon\Carbon::parse($sampleReport->CreatedAt)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th height="20" rowspan="2">Reviewed By:</th>
                                                        <td style="text-align: center;">
                                                            {{ $reviewByOneComment ? $reviewByOneUser->name : '' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ $reviewByOneComment ? $reviewByOneUser->designation : '' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ $reviewByOneComment? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            {{ $reviewByTwoComment ? $reviewByTwoUser->name : '' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ $reviewByTwoComment ? $reviewByTwoUser->designation : '' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ $reviewByTwoComment? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th height="20">Approved By:</th>
                                                        <td style="text-align: center;">
                                                            {{ $approvalByComment ? $approvalByUser->name : '' }}</td>
                                                        <td style="text-align: center;">
                                                            {{ $approvalByComment ? $approvalByUser->designation : '' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ $approvalByComment? \Carbon\Carbon::parse($approvalByComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </th>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: center;">
                                    <div class="print-footer">
                                        {{ $sampleReport->sample->FooterSection ?? '000000525/3.00/9.1' }} <br>
                                        This is a confidential property of ACI HealthCare Limited.
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
            </div>
        </div>
    </div>
</body>

</html>
