<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="Title">Title <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-heading"></i></span>
            <input type="text" id="Title" name="Title" class="form-control" placeholder="Protocol title" required>
            <div class="invalid-feedback">Title is required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Purpose">Purpose <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-bullseye"></i></span>
            <input type="text" id="Purpose" name="Purpose" class="form-control" placeholder="Purpose of this protocol" required>
            <div class="invalid-feedback">Purpose is required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Reference">Reference <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-link"></i></span>
            <input type="text" id="Reference" name="Reference" class="form-control" placeholder="Reference document" required>
            <div class="invalid-feedback">Reference is required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="FooterSectionNo">Footer Section No <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
            <input type="text" id="FooterSectionNo" name="FooterSectionNo" class="form-control" placeholder="Footer section number" required>
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>

    <div class="col-md-3">
        <label class="form-label" for="ExhibitBatch">Exhibit Batch <span class="text-danger">*</span></label>
        <select class="form-select" id="ExhibitBatch" name="ExhibitBatch" required>
            <option value="" disabled selected>Select…</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
        <div class="invalid-feedback">Choose one.</div>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="CommercialValidationBatch">Commercial Validation <span class="text-danger">*</span></label>
        <select class="form-select" id="CommercialValidationBatch" name="CommercialValidationBatch" required>
            <option value="" disabled selected>Select…</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
        <div class="invalid-feedback">Choose one.</div>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="AnnualStability">Annual Stability <span class="text-danger">*</span></label>
        <select class="form-select" id="AnnualStability" name="AnnualStability" required>
            <option value="" disabled selected>Select…</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
        <div class="invalid-feedback">Choose one.</div>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="Other">Other <span class="text-danger">*</span></label>
        <select class="form-select" id="Other" name="Other" required>
            <option value="" disabled selected>Select…</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
            <option value="Source Change">Source Change</option>
            <option value="From CAPA Task">From CAPA Task</option>
            <option value="Packaging Materials Change">Packaging Materials Change</option>
            <option value="RAW Material Change">RAW Material Change</option>
            <option value="Manufacturing Process Change">Manufacturing Process Change</option>
        </select>
        <div class="invalid-feedback">Choose one.</div>
    </div>

    <div class="col-12">
        <label class="form-label" for="Responsibilities">
            <i class="fa fa-users-gear me-1 text-primary"></i> Responsibilities <span class="text-danger">*</span>
        </label>
        <textarea id="Responsibilities" name="Responsibilities" class="form-control" rows="2" placeholder="Who is responsible for what" required></textarea>
    </div>

    <div class="col-12">
        <label class="form-label" for="ProductID">
            <i class="fa fa-box me-1 text-primary"></i> Product <span class="text-danger">*</span>
        </label>
        <select class="select2 form-select" id="ProductID" name="ProductID" required>
            <option value="" disabled selected>Select Product</option>
            @foreach (\App\Models\Product::all() as $item)
                @php
                    $strengths = $item->details->pluck('ProductStrength')->filter()->implode(', ');
                    $packs     = $item->packs->pluck('PackValue')->filter()->implode(', ');
                @endphp
                <option value="{{ $item->ProductID }}">
                    {{ $item->ProductName }}@if ($strengths) ({{ $strengths }})@endif @if ($packs) | Packs: {{ $packs }}@endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="MarketID">
            <i class="fa fa-globe me-1 text-primary"></i> Market <span class="text-danger">*</span>
        </label>
        <select class="form-select" id="MarketID" name="MarketID" required>
            <option value="" disabled selected>Select Market</option>
            @foreach (\App\Models\Market::all() as $item)
                <option value="{{ $item->MarketID }}">{{ $item->MarketName }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="ManufacturerID">
            <i class="fa fa-industry me-1 text-primary"></i> Manufacturer <span class="text-danger">*</span>
        </label>
        <select class="form-select" id="ManufacturerID" name="ManufacturerID" required>
            <option value="" disabled selected>Select Manufacturer</option>
            @foreach (\App\Models\Manufacturer::all() as $item)
                <option value="{{ $item->ManufacturerID }}">{{ $item->ManufacturerName }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label" for="AnalysisReport">
            <i class="fa fa-clipboard-list me-1 text-primary"></i>
            Stability Specifications and Analysis Report <span class="text-danger">*</span>
        </label>
        <textarea rows="6" id="AnalysisReport" name="AnalysisReport" class="form-control" placeholder="Specifications and analysis methods" required></textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Reporting">
            <i class="fa fa-chart-line me-1 text-primary"></i> Reporting <span class="text-danger">*</span>
        </label>
        <textarea id="Reporting" name="Reporting" class="form-control" rows="3" placeholder="Reporting frequency and format" required></textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Conclusion">
            <i class="fa fa-flag-checkered me-1 text-primary"></i> Conclusion <span class="text-danger">*</span>
        </label>
        <textarea id="Conclusion" name="Conclusion" class="form-control" rows="3" placeholder="Expected conclusion" required></textarea>
    </div>
    <div class="col-12">
        <label class="form-label" for="RevisionHistory">
            <i class="fa fa-clock-rotate-left me-1 text-primary"></i> Revision History <span class="text-danger">*</span>
        </label>
        <textarea id="RevisionHistory" name="RevisionHistory" class="form-control" rows="2" placeholder="Initial version" required></textarea>
    </div>
    <div class="col-12">
        <label class="form-label" for="note">
            <i class="fa fa-note-sticky me-1 text-primary"></i> Note
        </label>
        <textarea id="note" name="Note" class="form-control" rows="2" placeholder="Optional notes"></textarea>
    </div>

    <div class="form-sticky-save">
        <button type="reset" class="btn btn-outline-secondary">
            <i class="fa fa-rotate-left"></i> Reset
        </button>
        <button type="submit" class="btn btn-primary">
            Create Protocol &amp; Continue <i class="fa fa-arrow-right ms-1"></i>
        </button>
    </div>
</div>
