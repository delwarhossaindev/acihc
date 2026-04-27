<div class="row g-3">
    <div class="col-12">
        <label for="ApiDetailName" class="form-label">API Detail Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-vial"></i></span>
            <input type="text" name="ApiDetailName" id="ApiDetailName" class="form-control" placeholder="e.g. Paracetamol" required value="{{ $apiDetail->ApiDetailName ?? '' }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>
    <div class="col-12">
        <label for="APIDetailSource" class="form-label">API Source <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-flag"></i></span>
            <input type="text" name="APIDetailSource" id="APIDetailSource" class="form-control" placeholder="e.g. India, China" required value="{{ $apiDetail->APIDetailSource ?? '' }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>
</div>
