  <!--Create modal -->
  <div class="col-lg-4 col-md-6">
    <div class="mt-3">
      <!-- Modal -->
      <form 
        action="{{ route('permission.update',$permission->id) }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate
      >
        @csrf
        @method('patch')
        <div class="modal fade" id="myDynamicEditModal" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="text-center mb-4">
                    <h3>Edit Permission</h3>
                    <p>Edit permission as per your requirements.</p>
                </div>
                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading fw-bold mb-2">Warning</h6>
                    <p class="mb-0">By editing the permission name, you might break the system permissions functionality. Please ensure you're absolutely certain before proceeding.</p>
                </div>
               @includeIf('admin.settings.permission.modal._input')
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--End Create modal -->