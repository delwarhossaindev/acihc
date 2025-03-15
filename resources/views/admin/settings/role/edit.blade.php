@extends('admin.layouts.master')

@section('content')

    <h4 class="fw-bold py-1 mb-3">Update Role</h4>
    <x-alert.alert-component />
    <div class="card">
       <div class="card-body">
        <form 
        action="{{ route('role.update',$role->id) }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate
    >
    @csrf
    @method('patch')
        
    <div class="row">
        <div class="col mb-3">
        <label for="nameBasic" class="form-label">Name</label>
        <input type="text" name="name" id="nameBasic" class="form-control" placeholder="Enter Name" required value="{{ $role->name }}">
        {{-- <div class="valid-tooltip">Looks good!</div> --}}
        <div class="invalid-tooltip">Please choose a unique and valid role name.</div>
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-0">
        <label for="emailBasic" class="form-label">Display Name</label>
        <input type="text" name="display_name" id="emailBasic" class="form-control" placeholder="Display Name" required value="{{ $role->display_name }}">
        {{-- <div class="valid-tooltip">Looks good!</div> --}}
        <div class="invalid-tooltip">Please choose a unique and valid display name.</div>
        </div>
        <div class="col mb-0">
        <label for="dobBasic" class="form-label">Description</label>
        <input type="text" name="description" id="dobBasic" class="form-control" placeholder="Description" required value="{{ $role->description }}">
        {{-- <div class="valid-tooltip">Looks good!</div> --}}
        <div class="invalid-tooltip">Please choose a description for this role.</div>
        </div>
    </div>
    
    <hr>
    
    @php  $previous_permission = "";  @endphp

    <div class="">
        <input
            type="checkbox"
            id="selectAll"
            class="form-check-input"
        />
        <label class="checkboxSuccess1" for="selectAll" id="replace">Select All</label>
    </div>
    <div class="form-inline">
        @foreach ($permissions as $permission)
            @if($previous_permission != $permission->description)
                <div class="col mb-0" style="margin-top:10px;">
                    <input
                        type="checkbox"
                        class="form-check-input {{ lcfirst($permission->description) }}"
                        value="{{$permission->id}}"
                        onClick="selectPermission('{{ lcfirst($permission->description) }}')"
                    />
                    <label for="emailBasic" class="form-label">{{ ucfirst($permission->description) }}</label>
                </div>
            @endif
                <div class="form-check form-switch mb-2 form-inline">
                    <input 
                        class="form-check-input" 
                        id="{{ lcfirst($permission->description) }}"
                        type="checkbox" 
                        id="{{$permission->id}}"
                        name="permissions[]"
                        value="{{$permission->id}}"
                        @php if(isset($role_permission[$permission->id]) && $role_permission[$permission->id]) { @endphp checked @php } 
                        @endphp
                    >
                    <label class="form-check-label" for="{{$permission->id}}">{{$permission->display_name}}</label>
                </div>
                @php
                    $previous_permission = $permission->description;
                    $check = isset( $permissions[$loop->index +1]->description) ? $permissions[$loop->index +1]->description : "-";
                @endphp
                @if($previous_permission != $check || $check == '-')@endif
            @endforeach
        </div>
        <div class="fw-bold py-1 mt-3">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
       </div>
    </div>
@endsection
