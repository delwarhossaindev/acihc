@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <p class="mb-0">{{ session()->get('message') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <p class="mb-0">{{ session()->get('error') }}</p>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
  </button>
</div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible" role="alert">
    <p class="mb-0">{!! implode('<br/>', $errors->all()) !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
    </p>
  </div>
@endif
