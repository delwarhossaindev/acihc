<div class="row g-3">
    <div class="col-12">
        <label for="MarketName" class="form-label">Market Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-globe"></i></span>
            <input type="text" name="MarketName" id="MarketName" class="form-control" placeholder="e.g. Bangladesh, USA, EU" required value="{{ $market->MarketName ?? '' }}">
            <div class="invalid-feedback">Market name is required.</div>
        </div>
    </div>
</div>
