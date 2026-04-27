

<table border="0" width="890px" cellspacing="1" cellpadding="3" class="white">
    <thead>
        <tr>
            <th>
                <center>
                    {{-- <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size: 18px; font-weight:600">16.Sampling Plan:</p>
                        </div>
                    </div>
                    @include('system.protocol.report.image') --}}

                    {{-- <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size: 18px; font-weight:600">15.
                                Stability specification and analysis report, Sampling plan and reconciliation:</p>
                            <p style="text-align:left; font-size: 16px; font-weight:400">
                                {{ $protocol->AnalysisReport }}
                            </p>
                        </div>
                    </div>

                    <img src="{{ asset('table.png') }}" alt="Table Image" style="width:99%; height: 500px;">

                    <img src="{{ asset('table.png') }}" alt="Table Image" style="width:99%; height: 500px;">

                    <img src="{{ asset('table.png') }}" alt="Table Image" style="width:99%; height: 500px;">

                    <img src="{{ asset('table.png') }}" alt="Table Image" style="width:99%; height: 500px;"> --}}



                    <div style=" float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size: 18px; font-weight:600">16.
                                Reporting:</p>
                            <p style="text-align:left; font-size: 16px; font-weight:400">
                                {{ $protocol->Reporting }}
                            </p>
                        </div>
                    </div>

                    <div style="float:left; width:99%; border:0px solid #000;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size: 18px; font-weight:600">17.
                                Conclusion:</p>
                            <p style="text-align:left; font-size: 16px; font-weight:400">
                                {{ $protocol->Conclusion }}
                            </p>
                        </div>
                    </div>

                    <div style="float:left; width:99%; border:0px solid #000; margin-bottom:500px;">
                        <div style="float:left; width:99%; border-right:0px solid #000;">
                            <p style="text-align:left; font-size: 18px; font-weight:600">18. Revision
                                History:</p>
                            <p style="text-align:left; font-size: 16px; font-weight:400">
                                {{ $protocol->RevisionHistory }}
                            </p>

                        <p style="text-align:left; font-size: 18px; font-weight:600">19. Approval</p>
                        <table border="1" width="990px" cellspacing="1" cellpadding="3"
                            class="white">
                            <thead>
                                <tr>
                                    <th class="text-center" style="font-size: 16px;"></th>
                                    <th class="text-center" style="font-size: 16px;">Name</th>
                                    <th class="text-center" style="font-size: 16px;">Designation</th>
                                    <th class="text-center" style="font-size: 16px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center" height="30">Prepared By:</th>
                                    <td class="text-center">{{  $preparedByUser ? $preparedByUser->name : ''  }}</td>
                                    <td class="text-center">{{  $preparedByUser ? $preparedByUser->designation : ''  }}</td>
                                    <td class="text-center">{{  $protocol->CreatedDate ? \Carbon\Carbon::parse($protocol->CreatedDate)->format('Y-m-d') : ''  }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" height="35" rowspan="2">Reviewed By:</th>
                                    <td class="text-center">{{  $reviewByOneComment ? $reviewByOneUser->name : ''  }}</td>
                                    <td class="text-center">{{  $reviewByOneComment ? $reviewByOneUser->designation : ''  }}</td>
                                    <td class="text-center">{{ $reviewByOneComment ? \Carbon\Carbon::parse($reviewByOneComment->CreateDate)->format('Y-m-d') : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">{{  $reviewByTwoComment ? $reviewByTwoUser->name : ''  }}</td>
                                    <td class="text-center">{{  $reviewByTwoComment ? $reviewByTwoUser->designation : ''  }}</td>
                                    <td class="text-center">{{ $reviewByTwoComment ? \Carbon\Carbon::parse($reviewByTwoComment->CreateDate)->format('Y-m-d'): '' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" height="30">Approved By:</th>
                                    <td class="text-center">{{  $approvalByComment ? $approvalByUser->name : ''  }}</td>
                                    <td class="text-center">{{  $approvalByComment ? $approvalByUser->designation : ''  }}</td>
                                    <td class="text-center">{{ $approvalByComment ? \Carbon\Carbon::parse($approvalByComment->CreateDate)->format('Y-m-d') : '' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- <p style="text-align:left; font-size: 18px; font-weight:600">20. About</p> -->

                        </div>
                    </div>



                </center>
            </th>
        </tr>
    </thead>


</table>
