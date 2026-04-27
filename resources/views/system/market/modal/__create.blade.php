<form action="{{ route('market.store') }}" method="post" class="needs-validation" novalidate>
    @csrf
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="modal-icon-badge"><i class="fa fa-globe"></i></span>
                        Create Market
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @includeIf('system.market.modal.__input')
                </div>
                <div class="modal-footer-clean">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check me-1"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
