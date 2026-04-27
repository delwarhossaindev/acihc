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

    $reviewByOneStep = $reviewerSteps->get(0);
    $reviewByTwoStep = $reviewerSteps->get(1);

    $reviewByOneUser    = $reviewByOneStep?->assignedUser;
    $reviewByOneComment = $stepToCommentObj($reviewByOneStep);
    $reviewByTwoUser    = $reviewByTwoStep?->assignedUser;
    $reviewByTwoComment = $stepToCommentObj($reviewByTwoStep);
    $approvalByUser     = $approverStep?->assignedUser;
    $approvalByComment  = $stepToCommentObj($approverStep);

    $preparedByUser = $protocol->CreatedBy ? \App\Models\User::find($protocol->CreatedBy) : null;
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>STB/PROT/{{ sprintf('%04d', $protocol->ProtocolID) }}</title>
@include('system.protocol.pdf.styles')
</head>
<body>

<p class="pdf-section-heading"><b>1. Purpose:</b></p>
<p class="text-left">{{ $protocol->Purpose }}</p>

<p class="pdf-section-heading"><b>2. Scope: (Mark &#10003; Where Applicable)</b></p>
<table class="pdf-tbl">
    <thead>
        <tr>
            <th>Exhibit Batch</th>
            <th>Commercial Validation Batch</th>
            <th>Annual Stability</th>
            <th>If others, Specify</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{!! $protocol->ExhibitBatch == 'Y' ? '<span class="pdf-check">&#10003;</span>' : 'Not applicable' !!}</td>
            <td>{!! $protocol->CommercialValidationBatch == 'Y' ? '<span class="pdf-check">&#10003;</span>' : 'Not applicable' !!}</td>
            <td>{!! $protocol->AnnualStability == 'Y' ? '<span class="pdf-check">&#10003;</span>' : 'Not applicable' !!}</td>
            <td>
                @if ($protocol->Other == 'Y') <span class="pdf-check">&#10003;</span>
                @elseif ($protocol->Other == 'N') Not applicable
                @else {!! $protocol->Other !!}
                @endif
            </td>
        </tr>
    </tbody>
</table>

<p class="pdf-section-heading"><b>3. Responsibilities:</b></p>
<div class="text-left">{!! $protocol->Responsibilities !!}</div>

<p class="pdf-section-heading"><b>4. Reference:</b></p>
<p class="text-left">{{ $protocol->Reference ?? '' }}</p>

<p class="pdf-section-heading"><b>5. Market:</b></p>
<p class="text-left">The product is intended for {{ $protocol->market->MarketName ?? '' }}.</p>

@include('system.protocol.pdf.sections.manufacturer')

<pagebreak>

<p class="pdf-section-heading"><b>7. Specification and STP Reference:</b></p>
@include('system.protocol.pdf.sections.stp')

<p class="text-left"><b>Note:</b> Current approved version to be followed at the time of execution.</p>

<p class="pdf-section-heading"><b>8. API Details:</b></p>
@include('system.protocol.pdf.sections.api_detail')

<p class="pdf-section-heading"><b>9. Primary Packaging Materials Details:</b></p>
@include('system.protocol.pdf.sections.packaging_materials')

<p class="pdf-section-heading"><b>10. Packaging Profile:</b></p>
@include('system.protocol.pdf.sections.profile')

<p class="pdf-section-heading"><b>a. Packaging component details:</b></p>
@include('system.protocol.pdf.sections.component')

<p class="pdf-section-heading"><b>11. Batch Details for Stability Study:</b></p>
@include('system.protocol.pdf.sections.batch')

<p class="pdf-section-heading"><b>12. Stability Study:</b></p>
@include('system.protocol.pdf.sections.stability_study')

<pagebreak>

<p class="pdf-section-heading"><b>13. Quantity of Samples Required for test in QC:</b></p>
@include('system.protocol.pdf.sections.test')

<p class="pdf-section-heading"><b>14. Stability Design and Number of Container/Blister/Samples to be Incubated in Stability Chamber:</b></p>
@include('system.protocol.pdf.sections.chamber')

<p class="pdf-section-heading"><b>Note:</b></p>
<div class="text-left">{!! $protocol->Note !!}</div>

<p class="pdf-section-heading"><b>15. Stability specification and analysis report, Sampling plan and reconciliation:</b></p>
<p class="text-left">{{ $protocol->AnalysisReport }}</p>

@include('system.protocol.pdf.sections.withdrawal_grid')
@include('system.protocol.pdf.sections.withdrawal_grid')

<pagebreak>

@include('system.protocol.pdf.sections.withdrawal_grid')
@include('system.protocol.pdf.sections.withdrawal_grid')

<pagebreak>

<p class="pdf-section-heading"><b>16. Reporting:</b></p>
<p class="text-left">{{ $protocol->Reporting ?? '' }}</p>

<p class="pdf-section-heading"><b>17. Conclusion:</b></p>
<p class="text-left">{{ $protocol->Conclusion ?? '' }}</p>

<p class="pdf-section-heading"><b>18. Revision History:</b></p>
<p class="text-left">{{ $protocol->RevisionHistory ?? '' }}</p>

<p class="pdf-section-heading"><b>19. Approval</b></p>
@include('system.protocol.pdf.sections.approval')

</body>
</html>
