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
            font-size: 20px;
            color: black;
            counter-reset: page; /* Initialize page counter */
            counter-increment: page;
        }

        table.white {
            background-color: #ffffff;
            color: #000000;
            font-size: 18px;
            border-collapse: collapse;
            font-family: 'myEnglishFont', Arial, sans-serif;
        }

        .responsibility>ul>li {
            font-weight: normal !important;
        }

        TH.white {
            background-color: #FFFFFF;
            color: #000000;
            font-size: 18px;
            font-weight: 600;
            border: #000000 1px solid;
            padding: 1px;
        }

        TD.white {
            background-color: #FFFFFF;
            color: #000000;
            font-size: 18px;
            font-weight: 500;
            border: #000000 1px solid;
            padding-left: 1px;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        p {
            font-size: 18px;
            font-weight: normal;
             text-align: start;

        }

        li {
            font-size: 18px;
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
                <center>
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
                                    <div style="page-break-before: always; text-align: center;">
                                        <div
                                            style="float:left; width:99%; border:0px solid #000;  page-break-before: always;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">1. Purpose:
                                                </p>
                                                <p style="text-align:left; font-size:18px; font-weight:400">
                                                    {{ $protocol->Purpose }}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">2. Scope:
                                                    (Mark &check; Where Applicable)
                                                </p>
                                                <table border="1" width="1000px" cellspacing="1" cellpadding="3"
                                                    class="white">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="font-size:18px;">Exhibit
                                                                Batch</th>
                                                            <th class="text-center" style="font-size:18px;">Commercial
                                                                Validation<br>Batch</th>
                                                            <th class="text-center" style="font-size:18px;">Annual
                                                                Stability</th>
                                                            <th class="text-center" style="font-size:18px;">If others,
                                                                Specify</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center" height="35"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; border-right:0px solid #000; text-align:left;"
                                                class="responsibility">
                                                <p style="text-align:left; font-size:20px; font-weight:600;">
                                                    3. Responsibilities:
                                                </p>
                                                <p style="text-align:left; font-size:18px; font-weight: normal;">
                                                    {!! $protocol->Responsibilities !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <p style="text-align:left; font-size:20px; font-weight:600">4. Reference:
                                            </p>
                                            <p style="text-align:left; font-size:18px; font-weight:400">
                                                {{ $protocol->Reference }}
                                            </p>

                                        </div>

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">5. Market:
                                                </p>
                                                <p style="text-align:left; font-size:18px; font-weight:400">
                                                    The product is intended for {{ $protocol->market->MarketName }}.
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

                                        <p style="text-align:left; font-size:20px; font-weight:600">7. Specification and
                                            STP Reference:</p>

                                        @include('system.protocol.report.stp')

                                     
                                        <p style="text-align: start;"> <b>Note :</b> Current approved version to be followed at the time of execution.</p>
                                        

                                        <p style="text-align:left; font-size:20px; font-weight:600">8. API Details:</p>

                                        @include('system.protocol.report.api_detail')

                                        <p style="text-align:left; font-size:20px; font-weight:600">9. Primary Packaging
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
                                                <p style="text-align:left; font-size: 20px; font-weight:600">
                                                    10. Packaging Profile:</p>
                                            </div>
                                        </div>
                                        @include('system.protocol.report.profile')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">a.
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
                                                <p style="text-align:left; font-size:20px; font-weight:600">11. Batch
                                                    Details for Stability Study:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.batch')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">12.
                                                    Stability Study:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.stability_study')


                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">13.
                                                    Quantity
                                                    of Samples Required for test in QC:</p>
                                            </div>
                                        </div>


                                        @include('system.protocol.report.test')


                                        {{-- <div style="text-align:center;">
                                            <p style=" font-size: 12px; margin-bottom: 0px;">000000650/3.01/9.1 </p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">This is a confidential property of ACI HealthCare Limited.</p>
                                            <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px;">page 4 of 8</p>

                                        </div> --}}

                                    </div>

                                    <div style="page-break-before: always; text-align: center;">
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">14.
                                                Stability Design and Number of Container/ Blister/Samples to be Incubated in Stability Chamber:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.chamber')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:20px; font-weight:600">Note:</p>
                                                <p style="text-align:left; font-size:18px; font-weight:400">
                                                <ol
                                                    style="text-align:left; font-size:18px; font-weight:400; list-style-type: lower-roman;">
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
                                    <p style=" font-size: 12px; margin-bottom: 0px; text-align: center;">{{ $protocol->FooterSectionNo }}</p>
                                    <p style=" font-size: 12px; margin-bottom: 0px; margin-top: 0px; text-align: center;">This is a confidential property of ACI HealthCare Limited.</p>

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
