<div class="row">
    <div class="col mb-3">
        <label for="StudyTypeName" class="form-label">Study Type Name</label> <span style="color: red">*</span>
        <input type="text" name="StudyTypeName" id="StudyTypeName" class="form-control" placeholder="Accelerated" required value="{{ isset($studytype) ? $studytype->StudyTypeName : '' }}">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="StudyTypeMonth" class="form-label">Stability Study Month</label> <span style="color: red">*</span>
        <input name="StudyTypeMonth" placeholder="Enter value and press enter" value="@if(isset($studytype->details)) {{ json_encode($previousStudyMonth,TRUE) }} @endif" required class="form-control"> 
    </div>
</div>

<button type="submit" class="btn btn-primary mt-2">Save changes</button>