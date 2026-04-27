<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>STB/REPORT/{{ sprintf('%04d', $sampleReport->SampleReportID) }}</title>
@include('system.sample.pdf.styles')
</head>
<body>

@include('system.sample.pdf.sections.info')

<pagebreak>

@include('system.sample.pdf.sections.test_results')

@include('system.sample.pdf.sections.note')

@include('system.sample.pdf.sections.approval')

</body>
</html>
