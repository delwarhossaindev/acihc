@extends('admin.layouts.master')

@section('content')
<h4 class="fw-bold py-3 mb-2">Update Password</h4>
    <div class="alert alert-warning" role="alert">
        <h6 class="alert-heading fw-bold mb-2">Warning</h6>
        <p class="mb-0">By editing the app settings name, you might break the system system functionality. Please ensure you're absolutely certain before proceeding.</p>
    </div>
    <x-alert.alert-component />
    <div class="card">
        <div class="card-body">
            <form 
            action="{{ route('update.password') }}" 
            method="post" 
            class="needs-validation" 
            role="form"
            novalidate
        >
        @csrf
        <div class="row">
            <div class="col mb-3">
                <label for="nameBasic" class="form-label">Previous Password</label>
                <input 
                    type="text" 
                    name="old_password" 
                    class="form-control" 
                    placeholder="Previous password"
                    required 
                >
                <div class="invalid-tooltip">This field is required</div>
            </div>
            <div class="col mb-3">
            <label for="nameBasic" class="form-label">New Password</label>
            <input 
                type="text" 
                name="new_password" 
                class="form-control" 
                placeholder="New password"
                required 
            >
            <div class="invalid-tooltip">This field is required</div>
        </div>
        <div class="col mb-3">
            <label for="nameBasic" class="form-label">Old Password</label>
            <input 
                type="text" 
                name="password_confirmation" 
                class="form-control" 
                placeholder="Confirm password"
                required 
            >
            <div class="invalid-tooltip">This field is required</div>
        </div>
        </div> 
    
        <div class="fw-bold py-1 mt-3">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
@endsection