<form action="{{ route('manufacturer.update', $manufacturer->ManufacturerID) }}" method="post" class="needs-validation" novalidate>
    @csrf
    @method('patch')
    <div class="modal fade" id="myDynamicEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="modal-icon-badge"><i class="fa fa-industry"></i></span>
                        Update Manufacturer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('system.manufacturer.modal.__input')
                </div>
                <div class="modal-footer-clean">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check me-1"></i> Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
