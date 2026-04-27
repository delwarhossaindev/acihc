@extends('admin.layouts.master')

@push('style')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<style>
    /* ===== Protocol edit — modern UI ===== */
    .protocol-progress {
        height: 8px;
        border-radius: 999px;
        background: #eef2f7;
        overflow: hidden;
    }
    .protocol-progress > .bar {
        height: 100%;
        background: linear-gradient(90deg, #696cff, #03c3ec);
        transition: width 0.6s ease;
    }
    .protocol-progress-label {
        font-size: 0.85rem;
        color: #697a8d;
    }

    /* Step navigator (vertical pills) */
    .step-nav { padding: 0; margin: 0; list-style: none; }
    .step-nav .step-item { margin-bottom: 6px; }
    .step-nav .step-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        background: #fff;
        color: #566a7f;
        border: 1px solid transparent;
        cursor: pointer;
        width: 100%;
        text-align: left;
        font-size: 0.92rem;
        transition: all 0.2s ease;
    }
    .step-nav .step-link:hover {
        background: #f4f5fb;
        border-color: #e7e9f6;
        transform: translateX(2px);
    }
    .step-nav .step-link.active {
        background: linear-gradient(90deg, #696cff, #5d5fef);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 14px -2px rgba(105,108,255,0.5);
    }
    .step-nav .step-link.active .step-num,
    .step-nav .step-link.active .step-status {
        color: #fff;
    }
    .step-nav .step-num {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f4f5fb;
        color: #696cff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .step-nav .step-link.active .step-num {
        background: rgba(255,255,255,0.25);
    }
    .step-nav .step-label { flex: 1; }
    .step-nav .step-status { font-size: 1rem; }
    .step-nav .step-status.done { color: #71dd37; }
    .step-nav .step-link.active .step-status.done { color: #d3ffe0; }
    .step-nav .step-status.pending { color: #d9dee3; }

    /* Tab content polish */
    .tab-content > .tab-pane {
        animation: fadeSlide 0.3s ease;
    }
    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Section header inside forms */
    .form-section-head {
        border-bottom: 1px solid #eef2f7;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
    }
    .form-section-head h6 {
        margin: 0;
        font-weight: 600;
        color: #566a7f;
    }
    .form-section-head .desc {
        font-size: 0.85rem;
        color: #a1aab3;
        margin-top: 2px;
    }

    /* Sticky save bar */
    .form-sticky-save {
        position: sticky;
        bottom: 0;
        z-index: 10;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(8px);
        border-top: 1px solid #eef2f7;
        padding: 12px 16px;
        margin: 16px -1.5rem -1.5rem;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    /* Inputs polish */
    .form-control, .form-select {
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(105,108,255,0.18);
    }
    .input-group-text {
        background: #f4f5fb;
        border-color: #d9dee3;
        color: #696cff;
    }

    /* Card hover lift */
    .card.lift {
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .card.lift:hover {
        box-shadow: 0 6px 24px -8px rgba(105,108,255,0.18);
    }
</style>
@endpush

@php
    $sectionMeta = [
        'home'     => ['icon' => 'fa-file-lines',  'label' => 'Protocol',           'done' => true],
        'api'      => ['icon' => 'fa-vial',        'label' => 'API Details',        'done' => $protocol->apis->isNotEmpty()],
        'profile'  => ['icon' => 'fa-box',         'label' => 'Product',            'done' => $protocol->protocolProductDetails->isNotEmpty()],
        'messages' => ['icon' => 'fa-cubes',       'label' => 'Packaging Materials','done' => $protocol->sku->isNotEmpty()],
        'sms'      => ['icon' => 'fa-layer-group', 'label' => 'Packaging Profile',  'done' => $protocol->packagings->isNotEmpty()],
        'batch'    => ['icon' => 'fa-flask',       'label' => 'Batch Details',      'done' => $protocol->protocolBatch->isNotEmpty()],
        'rifat'    => ['icon' => 'fa-temperature-half', 'label' => 'Stability Study','done' => $protocol->statbilityStudy->isNotEmpty()],
        'zamil'    => ['icon' => 'fa-flask-vial',  'label' => 'Test',               'done' => $protocol->tests->isNotEmpty()],
        'chamber'  => ['icon' => 'fa-table-cells', 'label' => 'Stability Design',   'done' => $protocol->protocolSkuUnitPack->isNotEmpty()],
        'approval' => ['icon' => 'fa-user-check',  'label' => 'Approval',           'done' => $protocol->approvalSteps->isNotEmpty()],
    ];
    $totalSteps    = count($sectionMeta);
    $doneSteps     = collect($sectionMeta)->where('done', true)->count();
    $progressPct   = (int) round(($doneSteps / $totalSteps) * 100);
@endphp

@section('content')
    <x-alert.alert-component />

    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('protocol') }}">Protocol</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Protocol #{{ $protocol->ProtocolID }}</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-1">Edit Protocol</h4>
            <span class="text-muted small">STB/PROT/{{ sprintf('%04d', $protocol->ProtocolID) }}</span>
        </div>
        <a href="{{ route('protocol') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card lift mb-3">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-semibold">Completion</span>
                <span class="protocol-progress-label"><strong>{{ $doneSteps }}</strong> of {{ $totalSteps }} sections — {{ $progressPct }}%</span>
            </div>
            <div class="protocol-progress">
                <div class="bar" style="width: {{ $progressPct }}%;"></div>
            </div>
        </div>
    </div>

    <div class="card lift">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <ul class="step-nav nav flex-column" role="tablist">
                        @foreach ($sectionMeta as $key => $meta)
                            <li class="step-item nav-item" role="presentation">
                                <button type="button"
                                        class="step-link nav-link {{ $loop->first ? 'active' : '' }}"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-left-{{ $key }}"
                                        role="tab"
                                        aria-controls="navs-pills-left-{{ $key }}">
                                    <span class="step-num">{{ $loop->iteration }}</span>
                                    <i class="fa {{ $meta['icon'] }}"></i>
                                    <span class="step-label">{{ $meta['label'] }}</span>
                                    <span class="step-status {{ $meta['done'] ? 'done' : 'pending' }}">
                                        @if ($meta['done'])
                                            <i class="fa fa-circle-check"></i>
                                        @else
                                            <i class="fa fa-circle" style="font-size: 0.5rem;"></i>
                                        @endif
                                    </span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-md-9">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-pills-left-home" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Protocol Basics</h6>
                                <div class="desc">Title, scope, product, market, manufacturer, and key narrative fields.</div>
                            </div>
                            <form action="{{ route('protocol.update', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.protocol_edit')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-api" role="tabpanel">
                            <div class="form-section-head">
                                <h6>API Details</h6>
                                <div class="desc">Active pharmaceutical ingredients used in this protocol — batch, lot, and expiry.</div>
                            </div>
                            <form action="{{ route('protocol.api.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.api_detail')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-profile" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Product Details</h6>
                                <div class="desc">Strength-wise specification number and STP number.</div>
                            </div>
                            <form action="{{ route('protocol.product.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.protocol_product')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-messages" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Packaging Materials</h6>
                                <div class="desc">Strength → Pack → Container Type mapping.</div>
                            </div>
                            <form action="{{ route('protocol.container.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.packaging_materials')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-sms" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Packaging Profile</h6>
                                <div class="desc">Primary, secondary, and tertiary packaging configuration.</div>
                            </div>
                            <form action="{{ route('protocol.packaging.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.protocol_packaging_profile')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-batch" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Batch Details</h6>
                                <div class="desc">Batches generated for this protocol.</div>
                            </div>
                            <form action="{{ route('protocol.batch.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.batch')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-rifat" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Stability Study</h6>
                                <div class="desc">Study type and storage condition combinations.</div>
                            </div>
                            <form action="{{ route('protocol.stability.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.protocol_stability_study')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-zamil" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Tests</h6>
                                <div class="desc">Test parameters and unit-per-test mapping per strength.</div>
                            </div>
                            <form action="{{ route('protocol.test.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.protocol_test')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-chamber" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Stability Design</h6>
                                <div class="desc">Chamber design — months, additional samples, and placebo design.</div>
                            </div>
                            <form action="{{ route('protocol.chamber.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.stability_design')
                            </form>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-left-approval" role="tabpanel">
                            <div class="form-section-head">
                                <h6>Review &amp; Approval</h6>
                                <div class="desc">Reviewer chain and approver decision.</div>
                            </div>
                            <form action="{{ route('protocol.approval.store', $protocol->ProtocolID) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @include('system.protocol.input.approval')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('reason.store') }}" method="post" class="needs-validation" novalidate>
        @csrf
        <input type="hidden" name="ProtocolID" value="{{ $protocol->ProtocolID }}">
        <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reason for Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="ReasonID" class="form-label">Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="ReasonID" name="Reason" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    if (document.querySelector('#Responsibilities')) {
        ClassicEditor.create(document.querySelector('#Responsibilities')).catch(error => console.error(error));
    }
    if (document.querySelector('#note')) {
        ClassicEditor.create(document.querySelector('#note')).catch(error => console.error(error));
    }

    // Bootstrap 5 client-side validation
    document.querySelectorAll('form.needs-validation').forEach(form => {
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                // Scroll to first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({behavior: 'smooth', block: 'center'});
                    firstInvalid.focus();
                }
            }
            form.classList.add('was-validated');
        }, false);

        // Live validation on blur
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', () => {
                if (field.value.trim() !== '' || field.classList.contains('is-invalid')) {
                    field.classList.toggle('is-invalid', !field.checkValidity());
                    field.classList.toggle('is-valid', field.checkValidity() && field.value.trim() !== '');
                }
            });
        });
    });
});
</script>
@endpush
