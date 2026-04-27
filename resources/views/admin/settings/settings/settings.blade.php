@extends('admin.layouts.master')

@section('content')
<h4 class="fw-bold py-3 mb-2">System Settings</h4>
<div class="alert alert-warning" role="alert">
    <h6 class="alert-heading fw-bold mb-2">Warning</h6>
    <p class="mb-0">By editing the app settings name, you might break the system system functionality. Please ensure you're absolutely certain before proceeding.</p>
</div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card">
                    <div class="card-body">
                     <form 
                     action="{{ route('settings') }}" 
                     method="post" 
                     class="needs-validation" 
                     role="form"
                     novalidate
                 >
                 @csrf
                 @method('patch')
                 @forelse($settings as $setting)
                 <div class="row">
                     <div class="col mb-3">
                         <label for="nameBasic" class="form-label">{{ $setting->display_name }}</label>
                         <input 
                             type="text" 
                             name="key[{{ $setting->key }}]" 
                             class="form-control" 
                             value="{{ $setting->value }}"
                             placeholder="{{ $setting->display_name }}"
                             required 
                         >
                         <div class="invalid-tooltip">This field {{ strtolower($setting->display_name) }} is required</div>
                     </div>
                 </div> 
                 @empty
                 <p>No settings found!</p>
                 @endforelse
                 <div class="fw-bold py-1 mt-3">
                     <button type="submit" class="btn btn-primary">Save changes</button>
                 </div>
                 </div>
             </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Clear System Cache</h5>
                <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-success">
                    <p class="mb-0">Once you clear your system cache, your application performance performance will be optimized!.</p>
                    </div>
                </div>
                    <a href="{{ route('cache') }}" class="btn btn-danger deactivate-account">Clear</a>
                </div>
            </div> 
        </div>
    </div>
@endsection