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

$versionCount = $versionCount ?: '1.00';

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Report</title>
    <style>
        /* General styles */
        body {
            font-family: 'myEnglishFont';
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            position: fixed;
            width: 100%;
            /* background: white; */
            /* color: black; */
            text-align: center;
            padding: 10px 0;
        }

        .header {
            top: 0;
        }

        .footer {
            bottom: 0;
            page-break-after: always;
        }

        .content {
            margin: 187px 0px 86px;
            font-size: 12px;
        }

        /* Print-specific styles */
        @media print {

            @page {
                font-family: "Fira Mono";
                font-size: 12px;
                sheet-size: A4;


                @top-right {
                    content: 'Page ' counter(page) ' of ' counter(pages);
                }


            }

            .header,
            .footer {
                position: fixed;
                width: 100%;
                background: white;
                color: black;
                text-align: center;
                padding: 10px 0;

            }

            .header {
                top: 0;
            }

            .footer {
                bottom: 0;
                page-break-after: always;
            }




            .content {
                margin-top: 187px;
                margin-bottom: 187px;
            }



        }
    </style>
</head>

<body>





    <div class="header">
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


                    <p>Report No: STB/REPORT/{{ sprintf('%04d', $sampleReport->SampleReportID) }}
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

        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; font-size: 8px;  margin-top: 15px;">

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;"> Product Name:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ $sampleReport->sample->protocol->product->ProductName ?? '' }}
                </td>
            </tr>
            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;"> Batch No:</th>
                <td align="left" style="border: 1px solid black; border-collapse: collapse;">
                    {{ isset($sampleReport->batch) ? $sampleReport->batch->BatchNo : 'N/A' }}
                </td>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Strorage Conditions:</th>
                <td align="left" style="border: 1px solid black; border-collapse: collapse;">{{ $sampleReport->condition->ConditionName }}</td>
            </tr>

        </table>
    </div>

    <div class="content">




        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; margin-top: 15px;">

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;"> Batch Size:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ isset($sampleReport->batch) ? $sampleReport->batch->BatchSize : 'N/A' }}
                </td>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;"> Mfg Date:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ isset($sampleReport->batch) ? Carbon::parse($sampleReport->batch->MfgDate)->toFormattedDateString() : 'N/A' }}
                </td>
            </tr>

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;"> Protocol No:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    STB/PROT/{{ sprintf('%04d', $sampleReport->sample->protocol->ProtocolID) }},Rev:{{ $versionCount }}
                </td>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;"> Expiry Date:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ isset($sampleReport->batch) ? Carbon::parse($sampleReport->batch->ExpDate)->toFormattedDateString() : 'To Be Defined' }}
                </td>
            </tr>

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Specification No:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ $sampleReport->sample->SpecificationNo ? $sampleReport->sample->SpecificationNo : ProtocolProductDetail::where('ProtocolID', $sampleReport->sample->protocol->ProtocolID)->first()['SpecificationNo'] }}
                </td>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Pakaging Date:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ Carbon::parse($sampleReport->sample->PackagingDate)->toFormattedDateString() ?? '' }}
                </td>
            </tr>

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">STP No:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ $sampleReport->sample->STPNo ? $sampleReport->sample->STPNo : ProtocolProductDetail::where('ProtocolID', $sampleReport->sample->protocol->ProtocolID)->first()['STPNo'] }}
                </td>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Stability Initiation Date:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ isset($sampleReport->batch) ? Carbon::parse($sampleReport->batch->SIDate)->toFormattedDateString() : 'N/A' }}
                </td>
            </tr>

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Name Of the API:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    @foreach ($sampleReport->sample->protocol->protocolApiDetails->pluck('APIDetailID') as $api)
                    {{ ApiDetail::where('ApiDetailID', $api)->first()->ApiDetailName }},
                    @endforeach
                </td>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Reason of the Stability:</th>
                <td align="left" colspan="3" style="border: 1px solid black; border-collapse: collapse;">
                    {{ isset($sampleReport->batch) ? $sampleReport->batch->BatchName : 'N/A' }}
                </td>
            </tr>

            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">API Manufacturer:</th>
                <td align="left" colspan="5" style="width:40%; border: 1px solid black; border-collapse: collapse;">
                    @foreach ($sampleReport->sample->protocol->protocolApiDetails->pluck('APIDetailID') as $api)
                    {{ ApiDetail::where('ApiDetailID', $api)->first()->APIDetailSource }},
                    @endforeach
                </td>

            </tr>
            <tr>
                <th align="left" style="border: 1px solid black; border-collapse: collapse;">Description of Pack:</th>
                <td align="left" colspan="5" style="width:40%; border: 1px solid black; border-collapse: collapse;">
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



        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th rowspan="2" style="border: 1px solid black; border-collapse: collapse;">Tests</th>
                    <th rowspan="2" style="border: 1px solid black; border-collapse: collapse;">Specification</th>
                    <th colspan="{{ count($duration) }}" style="border: 1px solid black; border-collapse: collapse;">Stability Study Data(Months)
                    </th>
                </tr>
                <tr>
                    @forelse($duration as $month)
                    <th style="border: 1px solid black; border-collapse: collapse;">{{ $month }} M</th>
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

        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; border-collapse: collapse;">
                        <p style="text-align:left; font-size:14px; font-weight:600">Note:
                        </p>
                        <p style="text-align:left; font-size:12px; font-weight:400">
                        <ol
                            style="text-align:left; font-size:12px; font-weight:400; list-style-type: lower-roman;">
                            <li>1. Detection limit for Atorvastatin RC D = 0.008232% and for
                                Atorvastatin RC H = 0.031200%.</li>
                            <li>2. Quantitation limit for Atorvastatin RC D = 0.012348% and for
                                Atorvastatin RC H = 0.050200%.</li>
                            <li>3. *Atorvastatin related compound D undergoes transformation
                                equilibrium to the atorvastatin epoxy THF analog. These two
                                impurities are to be reported against combined specification
                                i.e. (1.0% + 0.5% = 1.5%) under atorvastatin related compound D.
                            </li>
                            <li>4. ** Microbial enumeration test and tests for special
                                microorganism to be performed initially and yearly at 25±2 °C /
                                60±5 % RH condition.</li>
                            <li>5. BRL = Below Reporting Level. The reporting level for
                                impurities is 0.1%.</li>
                            <li>6. LOQ = Limit of Quantitation.</li>
                            <li>7. LOD = Limit of Detection.</li>
                            <li>8. API = Active Pharmaceuticals Ingredients</li>
                            <li>9. Rev = Revision</li>
                            <li>10. ND = Not Detected</li>
                            <li>11. N/A = Not Applicable</li>
                            <li>12. AR No. = Analytical Reference Number</li>
                            <li>13. Mfg. = Manufacturing</li>
                            <li>14. CR = Child Resistance</li>
                            <li>15. Avg = Average</li>
                            <li>16. Min = Minimum</li>
                            <li>17. Max = Maximum</li>
                        </ol>
                        </p>
                    </th>

                </tr>
            </thead>

        </table>



        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th class="text-center" style="border: 1px solid black; border-collapse: collapse;"></th>
                    <th class="text-center" style="border: 1px solid black; border-collapse: collapse;">Name</th>
                    <th class="text-center" style="border: 1px solid black; border-collapse: collapse;">Designation</th>
                    <th class="text-center" style="border: 1px solid black; border-collapse: collapse;">Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th height="20" style="border: 1px solid black; border-collapse: collapse;">Prepared By:</th>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $preparedByUser ? $preparedByUser->name : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $preparedByUser ? $preparedByUser->designation : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $sampleReport->CreatedAt? \Carbon\Carbon::parse($sampleReport->CreatedAt)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                    </td>
                </tr>
                <tr>
                    <th height="20" rowspan="2" style="border: 1px solid black; border-collapse: collapse;">Reviewed By:</th>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $reviewByOneComment ? $reviewByOneUser->name : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $reviewByOneComment ? $reviewByOneUser->designation : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $reviewByOneComment? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $reviewByTwoComment ? $reviewByTwoUser->name : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $reviewByTwoComment ? $reviewByTwoUser->designation : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $reviewByTwoComment? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                    </td>
                </tr>
                <tr>
                    <th height="20" style="border: 1px solid black; border-collapse: collapse;">Approved By:</th>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $approvalByComment ? $approvalByUser->name : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $approvalByComment ? $approvalByUser->designation : '' }}
                    </td>
                    <td style="text-align: center;" style="border: 1px solid black; border-collapse: collapse;">
                        {{ $approvalByComment? \Carbon\Carbon::parse($approvalByComment->CreateDate)->timezone('Asia/Dhaka')->format('Y-m-d h:i A'): '' }}
                    </td>
                </tr>
            </tbody>
        </table>


    </div>

    <div class="footer">
        <p style="text-align: center; font-size: 12px; font-weight: 600;">{{ $sampleReport->sample->FooterSection ?? '000000525/3.00/9.1' }}
        </p>
        <p style="text-align: center; font-size: 12px; font-weight: 400;"> This is a confidential property of ACI HealthCare Limited.</p>


    </div>

</body>


</html>