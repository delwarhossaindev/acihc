<div class="row g-3">
    <div class="col-12">
        <label for="ConditionName" class="form-label">Condition Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-cloud-sun"></i></span>
            <input type="text" name="ConditionName" id="ConditionName" class="form-control" placeholder="e.g. 25°C / 60% RH" required value="{{ $condition->ConditionName ?? '' }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>
</div>
