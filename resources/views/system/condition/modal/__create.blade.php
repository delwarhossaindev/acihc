  <!--Create modal -->
  <div class="col-lg-4 col-md-6">
    <div class="mt-3">
      <!-- Modal -->
      <form 
        action="{{ route('condition.store') }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate
      >
        @csrf
        <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Create Condition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
              </div>
              <div class="modal-body">
               @includeIf('system.condition.modal.__input')
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--End Create modal -->