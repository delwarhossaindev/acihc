<div class="row">
    <div class="col mb-3">
        <label for="SubTestName" class="form-label">Sub Test Name</label> <span style="color: red">*</span>
        <input type="text" name="SubTestName" id="SubTestName" class="form-control" required value="{{ isset($subtest) ? $subtest->SubTestName : '' }}">
        <div class="invalid-tooltip">This field is required and must be unique</div>
    </div>
    <div class="col mb-3">
        <label for="SubTestType" class="form-label">Sub Test Type</label><span style="color: red">*</span>
        <select class="form-select custom-select" name="SubTestType" required>
            <option value="" selected disabled>Select type</option>
            <option value="text" {{ isset($subtest) ? $subtest->TestType == 'text' ? 'selected' : '' : '' }}>Text</option>
            <option value="date" {{ isset($subtest) ? $subtest->TestType == 'date' ? 'selected' : '' : '' }}>Date</option>
            <option value="percentage" {{ isset($subtest) ? $subtest->TestType == 'percentage' ? 'selected' : '' : '' }}>Percentage</option>
            <option value="min_max_avg" {{ isset($subtest) ? $subtest->TestType == 'min_max_avg' ? 'selected' : '' : '' }}>Min Max Avg</option>
        </select>
    </div>
</div>

<button type="submit" class="btn btn-primary mt-2">Save changes</button>
