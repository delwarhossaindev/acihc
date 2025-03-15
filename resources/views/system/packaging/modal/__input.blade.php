<div class="row">
    <div class="col mb-3">
        <label for="PackagingName" class="form-label">Packaging Name</label> <span style="color: red">*</span>
        <input type="text" name="PackagingName" id="PackagingName" class="form-control" required value="{{ isset($packaging) ? $packaging->PackagingName : '' }}" placeholder="Name">
    </div>
    <div class="col mb-3">
        <label for="MarketName" class="form-label">Packaging Source</label>
        <input type="text" name="PackagingSource" id="PackagingSource" class="form-control" value="{{ isset($packaging) ? $packaging->PackagingSource : '' }}" placeholder="Source">
    </div>
</div>

<div class="row">
    <div class="col mb-3">
        <label for="PackagingDMF" class="form-label">Packaging DMF</label>
        <input type="text" name="PackagingDMF" id="PackagingDMF" class="form-control" value="{{ isset($packaging) ? $packaging->PackagingDMF : '' }}" placeholder="DMF">
    </div>
    <div class="col mb-3">
        <label for="PackagingResin" class="form-label">Packaging Resin</label>
        <input type="text" name="PackagingResin" id="PackagingResin" class="form-control" value="{{ isset($packaging) ? $packaging->PackagingResin : '' }}" placeholder="Resin">
    </div>
</div>

<div class="row">
    <div class="col mb-3">
        <label for="PackagingColorant" class="form-label">Packaging Colorant</label>
        <input type="text" name="PackagingColorant" id="PackagingColorant" class="form-control" value="{{ isset($packaging) ? $packaging->PackagingColorant : '' }}" placeholder="Colorant">
    </div>
    <div class="col mb-3">
        <label for="PackagingLiner" class="form-label">Packaging Liner</label>
        <input type="text" name="PackagingLiner" id="PackagingLiner" class="form-control" value="{{ isset($packaging) ? $packaging->PackagingLiner : '' }}" placeholder="Liner">
    </div>
</div>

<button type="submit" class="btn btn-primary mt-2">Save changes</button>
