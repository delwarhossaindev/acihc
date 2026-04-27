<div class="row g-3">
    <div class="col-md-6">
        <label for="TestName" class="form-label">Test Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-flask"></i></span>
            <input type="text" name="TestName" id="TestName" class="form-control" placeholder="e.g. Assay" required value="{{ $test->TestName ?? '' }}">
            <div class="invalid-feedback">Required and must be unique.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="TestType" class="form-label">Test Type <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-list"></i></span>
            <select id="TestType" class="form-select" name="TestType" required>
                <option value="" selected disabled>Select type</option>
                @foreach (['text' => 'Text', 'date' => 'Date', 'percentage' => 'Percentage', 'min_max_avg' => 'Min Max Avg'] as $val => $label)
                    <option value="{{ $val }}" @selected(($test->TestType ?? null) === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (! isset($test))
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="hasParent" id="hasParent" value="1">
                <label class="form-check-label" for="hasParent">Save as a sub test under a parent test</label>
            </div>
        </div>
    @endif

    <div class="col-12" id="hidden-select-test" style="display: none;">
        <label for="parentTest" class="form-label">Parent Test</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-sitemap"></i></span>
            <select id="parentTest" class="select2 form-select" name="parent">
                <option value="" selected disabled>Select Parent Test</option>
                @foreach (\App\Models\Test::all() as $item)
                    <option value="{{ $item->TestID }}">{{ $item->TestName }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
