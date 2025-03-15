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
                            <th>Serial</th>
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

     <!-- Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form
            action="{{ route('approval.protocal.store') }}"
            method="post"
            class="needs-validation"
            novalidate
        >
            @csrf
            @method('post') <!-- Use PATCH if your route expects PATCH -->
            <input type="hidden" name="protocol_id" id="protocol_id">
            <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Protocol Approval</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Review By (One) -->
                                <div class="col-6">
                                    <label for="reviewByOne" class="form-label">Review By (One)</label>
                                    <select class="form-select" id="reviewByOne" name="ReviewBy[]" required>
                                        <option value="" disabled selected>Select Review By</option>
                                        @foreach (\App\Models\User::all() as $item)
                                            <option value="{{ $item->id }}"  >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Review By (Two) -->
                                <div class="col-6">
                                    <label for="reviewByTwo" class="form-label">Review By (Two)</label>
                                    <select class="form-select" id="reviewByTwo" name="ReviewBy[]" required>
                                        <option value="" disabled selected>Select Review By</option>
                                        @foreach (\App\Models\User::all() as $item)
                                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Approval By -->
                                <div class="col-6 mt-2">
                                    <label for="approvalBy" class="form-label">Approval By</label>
                                    <select class="form-select" id="approvalBy" name="ApprovalBy" required>
                                        <option value="" disabled selected>Select Approval By</option>
                                        @foreach (\App\Models\User::all() as $item)
                                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->

        </div>
    </div>


@endsection

@push('script')
    <script>
    $('body').on('click', '.ajax-approval-modal-btn', function(e) {

        e.preventDefault();
        var id = $(this).data('id');

        $('#protocol_id').val(id);
        $.ajax({
        url: `/acihc/protocol/${id}/approval-details`, 
        method: 'GET',
        success: function (response) {
            $('#reviewByOne').val(response.reviewByOne).change();
            $('#reviewByTwo').val(response.reviewByTwo).change();
            $('#approvalBy').val(response.approvalBy).change();
        },
        error: function () {
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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
