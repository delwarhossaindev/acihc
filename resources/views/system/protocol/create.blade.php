@extends('admin.layouts.master')

@push('style')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<style>
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
    .form-control, .form-select {
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(105,108,255,0.18);
    }
    .card.lift {
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .card.lift:hover {
        box-shadow: 0 6px 24px -8px rgba(105,108,255,0.18);
    }
    .step-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        background: linear-gradient(90deg, #696cff, #5d5fef);
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
    <x-alert.alert-component />

    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('protocol') }}">Protocol</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Protocol</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Protocol</h4>
            <span class="step-pill"><i class="fa fa-rocket"></i> Step 1 of 10 — Protocol Basics</span>
        </div>
        <a href="{{ route('protocol') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="alert alert-info d-flex align-items-start" role="alert">
        <i class="fa fa-info-circle me-2 mt-1"></i>
        <div>
            <strong>Quick start.</strong> Fill in the basics here to create a draft. After saving you'll be able to add
            <span class="text-primary">API details, product, packaging, batches, stability study, tests, design, and approvers</span>.
        </div>
    </div>

    <div class="card lift">
        <div class="card-header bg-transparent border-bottom">
            <div class="form-section-head" style="border: none; margin: 0; padding: 0;">
                <h6><i class="fa fa-file-lines me-2 text-primary"></i> Protocol Details</h6>
                <div class="desc">Required fields are marked with <span class="text-danger">*</span>.</div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('protocol.store') }}" method="post" class="needs-validation" role="form" novalidate>
                @csrf
                @include('system.protocol.input.protocol_create')
            </form>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/froala_editor.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/froala_editor.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/js/plugins.pkgd.min.js"></script>
<script>
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
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({behavior: 'smooth', block: 'center'});
                    firstInvalid.focus();
                }
            }
            form.classList.add('was-validated');
        }, false);

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
