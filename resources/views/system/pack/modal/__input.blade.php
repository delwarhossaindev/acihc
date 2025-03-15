@if(isset($pack))
  <div class="row">
      <div class="col mb-3">
        <label for="PackValue" class="form-label">Pack Value</label> <span style="color: red">*</span>
        <input type="text" name="PackValue" id="PackValue" class="form-control" placeholder="Manufacturer Name" required value="{{ isset($pack) ? $pack->PackValue : '' }}">
      </div>
</div>
@endif

@if(! isset($pack))
<div class="row">
  <div class="form-group">
      <label for="PackValue" class="form-label">Pack Value</label> <span style="color: red">*</span>
      <div class="row input_div">
        <div class="col-md-9">
          <input type="text" name="PackValue[]" id="PackValue" class="form-control" required>
        </div>
        <div class="col-md-3">
          <button class="button-create btn-add-more" type="button" style="font-size: 11px;"></i>Add More</button>
        </div>
      </div>
  </div>
</div>
   
<div class="row">
  <div class="clone" style="display: none;">
    <div class="control-group input-group form-group select_date">
      <div class="row mt-3 remove_row">
        <div class="col-md-9">
          <input type="text" name="PackValue[]" id="PackValue" class="form-control">
        </div>
        <div class="col-md-3">
          <button class="button-create btn-remove" type="button" style="font-size: 11px;background:darkred !important;">Remove</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<button type="submit" class="btn btn-primary mt-2">Save changes</button>

