@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Protocol List</h4>
        </div>
        <div class="col-md 8"></div>
        <div class="col-md-2">
            <a class="button-create float-right" href="{{ route('protocol.create') }}">Create New</a>
        </div>
    </div>

    <x-alert.alert-component />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Protocol Title</th>
                            <th>Protocol No</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>

    @php $allUsers = \App\Models\User::orderBy('name')->get(['id', 'name']); @endphp

    <!-- Modal -->
    <div class="col-lg-4 col-md-6">
        <div class="mt-3">
            <form action="{{ route('approval.protocal.store') }}" method="post" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="protocol_id" id="protocol_id">

                <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Protocol Approval</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Reviewers</label>
                                    <div id="reviewerList"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addReviewerBtn">
                                        + Add Reviewer
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <label for="approvalBy" class="form-label fw-semibold">Approval By</label>
                                    <select class="form-select" id="approvalBy" name="ApprovalBy" required>
                                        <option value="" disabled selected>Select Approval By</option>
                                        @foreach ($allUsers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <template id="reviewerRowTemplate">
        <div class="input-group mb-2 reviewer-row">
            <select class="form-select reviewer-select" name="ReviewBy[]" required>
                <option value="" disabled selected>Select Reviewer</option>
                @foreach ($allUsers as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-danger remove-reviewer">&times;</button>
        </div>
    </template>
    <!-- Modal -->

        </div>
    </div>


@endsection

@push('script')
    <script>
    function addReviewerRow(selectedId) {
        var $tpl = $($('#reviewerRowTemplate').html());
        if (selectedId) {
            $tpl.find('.reviewer-select').val(selectedId);
        }
        $('#reviewerList').append($tpl);
    }

    $('#addReviewerBtn').on('click', function() {
        addReviewerRow(null);
    });

    $('#reviewerList').on('click', '.remove-reviewer', function() {
        if ($('#reviewerList .reviewer-row').length > 1) {
            $(this).closest('.reviewer-row').remove();
        } else {
            $(this).closest('.reviewer-row').find('.reviewer-select').val('');
        }
    });

    $('body').on('click', '.ajax-approval-modal-btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#protocol_id').val(id);
        $('#reviewerList').empty();

        $.ajax({
            url: `/protocol/${id}/approval-details`,
            method: 'GET',
            success: function(response) {
                var reviewers = (response.reviewers && response.reviewers.length) ? response.reviewers : [null, null];
                reviewers.forEach(function(uid) { addReviewerRow(uid); });
                $('#approvalBy').val(response.approver || '').change();
            },
            error: function() {
                addReviewerRow(null);
                addReviewerRow(null);
                alert('Failed to fetch protocol details.');
            },
        });

        $('#dynamicApprovalModal').modal('show');
    });

        $(function() {
            var table = $('.data-table').DataTable({
                "processing": true,
                "retrieve": true,
                "serverSide": true,
                'paginate': true,
                'searchDelay': 700,
                "bDeferRender": true,
                "responsive": true,
                "autoWidth": false,
                 "order": [
                    [0, 'desc']
                ],
                ajax: "{{ route('protocol') }}",
                columns: [
                    {
                         data: 'ProtocolID',
                         name: 'ProtocolID'
                    },
                    {
                        data: 'Title',
                        name: 'Title'
                    },
                    {
                        data: 'protocolNo',
                        name: 'protocolNo'
                    },
                    {
                        data: 'product',
                        name: 'product.ProductName',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },
                    {
                        data: 'user',
                        name: 'user.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'updatedby',
                        name: 'updatedby.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endpush
