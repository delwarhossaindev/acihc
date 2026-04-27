@if (isset($pack))
    <div class="row g-3">
        <div class="col-12">
            <label for="PackValue" class="form-label">Pack Value <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-cube"></i></span>
                <input type="text" name="PackValue" id="PackValue" class="form-control" placeholder="e.g. 10 tablets" required value="{{ $pack->PackValue }}">
            </div>
        </div>
    </div>
@else
    <div class="row g-3">
        <div class="col-12">
            <label class="form-label">Pack Value <span class="text-danger">*</span></label>
            <div class="row input_div g-2">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-cube"></i></span>
                        <input type="text" name="PackValue[]" class="form-control" placeholder="e.g. 10 tablets" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-primary btn-add-more w-100" type="button">
                        <i class="fa fa-plus"></i> Add More
                    </button>
                </div>
            </div>
            <div class="form-text">Use "Add More" to enter several pack values at once.</div>
        </div>
    </div>

    <div class="clone" style="display: none;">
        <div class="select_date">
            <div class="row mt-2 remove_row g-2">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-cube"></i></span>
                        <input type="text" name="PackValue[]" class="form-control" placeholder="e.g. 10 tablets">
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-danger btn-remove w-100" type="button">
                        <i class="fa fa-xmark"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
