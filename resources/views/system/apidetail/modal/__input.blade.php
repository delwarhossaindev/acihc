<div class="row">
    <div class="col mb-3">
        <label for="ApiDetailName" class="form-label">Api Detail Name</label> <span style="color: red">*</span>
        <input type="text" name="ApiDetailName" id="ApiDetailName" class="form-control" placeholder="Enter api detail" required value="{{ isset($apiDetail) ? $apiDetail->ApiDetailName : '' }}">
    </div>
</div>

<div class="row">
    <div class="col mb-3">
        <label for="APIDetailSource" class="form-label">Api Detail Source</label> <span style="color: red">*</span>
        <input type="text" name="APIDetailSource" id="APIDetailSource" class="form-control" placeholder="Enter source" required value="{{ isset($apiDetail) ? $apiDetail->APIDetailSource : '' }}">
    </div>
</div>

<button type="submit" class="btn btn-primary mt-2">Save changes</button>
