<div class="row">
  <div class="col mb-3">
    <label for="name" class="form-label">Name<span class="text-danger"> *</span></label>
    <input 
      type="text" 
      name="name" 
      id="name" 
      class="form-control" 
      placeholder="Name" 
      required 
      value="{{ isset($user) ? $user->name : old('name') }}">
  </div>
</div>

<div class="row">
  <div class="col-6">
    <label for="staff_id" class="form-label">Staff ID<span class="text-danger"> *</span></label>
    <input 
      type="text" 
      name="staff_id" 
      id="staff_id" 
      class="form-control" 
      placeholder="Staff ID" 
      required 
      value="{{ isset($user) ? $user->staff_id : old('staff_id') }}">
  </div>
  <div class="col-6">
    <label for="designation" class="form-label">Designation<span class="text-danger"> *</span></label>
    <input 
      type="text" 
      name="designation" 
      id="designation" 
      class="form-control" 
      placeholder="Designation" 
      required 
      value="{{ isset($user) ? $user->designation : old('designation') }}">
  </div>
</div>

<div class="row g-2">
  <div class="col mb-0">
    <label for="email" class="form-label">Email<span class="text-danger"> *</span></label>
    <input 
      type="email" 
      name="email" 
      id="email" 
      class="form-control" 
      placeholder="Email" 
      required 
      value="{{ isset($user) ? $user->email : old('email') }}">
  </div>
  @if(!isset($user))
    <div class="col mb-0">
      <label for="password" class="form-label">Password<span class="text-danger"> *</span></label>
      <input 
        type="password" 
        name="password" 
        id="password" 
        class="form-control" 
        placeholder="Password" 
        required>
    </div>
  @endif
</div>

<div class="col mt-3">
  <div class="form-check form-switch mb-2">
    <input 
      class="form-check-input" 
      type="checkbox" 
      name="status" 
      id="status" 
      value="1" 
      {{ isset($user) && $user->status == 1 ? 'checked' : '' }}>
    <label for="status" class="form-check-label">Set as an active user</label>
  </div>
</div>

<hr>
<h5>Select Role</h5>
<div class="form-inline d-flex flex-wrap">
  @foreach (\App\Models\Role::all() as $role)
    <div class="col mb-2" style="margin-top: 10px;">
      <div class="form-check form-switch">
        <input 
          class="form-check-input" 
          type="checkbox" 
          name="roles[]" 
          value="{{ $role->id }}" 
          id="role_{{ $role->id }}" 
          {{ isset($user_role[$role->id]) && $user_role[$role->id] ? 'checked' : '' }}>
        <label for="role_{{ $role->id }}" class="form-check-label">{{ $role->display_name }}</label>
      </div>
    </div>
  @endforeach
</div>

<button type="submit" class="btn btn-primary mt-3">Save changes</button>
