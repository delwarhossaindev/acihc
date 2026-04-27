<div class="row g-3">
    <div class="col-md-6">
        <label for="SubTestName" class="form-label">Sub Test Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-flask-vial"></i></span>
            <input type="text" name="SubTestName" id="SubTestName" class="form-control" required value="{{ $subtest->SubTestName ?? '' }}">
            <div class="invalid-feedback">Required and must be unique.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="SubTestType" class="form-label">Sub Test Type <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-list"></i></span>
            <select id="SubTestType" class="form-select" name="SubTestType" required>
                <option value="" selected disabled>Select type</option>
                @foreach (['text' => 'Text', 'date' => 'Date', 'percentage' => 'Percentage', 'min_max_avg' => 'Min Max Avg'] as $val => $label)
                    <option value="{{ $val }}" @selected(($subtest->TestType ?? null) === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
