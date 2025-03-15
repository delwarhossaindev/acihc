<div class="row">
    <div class="col mb-3">
        <label for="MarketName" class="form-label">Market Name</label> <span style="color: red">*</span>
        <input type="text" name="MarketName" id="MarketName" class="form-control" placeholder="Manufacturer Name" required value="{{ isset($market) ? $market->MarketName : '' }}">
    </div>
</div>

<button type="submit" class="btn btn-primary mt-2">Save changes</button>