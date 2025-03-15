@extends('admin.layouts.master')

@push('style')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
@endpush

@section('content')
    <x-alert.alert-component />

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('protocol') }}">Protocol</a></span>/Create Protocol
    </h4>

    <div class="card">
       <div class="card-body">
        <div class="col-xl-12">
          <h6 class="text-muted">Create Protocol</h6>
          <div class="nav-align-left mb-4">
            <ul class="nav nav-pills me-3" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-left-home" aria-controls="navs-pills-left-home" aria-selected="true">Protocol</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-left-api" aria-controls="navs-pills-left-api" aria-selected="false">API Details</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-left-profile" aria-controls="navs-pills-left-profile" aria-selected="false">Product</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-messages" aria-controls="navs-pills-left-messages" aria-selected="false">Packaging Materials</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-sms" aria-controls="navs-pills-left-sms" aria-selected="false">Packaging Profile</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-batch" aria-controls="navs-pills-left-batch" aria-selected="false">Batch Details</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-rifat" aria-controls="navs-pills-left-rifat" aria-selected="false">Stability Study</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-zamil" aria-controls="navs-pills-left-zamil" aria-selected="false">Test</button>
              </li>
              <hr>
              <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-chamber" aria-controls="navs-pills-left-chamber" aria-selected="false">Stability Design</button>
              </li>
              <hr>
              @php
              if(isset($protocol)){

              $ApprovalExists = \App\Models\ProtocolApprovalTree::where('ProtocolID', $protocol->ProtocolID)
                                 ->where('UserID', auth()->id())
                                 ->exists();

              if(auth()->id()==1){
                $ApprovalExists = true;
              }

                 }
              @endphp

              @if(isset($protocol))
              <li class="nav-item">
                <button type="button" class="nav-link"  role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-approval" aria-controls="navs-pills-left-approval" aria-selected="false">Approval</button>
              </li>
              <hr>
              @endif
              {{-- <li class="nav-item">
                <button type="button" class="nav-link @if(! isset($protocol))
                {{ 'disabled' }}
                @endif" role="tab" data-bs-toggle="tab"
                data-bs-toggle="tab" data-bs-target="#navs-pills-left-placebo" aria-controls="navs-pills-left-placebo" aria-selected="false">Placebo</button>
              </li> --}}
          </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-pills-left-home" role="tabpanel">
                <form
                  @if(isset($protocol))
                  action="{{ route('protocol.update',$protocol->ProtocolID) }}"
                  @else
                  action="{{ route('protocol.store') }}"
                  @endif
                  method="post"
                  class="needs-validation"
                  role="form"
                  novalidate
                >
                  @csrf
                  @includeIf('system.protocol.input.protocol')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-api" role="tabpanel">
                <form
                  @if(isset($protocol))
                  action="{{ route('protocol.api.store',$protocol->ProtocolID) }}"
                  @endif
                  method="post"
                  class="needs-validation"
                  role="form"
                  novalidate
                >
                  @csrf
                  @includeIf('system.protocol.input.api_detail')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-profile" role="tabpanel">
                <form
                    @if(isset($protocol))
                    action="{{ route('protocol.product.store',$protocol->ProtocolID) }}"
                    @endif
                    method="post"
                    class="needs-validation"
                    role="form"
                    novalidate
                  >
                  @csrf
                  @includeIf('system.protocol.input.protocol_product')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-messages" role="tabpanel">
                <form
                  @if(isset($protocol))
                  action="{{ route('protocol.container.store',$protocol->ProtocolID) }}"
                  @endif
                    method="post"
                    class="needs-validation"
                    role="form"
                    novalidate
                  >
                  @csrf
                  @includeIf('system.protocol.input.packaging_materials')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-sms" role="tabpanel">
                <form
                  @if(isset($protocol))
                  action="{{ route('protocol.packaging.store',$protocol->ProtocolID) }}"
                  @endif
                    method="post"
                    class="needs-validation"
                    role="form"
                    novalidate
                  >
                  @csrf
                  @includeIf('system.protocol.input.protocol_packaging_profile')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-batch" role="tabpanel">
                <form
                  @if(isset($protocol))
                  action="{{ route('protocol.batch.store',$protocol->ProtocolID) }}"
                  @endif
                    method="post"
                    class="needs-validation"
                    role="form"
                    novalidate
                  >
                  @csrf
                  @include('system.protocol.input.batch')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-rifat" role="tabpanel">
                  <form
                    @if(isset($protocol))
                    action="{{ route('protocol.stability.store',$protocol->ProtocolID) }}"
                    @endif
                      method="post"
                      class="needs-validation"
                      role="form"
                      novalidate
                    >
                    @csrf
                    @includeIf('system.protocol.input.protocol_stability_study')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-zamil" role="tabpanel">
                <form
                    @if(isset($protocol))
                    action="{{ route('protocol.test.store',$protocol->ProtocolID) }}"
                    @endif
                      method="post"
                      class="needs-validation"
                      role="form"
                      novalidate
                    >
                    @csrf
                    @includeIf('system.protocol.input.protocol_test')
                </form>
              </div>
              <div class="tab-pane fade" id="navs-pills-left-chamber" role="tabpanel">
                <form
                    @if(isset($protocol))
                    action="{{ route('protocol.chamber.store',$protocol->ProtocolID) }}"
                    @endif
                      method="post"
                      class="needs-validation"
                      role="form"
                      novalidate
                    >
                    @csrf
                    @includeIf('system.protocol.input.stability_design')
                </form>
              </div>


              <div class="tab-pane fade" id="navs-pills-left-approval" role="tabpanel">
                <form
                    @if(isset($protocol) && $ApprovalExists)
                    action="{{ route('protocol.approval.store',$protocol->ProtocolID) }}"
                    @endif
                      method="post"
                      class="needs-validation"
                      role="form"
                      novalidate
                    >
                    @csrf
                    @includeIf('system.protocol.input.approval')
                </form>
              </div>

              {{-- <div class="tab-pane fade" id="navs-pills-left-placebo" role="tabpanel">
                <form
                    @if(isset($protocol))
                    action="{{ route('protocol.placebo.store',$protocol->ProtocolID) }}"
                    @endif
                      method="post"
                      class="needs-validation"
                      role="form"
                      novalidate
                    >
                    @csrf
                    @includeIf('system.protocol.input.placebo')
                </form>
              </div> --}}
            </div>
          </div>
        </div>

        <!-- Modal -->
         @if (isset($protocol))


    <div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form
            action="{{ route('reason.store') }}"
            method="post"
            class="needs-validation"
            novalidate
        >
            @csrf
            <input type="hidden" name="ProtocolID" value="{{ $protocol->ProtocolID }}" id="ProtocolID">

            <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="ReasonID" class="form-label">Reason</label>
                                    <textarea class="form-control" id="ReasonID" name="Reason" required></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Modal -->
      </div>
  </div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/froala_editor.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/froala_editor.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/plugins.pkgd.min.js"></script>
<script>

$('body').on('click', '.ajax-approval-modal-btn', function(e) {

e.preventDefault();

$('#dynamicApprovalModal').modal('show');

});



    $(document).ready(function() {

        ClassicEditor
            .create( document.querySelector( '#Responsibilities' ) )
            .catch( error => {
                console.error( error );
            } );
        ClassicEditor
            .create( document.querySelector( '#Scope' ) )
            .catch( error => {
                console.error( error );
            } );

        ClassicEditor
            .create( document.querySelector( '#note' ) )
            .catch( error => {
                console.error( error );
            } );
    });
</script>
@endpush
