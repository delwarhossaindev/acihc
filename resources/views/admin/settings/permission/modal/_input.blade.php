<div class="row">
    <div class="col mb-3">
      <label for="name" class="form-label">Name</label> <span style="color: red">*</span>
      <input type="text" name="name" id="name" class="form-control" placeholder="DashboardController@index" required value="{{ isset($permission) ? $permission->name : ''}}">
    </div>
  </div>
  <div class="row g-2">
    <div class="col mb-0">
      <label for="display_name" class="form-label">Display Name</label> <span style="color: red">*</span>
      <input type="text" name="display_name" id="display_name" class="form-control" placeholder="View Dashboard" required value="{{ isset($permission) ? $permission->display_name : ''}}">
    </div>
    <div class="col mb-0">
      <label for="description" class="form-label">Description</label> <span style="color: red">*</span>
      <input type="text" name="description" id="description" class="form-control" placeholder="Dashboard" required value="{{ isset($permission) ? $permission->description : ''}}">
    </div>
  </div>

  <button type="submit" class="btn btn-primary mt-3">Save changes</button>
