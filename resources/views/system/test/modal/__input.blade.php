   <div class="row">
        <div class="col mb-3">
            <label for="TestName" class="form-label">Test Name</label> <span style="color: red">*</span>
            <input type="text" name="TestName" id="TestName" class="form-control" required value="{{ isset($test) ? $test->TestName : '' }}">
            <div class="invalid-tooltip">This field is required and must be unique</div>
        </div>
        <div class="col mb-3">
            <label for="TestType" class="form-label">Test Type</label><span style="color: red">*</span>
            <select id="TestType" class="form-select custom-select" name="TestType" required>
                <option value="" selected disabled>Select type</option>
                <option value="text" {{ isset($test) ? $test->TestType == 'text' ? 'selected' : '' : '' }}>Text</option>
                <option value="date" {{ isset($test) ? $test->TestType == 'date' ? 'selected' : '' : '' }}>Date</option>
                <option value="percentage" {{ isset($test) ? $test->TestType == 'percentage' ? 'selected' : '' : '' }}>Percentage</option>
                <option value="min_max_avg" {{ isset($test) ? $test->TestType == 'min_max_avg' ? 'selected' : '' : '' }}>Min Max Avg</option>
            </select>
        </div>
   </div>
    @if(!isset($test))
   <div class="row">
        <div class="col mb-3">
            <div class="form-check form-switch mb-2 form-inline">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="hasParent"
                    value="1"
                >
                <label class="form-check-label">Save it as sub test</label>
            </div>
        </div>
   </div>
   @endif
   
   <div class="row" id="hidden-select-test" style="display: none">
       <div class="col mb-3">
            <label for="language" class="form-label">Parent Test</label>
            <select id="language" class="select2 form-select custom-select" name="parent">
                <option value="" selected disabled>Select Test</option>
                @foreach (\App\Models\Test::all() as $item)
                <option value="{{ $item->TestID }}">{{ $item->TestName }}</option>
                @endforeach
            </select>
            <div class="invalid-tooltip">This field is required</div>
        </div>
   </div>

    <button type="submit" class="btn btn-primary mt-2">Save changes</button>

