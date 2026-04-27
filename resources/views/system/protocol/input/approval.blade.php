@php
    $steps = $protocol->approvalSteps()->with('assignedUser:id,name,designation')->get();
    $authId = auth()->id();

    $myStep = $steps->first(fn ($s) => $s->AssignedUserID === $authId && $s->isPending());

    $priorPending = $myStep
        ? $steps->where('StepOrder', '<', $myStep->StepOrder)->contains(fn ($s) => $s->isPending())
        : false;

    $canAct = $myStep && ! $priorPending && ! in_array($protocol->ProtocolStatusID, [4, 5]);

    $statusBadge = function ($step) {
        return match ($step->Decision) {
            'Approved' => '<span class="badge bg-success">Approved</span>',
            'Declined' => '<span class="badge bg-danger">Declined</span>',
            default    => '<span class="badge bg-secondary">Pending</span>',
        };
    };
@endphp

<div class="row g-3">
    <div class="col-12">
        <h6 class="text-muted mb-3">Review &amp; Approval Chain</h6>

        @if ($steps->isEmpty())
            <div class="alert alert-info">No reviewers or approver have been assigned yet.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px;">Step</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th style="width:140px;">Decided At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($steps as $step)
                            <tr @if ($myStep && $step->ID === $myStep->ID) class="table-warning" @endif>
                                <td>{{ $step->StepOrder }}</td>
                                <td>{{ $step->Role }}</td>
                                <td>{{ $step->assignedUser->name ?? 'N/A' }}</td>
                                <td>{{ $step->assignedUser->designation ?? '' }}</td>
                                <td>{!! $statusBadge($step) !!}</td>
                                <td>{{ $step->Comment ?: '—' }}</td>
                                <td>{{ $step->DecidedAt ? $step->DecidedAt->format('Y-m-d H:i') : '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if ($canAct)
        <div class="col-12 mt-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        Your Decision — Step {{ $myStep->StepOrder }} ({{ $myStep->Role }})
                    </h6>

                    <input type="hidden" name="step_id" value="{{ $myStep->ID }}">

                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" class="form-control" rows="3"
                                  placeholder="Comment (optional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Decision <span class="text-danger">*</span></label>
                        <select name="decision" class="form-select" required>
                            <option value="" disabled selected>Select decision</option>
                            <option value="Approved">Approve</option>
                            <option value="Declined">Decline</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Decision</button>
                </div>
            </div>
        </div>
    @elseif ($myStep && $priorPending)
        <div class="col-12 mt-3">
            <div class="alert alert-warning mb-0">
                You have a pending step, but a previous reviewer has not decided yet. Please wait.
            </div>
        </div>
    @elseif (in_array($protocol->ProtocolStatusID, [4, 5]))
        <div class="col-12 mt-3">
            @if ($protocol->ProtocolStatusID == 4)
                <div class="alert alert-success mb-0">Approval Complete!</div>
            @else
                <div class="alert alert-danger mb-0">This Protocol is Declined.</div>
            @endif
        </div>
    @endif
</div>
