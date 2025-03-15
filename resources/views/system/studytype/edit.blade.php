@extends('admin.layouts.master')

@push('style')
<link rel="stylesheet" href="{{ asset('css/tagify/tagify.css') }}"/>
@endpush

@section('content')

    <h4 class="fw-bold py-1 mb-3">Update Study Type</h4>

    <x-alert.alert-component />

    <div class="card">
       <div class="card-body">
        <form 
        action="{{ route('studytype.update',$studytype->StudyTypeID) }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate
    >
    @csrf
    @method('patch')
    
    <div class="row">
        <div class="col mb-3">
            <label for="StudyTypeName" class="form-label">Study Type Name</label> <span style="color: red">*</span>
            <input type="text" name="StudyTypeName" id="StudyTypeName" class="form-control" placeholder="Accelerated" required value="{{ $studytype->StudyTypeName }}">
            <div class="invalid-tooltip">This field is required</div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="ProductStrength" class="form-label">Stability Study Month</label> <span style="color: red">*</span>
            <input name="StudyTypeMonth" placeholder="Enter value and press enter" value="@if(isset($studytype->details)) {{ json_encode($previousStudyMonth,TRUE) }} @endif" required class="form-control"> 
            <div class="invalid-tooltip">This field is required</div>
        </div>
    </div>

        <button type="submit" class="btn btn-primary">Save changes</button>

       </div>
    </div>
@endsection

@push('script')
<script src="{{ asset('js/tagify/jQuery.tagify.min.js') }}"></script>
<script>
    $(function () {
        var input = document.querySelector('input[name=StudyTypeMonth]'),
        tagify =new Tagify( input )
    });
</script>
@endpush
