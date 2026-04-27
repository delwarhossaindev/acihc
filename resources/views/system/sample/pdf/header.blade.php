@php
    $reportNo = sprintf('%04d', $sampleReport->SampleReportID);
    $headline = $sampleReport->Headline ?? ($sampleReport->sample->product->ProductName ?? '');
@endphp
<table class="pdf-page-header" cellpadding="6" cellspacing="0">
    <tr>
        <td class="pdf-ph-logo" rowspan="2">
            <img src="{{ public_path('logo.png') }}" width="46" height="46">
        </td>
        <td class="pdf-ph-title"><b>ACI HealthCare Limited</b></td>
        <td class="pdf-ph-meta"><b>Report No: STB/REPORT/{{ $reportNo }}</b></td>
    </tr>
    <tr>
        <td class="pdf-ph-product"><b>{{ $headline }}</b></td>
        <td class="pdf-ph-qc"><b>Quality Control</b></td>
    </tr>
</table>
