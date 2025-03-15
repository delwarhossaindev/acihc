@if (isset($protocol))
@php

$reviewByOneUserID =  null;
$reviewByTwoUserID = null;
$approvalByUserID = null;
$reviewByOneComment = null;
$reviewByTwoComment = null;
$reviewByTwoComment = null;
$approvalByComment = null;


$reviewByOne = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
    ->where('ProtocolApprovalTypeID', 1)
    ->first();
$reviewByOneUserID = $reviewByOne->UserID ?? null;
$reviewByOneUser = $reviewByOne ? \App\Models\User::find($reviewByOne->UserID) : null;
$reviewByOneComment = $reviewByOne ? \App\Models\ProtocolReviewer::where('ProtocolID', $protocol->ProtocolID)
    ->where('UserID', $reviewByOne->UserID)
    ->first() : null;

$reviewByTwo = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
    ->where('ProtocolApprovalTypeID', 1)
    ->latest('CreateDate')
    ->first();

$reviewByTwoUserID = $reviewByTwo->UserID ?? null;
$reviewByTwoUser = $reviewByTwo ? \App\Models\User::find($reviewByTwo->UserID) : null;
$reviewByTwoComment = $reviewByTwo ? \App\Models\ProtocolReviewer::where('ProtocolID', $protocol->ProtocolID)
    ->where('UserID', $reviewByTwo->UserID)
    ->first() : null;

$approvalBy = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
    ->where('ProtocolApprovalTypeID', 2)
    ->first();

$approvalByUserID = $approvalBy->UserID ?? null;
$approvalByUser = $approvalBy ? \App\Models\User::find($approvalBy->UserID) : null;
$approvalByComment = $approvalBy ? \App\Models\ProtocolApprover::where('ProtocolID', $protocol->ProtocolID)
    ->where('UserID', $approvalBy->UserID)
    ->first() : null;

@endphp

<div class="row g-3" data-select2-id="8">



@if(($reviewByOneUserID == auth()->user()->id) && !$reviewByOneComment)

    <div class="col-6">
    <input type="hidden" name="reviewByOne" value="{{ $reviewByOne }}">
    <input type="hidden" name="reviewByOneUser" value="{{ $reviewByOneUser }}">
    <p>Name: {{$reviewByOneUser->name ?? null}} &nbsp; &nbsp; Designation: {{$reviewByOneUser->designation ?? null}}</p>

    <label class="form-label" >Comment Review (One) </label>
    <textarea id="commentOne" name="commentOne" class="form-control" rows="2" placeholder="Comment Review One" ></textarea>
    </div>

    <div class="col-6"></div>
@else
   <div class="col-6">
     <label class="form-label" >Comment Review (One) </label>
    <p>Name: {{$reviewByOneUser->name ?? null}} &nbsp; &nbsp; Designation: {{$reviewByOneUser->designation ?? null}}</p>
    @if(!$reviewByOneComment)
    <p>Review One Pending !</p>
    @else
    <p>Comment: {{ $reviewByOneComment->Comment }}  <br> Review One Complete !</p>
    @endif
    </div>

<div class="col-6"></div>
@endif

@if(($reviewByTwoUserID == auth()->user()->id) && !$reviewByTwoComment )
    <div class="col-6">
    <input type="hidden" name="reviewByTwo" value="{{ $reviewByTwo }}">
    <input type="hidden" name="reviewByTwoUser" value="{{ $reviewByTwoUser }}">
    <p>Name: {{$reviewByTwoUser->name ?? null}} &nbsp; &nbsp; Designation: {{$reviewByTwoUser->designation ?? null}}</p>
    <label class="form-label" >Comment Review (Two) </label>
    <textarea id="commentTwo" name="commentTwo" class="form-control" rows="2" placeholder="Comment Review Two" ></textarea>
    </div>
    <div class="col-6"></div>
@else

<div class="col-6">
     <label class="form-label" >Comment Review (Two) </label>
     <p>Name: {{$reviewByTwoUser->name ?? null}} &nbsp; &nbsp; Designation: {{$reviewByTwoUser->designation ?? null}}</p>

     @if(!$reviewByTwoComment)
    <p>Review Two Pending !</p>
    @else
    <p>Comment: {{ $reviewByTwoComment->Comment }}  <br> Review Two Complete !</p>
    @endif
    </div>

<div class="col-6"></div>

@endif

 @if(($approvalByUserID == auth()->user()->id) && !$approvalByComment && $reviewByTwoComment && $reviewByOneComment )
    <div class="col-6">
    <input type="hidden" name="approvalBy" value="{{ $approvalBy }}">
    <input type="hidden" name="approvalByUser" value="{{ $approvalByUser }}">
    <p>Name: {{$approvalByUser->name ?? null}} &nbsp; &nbsp; Designation: {{$approvalByUser->designation ?? null}}</p>

    <label class="form-label" >Approval Comment : </label>
    <textarea id="approvalComment" name="approvalComment" class="form-control" rows="2" placeholder="Approval Comment" ></textarea>
    </div>

    <div class="col-6">

    </div>
        <div class="col-6">
        <label class="form-label" >Approval</label>
        <select class="form-control custom-select" name="Approval" required>
                <option value="Approved" >Approved</option>
                <option value="Decline" >Decline</option>
            </select>
        </div>

        <div class="col-6">

        </div>

    @else
    <div class="col-6">
    <label class="form-label" >Approval Comment : </label>
    <p>Name: {{$approvalByUser->name ?? null }}  &nbsp; &nbsp; Designation: {{$approvalByUser->designation ?? null}}</p>
     @if(!$approvalByComment)
    <p>Approval Pending !</p>
    @else
    <p>Comment: {{ $approvalByUser->Comment }} </p>
    @if($protocol->ProtocolStatusID == 4)
    <p style="background-color: green; color: white; padding: 15px 25px; border-radius: 15px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); text-align: center; font-size: 16px;">
        Approval Complete!
    </p>
@else
    <p style="background-color: red; color: white; padding: 15px 25px; border-radius: 15px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); text-align: center; font-size: 16px;">
        This Protocol Decline!
    </p>
@endif
            
    @endif
    </div>

   <div class="col-6"></div>

    @endif



    <div class="modal-footer">
    @if(!in_array($protocol->ProtocolStatusID, [4, 5]))
    <button type="submit" class="btn btn-primary">Save changes</button>
     @endif
    </div>
</div>

@endif
