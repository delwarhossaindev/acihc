<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <title></title>
    <meta charset="utf-8">
    <style type="text/css">
        @font-face {
            color: black;
            font-size: 12px;
            font-family: myEnglishFont;
            font-weight: 600;
        }

        table.white {
            background-color: #ffffff;
            color: #000000;
            font-size: 11px;
            border-collapse: collapse;
            font-family: myEnglishFont;
        }

        .responsibility > ul > li {
            font-weight: normal !important;
        }

        TH.white {
            background-color: #FFFFFF;
            color: #000000;
            font-size: 11px;
            font-weight: 600;
            border: #000000 1px solid;
            padding: 1px;
        }

        TD.white {
            background-color: #FFFFFF;
            color: #000000;
            font-size: 10px;
            font-weight: 500;
            border: #000000 1px solid;
            padding-left: 1px;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        footer {
            font-size: 9px;
            color: #f00;
            text-align: center;
        }

        .container{
            page-break-before: always;
        }

        @media print {
            tfoot {
                position: fixed;
                bottom: 0;
                text-align: center;
            }

        }
    </style>
</head>
<!--<body onLoad="window.print()">-->

<body>
    <!--Page 1 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>
                                        @include('system.protocol.report.hero')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">1. Purpose:
                                                </p>
                                                <p style="text-align:left; font-size:12px; font-weight:400">
                                                    {{ $protocol->Purpose }}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">2. Scope:
                                                </p>
                                                <p style="text-align:left; font-size:12px; font-weight:400">
                                                    {!! $protocol->Scope !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; border-right:0px solid #000; text-align:left;" class="responsibility">
                                                <p style="text-align:left; font-size:14px; font-weight:600">
                                                    3.Responsibilities:
                                                </p>
                                                {!! $protocol->Responsibilities !!}
                                            </div>
                                        </div>
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <p style="text-align:left; font-size:14px; font-weight:600">4. Reference:
                                            </p>
                                            <p style="text-align:left; font-size:12px; font-weight:400">
                                                {{ $protocol->Reference }}
                                            </p>
                                        </div>

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">5. Market:
                                                </p>
                                                <p style="text-align:left; font-size:12px; font-weight:400">
                                                    {{ $protocol->market->MarketName }}.
                                                </p>
                                            </div>
                                        </div>
                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 1 of 8</td>
                            </tr>

                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>

    <!--Page 1 END-->

    <!--Page 2 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>

                                        @include('system.protocol.report.hero')

                                        @include('system.protocol.report.manufacturer')

                                        <p style="text-align:left; font-size:14px; font-weight:600">7. Specification and
                                            STP Reference:</p>

                                        @include('system.protocol.report.stp')

                                        <p style="text-align:left; font-size:12px; font-weight:400">Note: Current
                                            approved version to be followed at the time of execution.</p>

                                        <p style="text-align:left; font-size:14px; font-weight:600">8. API Details:</p>

                                        @include('system.protocol.report.api_detail')

                                        <p style="text-align:left; font-size:14px; font-weight:600">9. Packaging Materials Details:</p>

                                        @include('system.protocol.report.packaging_materials')

                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 2 of 8</td>
                            </tr>
                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>
    <!--Page 2 END-->

    <!--Page 3 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>
                                        {{-- @include('system.protocol.report.hero') --}}
                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">10.
                                                    Packaging Profile:</p>
                                            </div>
                                        </div>
                                        @include('system.protocol.report.profile')
                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 3 of 8</td>
                            </tr>

                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>
    <!--Page 3 END-->


    <!--Page 4 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>
                                        @include('system.protocol.report.hero')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">11.
                                                    Packaging component details:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.component')

                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 4 of 8</td>
                            </tr>

                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>
    <!--Page 4 END-->


    <!--Page 5 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>

                                        @include('system.protocol.report.hero')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">12. Batch
                                                    Details for Stability Study:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.batch')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">13.
                                                    Stability Study:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.stability_study')

                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 5 of 8</td>
                            </tr>

                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>
    <!--Page 5 END-->


    <!--Page 6 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>
                                        {{-- @include('system.protocol.report.hero') --}}

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">14.
                                                    Quantity
                                                    of Samples Required for Physical and Chemical test in QC:</p>
                                            </div>
                                        </div>


                                        @include('system.protocol.report.test')


                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 6 of 8</td>
                            </tr>

                        </tfoot>
                    </table>
                </center>

            </div>
        </div>
    </div>
    <!--Page 6 END-->

    <!--Page 7 Starts-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <table border="0" width="1000px" cellspacing="1" cellpadding="3" class="white">
                        <thead>
                            <tr>
                                <th>
                                    <center>

                                        @include('system.protocol.report.hero')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">15.
                                                    Stability Design and Number of Container to be Incubated in
                                                    Stability Chamber:</p>
                                            </div>
                                        </div>

                                        @include('system.protocol.report.chamber')

                                        <div style="float:left; width:99%; border:0px solid #000;">
                                            <div style="float:left; width:99%; border-right:0px solid #000;">
                                                <p style="text-align:left; font-size:14px; font-weight:600">Note:</p>
                                                <p style="text-align:left; font-size:12px; font-weight:400">
                                                <ol
                                                    style="text-align:left; font-size:12px; font-weight:400; list-style-type: lower-roman;">
                                                    <li>Additional Study Sample will be pulled out and tested only if
                                                        needed.</li>
                                                    <li>*The Placebo should be subjected to stability studies for the
                                                        “Organic impurities test”.</li>
                                                    <li>Intermediate (IN) conditions will be withdrawn only if any
                                                        significant change or OOS found during Accelerated (AC) Study.
                                                    </li>
                                                </ol>
                                                </p>
                                            </div>
                                        </div>

                                    </center>
                                </th>
                            </tr>
                        </thead>

                        <tfoot align="center">
                            <tr>
                                <td style="font-size:9px; font-weight:600" align="center">000000650/2.00/9.1</td>
                            </tr>
                            <tr>
                                <td style="font-size:8px; font-weight:400" align="center">This is a confidential
                                    property of ACI HealthCare Limited.</td>
                            </tr>
                            <tr>
                                <td style="font-size:7px; font-weight:400; float:right;">Page # 7 of 8</td>
                            </tr>
                        </tfoot>
                </center>
            </div>
        </div>
    </div>
    <!--Page 7 END-->

    <!--Page 8 Starts-->
    @include('system.protocol.report.footer')
    <!--Page 8 END-->
</body>

</html>
