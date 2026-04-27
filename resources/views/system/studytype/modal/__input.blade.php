<div class="row g-3">
    <div class="col-12">
        <label for="StudyTypeName" class="form-label">Study Type Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-temperature-half"></i></span>
            <input type="text" name="StudyTypeName" id="StudyTypeName" class="form-control" placeholder="e.g. Accelerated, Long Term" required value="{{ $studytype->StudyTypeName ?? '' }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>
    <div class="col-12">
        <label for="StudyTypeMonth" class="form-label">Stability Study Months <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-calendar-days"></i></span>
            <input name="StudyTypeMonth" id="StudyTypeMonth" placeholder="Enter values and press Enter (e.g. 0, 3, 6, 9, 12)" value="@if (isset($studytype->details)){{ json_encode($previousStudyMonth, true) }}@endif" required class="form-control">
        </div>
        <div class="form-text">Press Enter after each value to add it as a tag.</div>
    </div>
</div>
