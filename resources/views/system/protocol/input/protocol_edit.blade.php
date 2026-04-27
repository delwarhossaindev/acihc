<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="Title">Title <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-heading"></i></span>
            <input type="text" id="Title" name="Title" class="form-control" placeholder="Protocol title" required value="{{ $protocol->Title }}">
            <div class="invalid-feedback">Title is required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Purpose">Purpose <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-bullseye"></i></span>
            <input type="text" id="Purpose" name="Purpose" class="form-control" placeholder="Purpose of this protocol" required value="{{ $protocol->Purpose }}">
            <div class="invalid-feedback">Purpose is required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Reference">Reference <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-link"></i></span>
            <input type="text" id="Reference" name="Reference" class="form-control" placeholder="Reference document" required value="{{ $protocol->Reference }}">
            <div class="invalid-feedback">Reference is required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="FooterSectionNo">Footer Section No <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
            <input type="text" id="FooterSectionNo" name="FooterSectionNo" class="form-control" placeholder="Footer section number" required value="{{ $protocol->FooterSectionNo }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>

    <div class="col-md-3">
        <label class="form-label" for="ExhibitBatch">Exhibit Batch <span class="text-danger">*</span></label>
        <select class="form-select" id="ExhibitBatch" name="ExhibitBatch" required>
            <option value="Y" @selected($protocol->ExhibitBatch === 'Y')>Yes</option>
            <option value="N" @selected($protocol->ExhibitBatch === 'N')>No</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="CommercialValidationBatch">Commercial Validation <span class="text-danger">*</span></label>
        <select class="form-select" id="CommercialValidationBatch" name="CommercialValidationBatch" required>
            <option value="Y" @selected($protocol->CommercialValidationBatch === 'Y')>Yes</option>
            <option value="N" @selected($protocol->CommercialValidationBatch === 'N')>No</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="AnnualStability">Annual Stability <span class="text-danger">*</span></label>
        <select class="form-select" id="AnnualStability" name="AnnualStability" required>
            <option value="Y" @selected($protocol->AnnualStability === 'Y')>Yes</option>
            <option value="N" @selected($protocol->AnnualStability === 'N')>No</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="Other">Other <span class="text-danger">*</span></label>
        <select class="form-select" id="Other" name="Other" required>
            @foreach (['Y' => 'Yes', 'N' => 'No', 'Source Change' => 'Source Change', 'From CAPA Task' => 'From CAPA Task', 'Packaging Materials Change' => 'Packaging Materials Change', 'RAW Material Change' => 'RAW Material Change', 'Manufacturing Process Change' => 'Manufacturing Process Change'] as $val => $label)
                <option value="{{ $val }}" @selected($protocol->Other === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label" for="Responsibilities">
            <i class="fa fa-users-gear me-1 text-primary"></i> Responsibilities <span class="text-danger">*</span>
        </label>
        <textarea id="Responsibilities" name="Responsibilities" class="form-control" rows="2" required>{{ $protocol->Responsibilities }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label" for="ProductID">
            <i class="fa fa-box me-1 text-primary"></i> Product <span class="text-danger">*</span>
        </label>
        <select class="select2 form-select" id="ProductID" name="ProductID" required>
            @foreach (\App\Models\Product::all() as $item)
                @php
                    $strengths = $item->details->pluck('ProductStrength')->filter()->implode(', ');
                    $packs     = $item->packs->pluck('PackValue')->filter()->implode(', ');
                @endphp
                <option value="{{ $item->ProductID }}" @selected($protocol->ProductID == $item->ProductID)>
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
            @foreach (\App\Models\Market::all() as $item)
                <option value="{{ $item->MarketID }}" @selected($protocol->MarketID == $item->MarketID)>{{ $item->MarketName }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="ManufacturerID">
            <i class="fa fa-industry me-1 text-primary"></i> Manufacturer <span class="text-danger">*</span>
        </label>
        <select class="form-select" id="ManufacturerID" name="ManufacturerID" required>
            @foreach (\App\Models\Manufacturer::all() as $item)
                <option value="{{ $item->ManufacturerID }}" @selected($protocol->ManufacturerID == $item->ManufacturerID)>{{ $item->ManufacturerName }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label" for="AnalysisReport">
            <i class="fa fa-clipboard-list me-1 text-primary"></i>
            Stability Specifications and Analysis Report <span class="text-danger">*</span>
        </label>
        <textarea rows="6" id="AnalysisReport" name="AnalysisReport" class="form-control" required>{{ $protocol->AnalysisReport }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Reporting">
            <i class="fa fa-chart-line me-1 text-primary"></i> Reporting <span class="text-danger">*</span>
        </label>
        <textarea id="Reporting" name="Reporting" class="form-control" rows="3" required>{{ $protocol->Reporting }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="Conclusion">
            <i class="fa fa-flag-checkered me-1 text-primary"></i> Conclusion <span class="text-danger">*</span>
        </label>
        <textarea id="Conclusion" name="Conclusion" class="form-control" rows="3" required>{{ $protocol->Conclusion }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label" for="RevisionHistory">
            <i class="fa fa-clock-rotate-left me-1 text-primary"></i> Revision History <span class="text-danger">*</span>
        </label>
        <textarea id="RevisionHistory" name="RevisionHistory" class="form-control" rows="2" required>{{ $protocol->RevisionHistory }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label" for="note">
            <i class="fa fa-note-sticky me-1 text-primary"></i> Note
        </label>
        <textarea id="note" name="Note" class="form-control" rows="2">{{ $protocol->Note }}</textarea>
    </div>

    <div class="form-sticky-save">
        @if ($protocol->ProtocolStatusID == 4 && $protocol->ProtocolID != 10)
            <button type="button" class="btn btn-primary ajax-approval-modal-btn">
                <i class="fa fa-floppy-disk me-1"></i> Save changes
            </button>
        @else
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-floppy-disk me-1"></i> Save changes
            </button>
        @endif
    </div>
</div>
