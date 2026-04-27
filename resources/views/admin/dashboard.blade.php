@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
    @include('admin.summery')

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-4 mb-2">
        <h4 class="fw-bold mb-0 text-uppercase">
            <i class="bx bx-time-five text-primary me-1"></i>
            Current Month Withdrawal Board
        </h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-12 col-md-6 col-lg-5">
                    <p class="mb-0">
                        This month you have
                        <span class="badge bg-label-danger fs-6">{{ count($withdrawal_products) }}</span>
                        products to be withdrawn!
                    </p>
                </div>
                <div class="col-6 col-md-3 col-lg-3">
                    <label for="from_date" class="form-label small mb-1">From Date</label>
                    <input type="date" class="form-control form-control-sm" id="from_date" name="from_date"
                        value="{{ $from_date }}">
                </div>
                <div class="col-6 col-md-3 col-lg-3">
                    <label for="to_date" class="form-label small mb-1">To Date</label>
                    <input type="date" class="form-control form-control-sm" id="to_date" name="to_date"
                        value="{{ $to_date }}">
                </div>
                <div class="col-12 col-lg-1 d-grid">
                    <a href="#" id="exportBtn" class="btn btn-primary btn-sm">
                        <i class="bx bx-download me-1"></i>CSV
                    </a>
                </div>
            </div>

            <div class="table-responsive-wrapper">
                <table class="invoice-list-table table data-table border-top w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Condition</th>
                            <th>Batch No</th>
                            <th>SI Date</th>
                            <th>Withdrawal Date</th>
                            <th>Strength</th>
                            <th>Unit Pack</th>
                            <th>Status</th>
                            <th>Month</th>
                            <th>Withdraw By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <form action="{{ route('withdrawn.store') }}" method="post" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="batch_detail_id" id="batch_detail_id">
                <div class="modal fade" id="dynamicApprovalModal" tabindex="-1" aria-labelledby="modalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">
                                    <i class="bx bx-check-shield text-warning me-1"></i>
                                    Confirm Withdrawal
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Are you sure you want to withdraw this product? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-check me-1"></i>Confirm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('body').on('click', '.ajax-approval-modal-btn', function (e) {
            e.preventDefault();
            $('#batch_detail_id').val($(this).data('id'));
            $('#dynamicApprovalModal').modal('show');
        });

        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('dashboard') }}",
                    data: function (d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'ProductName', name: 'ProductName' },
                    { data: 'ConditionName', name: 'ConditionName' },
                    { data: 'BatchNo', name: 'BatchNo' },
                    { data: 'SIDate', name: 'SIDate' },
                    { data: 'WithdrawalDate', name: 'WithdrawalDate' },
                    { data: 'Strength', name: 'Strength' },
                    { data: 'PackID', name: 'PackID' },
                    { data: 'Status', name: 'Status' },
                    { data: 'Month', name: 'Month' },
                    { data: 'WithdrawalBy', name: 'WithdrawalBy' },
                    { data: 'action', name: 'action' },
                ]
            });

            $('#from_date, #to_date').change(function () {
                table.draw();
            });
        });

        $('#exportBtn').click(function (e) {
            e.preventDefault();
            const from_date = $('#from_date').val();
            const to_date = $('#to_date').val();
            const exportUrl = "{{ route('export.withdrawals') }}?from_date=" + from_date + "&to_date=" + to_date;
            window.location.href = exportUrl;
        });
    </script>
@endpush
