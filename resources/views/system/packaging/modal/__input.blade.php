@php $pk = $packaging ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="PackagingName" class="form-label">Packaging Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
            <input type="text" name="PackagingName" id="PackagingName" class="form-control" placeholder="Name" required value="{{ $pk?->PackagingName ?? '' }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="PackagingSource" class="form-label">Packaging Source</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-flag"></i></span>
            <input type="text" name="PackagingSource" id="PackagingSource" class="form-control" placeholder="Source" value="{{ $pk?->PackagingSource ?? '' }}">
        </div>
    </div>

    <div class="col-md-6">
        <label for="PackagingDMF" class="form-label">DMF</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-file-shield"></i></span>
            <input type="text" name="PackagingDMF" id="PackagingDMF" class="form-control" placeholder="DMF" value="{{ $pk?->PackagingDMF ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <label for="PackagingResin" class="form-label">Resin</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-droplet"></i></span>
            <input type="text" name="PackagingResin" id="PackagingResin" class="form-control" placeholder="Resin" value="{{ $pk?->PackagingResin ?? '' }}">
        </div>
    </div>

    <div class="col-md-6">
        <label for="PackagingColorant" class="form-label">Colorant</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-palette"></i></span>
            <input type="text" name="PackagingColorant" id="PackagingColorant" class="form-control" placeholder="Colorant" value="{{ $pk?->PackagingColorant ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <label for="PackagingLiner" class="form-label">Liner</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-layer-group"></i></span>
            <input type="text" name="PackagingLiner" id="PackagingLiner" class="form-control" placeholder="Liner" value="{{ $pk?->PackagingLiner ?? '' }}">
        </div>
    </div>
</div>
