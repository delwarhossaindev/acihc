@php
    $note = [];
    if (! empty($sampleReport->Note)) {
        $decoded = @unserialize($sampleReport->Note);
        if (is_array($decoded)) {
            $note = $decoded;
        }
    }
@endphp
<p class="pdf-note-heading"><b>Note:</b></p>
<ol class="pdf-note">
    @foreach ($note as $item)
        <li>{{ $item }}</li>
    @endforeach
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
