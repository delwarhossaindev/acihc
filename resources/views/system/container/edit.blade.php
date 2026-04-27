@extends('admin.layouts.master')

@section('content')

    <h4 class="fw-bold py-1 mb-3">Edit Container</h4>

    <x-alert.alert-component />

    <div class="card">
       <div class="card-body">
        <form 
        action="{{ route('container.update',$container->ContainerID) }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate
    >
    @csrf
    @method('patch')

   <div class="row">
        <div class="col mb-3">
        <label for="MarketName" class="form-label">Packaging Type</label> <span style="color: red">*</span>
        <input type="text" name="ContainerType" id="ContainerType" class="form-control" required value="{{ isset($container) ? $container->ContainerType : '' }}">
        <div class="invalid-tooltip">This field is required</div>
        </div>
    </div>
    
    <div class="row">
        <div class="col mb-3">
        <label for="MarketName" class="form-label">Packaging</label> <span style="color: red">*</span>

        <select class="select2 form-select form-select-lg select2-hidden-accessible" multiple="multiple"  name="packaging[]" required>
            @foreach (\App\Models\Packaging::all() as $item)
            <option value="{{$item->PackagingID}}" 
              @foreach ($container->packaging as $packaging)
                @if ($packaging->PackagingID == $item->PackagingID)
                {{'selected="selected"'}}
                @endif 
              @endforeach >
             {{ $item->PackagingName }} ({{ $item->PackagingSource }}) </option>               
           @endforeach    
        </select>
        <div class="invalid-tooltip">This field is required</div>
        </div>
    </div>

        <div class="fw-bold py-1 mt-3">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
       </div>
    </div>
@endsection
