@php
    $protocolNo = sprintf('%04d', $protocol->ProtocolID);
    $strengths  = isset($protocol->product->skus)
        ? $protocol->product->skus->pluck('ProductStrength')->filter()->implode(', ')
        : '';
@endphp
<table class="pdf-page-header" cellpadding="6" cellspacing="0">
    <tr>
        <td class="pdf-ph-logo">
            <img src="{{ public_path('logo.png') }}" width="36" height="36">
        </td>
        <td class="pdf-ph-title"><b>ACI HealthCare Limited</b></td>
        <td class="pdf-ph-meta">
            <div class="pdf-ph-protocol"><b>Stability Protocol</b></div>
            <div class="pdf-ph-protocol-no"><b>Protocol No:STB/PROT/{{ $protocolNo }}; Version:{{ $versionCount ?? '1.00' }}</b></div>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="pdf-ph-product"><b>{{ $protocol->Title ?? '' }}</b></td>
    </tr>
    <tr>
        <td colspan="3" class="pdf-ph-strength"><strong>Strength:</strong> {{ $strengths }}</td>
    </tr>
</table>
