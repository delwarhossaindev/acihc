@extends('admin.layouts.master')

@push('style')
    <style>
        .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="row mt-3">
        <div class="col-md-4 mt-2">
            <h4 class="fw-bold">Sample Report</h4>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-2"></div>
    </div>

    <!-- Alert Component -->
    <x-alert.alert-component />

    <!-- Data Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="width: 100%;">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Sample Report No</th>
                            <th>Sample No</th>
                            <th>Product</th>
                            <th>Strength</th>
                            <th>Condition</th>
                            <th>Batch No</th>
                            <th>Unit Pack</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    </tbody>
                </table>
            </div>
            <!-- Modal 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="mt-3">
                    <form action="{{ route('approval.sample.store') }}" method="post" class="needs-validation" novalidate>
                        @csrf
                        @method('post')
                        <input type="hidden" name="sample_report_id" id="sample_id">
                        <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-labelledby="exampleModalLabel1"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel1">Sample Report Assignment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Review By (One) -->
                                            <div class="col-6">
                                                <label for="reviewByOne" class="form-label">Review By (One)</label>
                                                <select class="form-select" id="reviewByOne" name="ReviewBy[]" required>
                                                    <option value="" disabled selected>Select Review By</option>
                                                    @foreach (\App\Models\User::all() as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Review By (Two) -->
                                            <div class="col-6">
                                                <label for="reviewByTwo" class="form-label">Review By (Two)</label>
                                                <select class="form-select" id="reviewByTwo" name="ReviewBy[]" required>
                                                    <option value="" disabled selected>Select Review By</option>
                                                    @foreach (\App\Models\User::all() as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Approval By -->
                                            <div class="col-6 mt-2">
                                                <label for="approvalBy" class="form-label">Approval By</label>
                                                <select class="form-select" id="approvalBy" name="ApprovalBy" required>
                                                    <option value="" disabled selected>Select Approval By</option>
                                                    @foreach (\App\Models\User::all() as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
            <!-- Modal 1 -->
            <!-- Modal 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="mt-3">
                    <form action="{{ route('sample.approval.store',4) }}" method="post" class="needs-validation" novalidate>
                        @csrf
                        @method('post')
                        <input type="hidden" name="sample_report_id" id="sample_id">
                        <div class="modal fade" id="dynamicApprovalModal2" tabindex="-1"
                            aria-labelledby="exampleModalLabel1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel1">Sample Report Approval</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">


                                            <div class="col-12">
                                                <p>Name: &nbsp; &nbsp; Designation: </p>
                                                <label class="form-label">Comment Review (One) </label>
                                                <textarea id="commentOne" name="commentOne" class="form-control" rows="2"
                                                    placeholder="Comment Review One"></textarea>
                                            </div>
                                        
                                            <div class="col-12">
                                                <br>
                                                <hr>
                                                <p>Name: &nbsp; &nbsp; Designation: </p>
                                                <label class="form-label">Comment Review (Two) </label>
                                                <textarea id="commentTwo" name="commentTwo" class="form-control" rows="2"
                                                    placeholder="Comment Review Two"></textarea>
                                            </div>
                                          
                                            <div class="col-12">
                                                <br>
                                                <hr>
                                                <p>Name: &nbsp; &nbsp; Designation: </p>

                                                <label class="form-label">Approval Comment : </label>
                                                <textarea id="approvalComment" name="approvalComment" class="form-control"
                                                    rows="2" placeholder="Approval Comment"></textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label" >Approval</label>
                                                <select class="form-control custom-select" name="Approval" required>
                                                        <option value="Approved" >Approved</option>
                                                        <option value="Decline" >Decline</option>
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
            <!-- Modal 2 -->
        </div>
    </div>
@endsection

@push('script')
    <script>

        $('body').on('click', '.ajax-approval-modal-btn', function (e) {

            e.preventDefault();
            var id = $(this).data('id');

            $('#sample_id').val(id);
            $.ajax({
                url: "{{ route('sample.approval.details', '') }}/" + id,
                method: 'GET',
                success: function (response) {
                    $('#reviewByOne').val(response.reviewByOne).change();
                    $('#reviewByTwo').val(response.reviewByTwo).change();
                    $('#approvalBy').val(response.approvalBy).change();
                },
                error: function () {
                    alert('Failed to fetch sample details.');
                },
            });
            $('#dynamicApprovalModal').modal('show');

        });

        $('body').on('click', '.ajax-approval-modal-btn2', function (e) {

            e.preventDefault();
            var id = $(this).data('id');

            $('#sample_id').val(id);
            $.ajax({
                url: `/acihc/sample/${id}/approval-data`,
                method: 'GET',
                success: function (response) {
                    $('#reviewByOne').val(response.reviewByOne).change();
                    $('#reviewByTwo').val(response.reviewByTwo).change();
                    $('#approvalBy').val(response.approvalBy).change();
                },
                error: function () {
                    alert('Failed to fetch sample details.');
                },
            });
            $('#dynamicApprovalModal2').modal('show');

        });

        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                retrieve: true,
                paginate: true,
                responsive: true,
                autoWidth: false,
                deferRender: true,
                scrollX: true, 
                order: [[0, 'desc']],
                ajax: "{{ route('sample.report.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'SampleReportID', name: 'SampleReportID', orderable: false },
                    { data: 'SampleNo', name: 'SampleNo' },
                    { data: 'product', name: 'product', orderable: false },
                    { data: 'sku', name: 'sku' },
                    { data: 'condition', name: 'condition' },
                    { data: 'batch', name: 'batch', orderable: false },
                    { data: 'pack', name: 'pack' },
                    { data: 'status', name: 'status' },
                    { data: 'user', name: 'user' },
                    { data: 'action', name: 'action', orderable: false }
                ]
            });
        });
    </script>
@endpush