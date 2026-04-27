@extends('admin.layouts.master')

@section('content')
<h4 class="fw-bold py-1 mb-3">Create Batch</h4>
<x-alert.alert-component />
<div class="card">
    <div class="card-body">
        <form action="{{ route('batch.store') }}" method="post" class="needs-validation" role="form" novalidate>
            @csrf
            <div class="row" style="background:#e0fafa;">
                <div class="col-md-3 mb-3">
                    <label for="BatchName" class="form-label">Batch Type</label> <span style="color: red">*</span>
                    <input type="text" name="BatchName" id="BatchName" class="form-control" placeholder="Enter Batchtype" required value="{{ old('BatchName', $batch->BatchName ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="BatchNo" class="form-label">Batch No</label> <span style="color: red">*</span>
                    <input type="text" name="BatchNo" id="BatchNo" class="form-control" placeholder="Enter BatchNo" required value="{{ old('BatchNo', $batch->BatchNo ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="BatchSize" class="form-label">Batch Size</label> <span style="color: red">*</span>
                    <input type="text" name="BatchSize" id="BatchSize" class="form-control" placeholder="Enter BatchSize" required value="{{ old('BatchSize', $batch->BatchSize ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="DescriptionOfPack" class="form-label">Description of Pack</label> <span style="color: red">*</span>
                    <input type="text" name="DescriptionOfPack" id="DescriptionOfPack" class="form-control" placeholder="Enter Description of pack" required value="{{ old('DescriptionOfPack', $batch->DescriptionOfPack ?? '') }}">
                </div>

                <div class="col mb-3">
                    <label for="MfgDate" class="form-label">Mfg Date</label>
                    <input type="month" name="MfgDate" id="MfgDate" class="form-control" required value="{{ old('MfgDate', isset($batch) ? date('Y-m', strtotime($batch->MfgDate)) : '') }}">
                </div>
                <div class="col mb-3">
                    <label for="ExpDate" class="form-label">Exp Date</label>
                    <input type="month" name="ExpDate" id="ExpDate" class="form-control" required value="{{ old('ExpDate', isset($batch) ? date('Y-m', strtotime($batch->ExpDate)) : '') }}">
                </div>
                <div class="col mb-3">
                    <label for="SIDate" class="form-label">SI Date</label>
                    <input type="date" name="SIDate" id="SIDate" class="form-control" required value="{{ old('SIDate', $SIDate ?? ($batch->SIDate ?? '')) }}">
                </div>

                <div class="col mb-3">
                    <label for="ProtocolID" class="form-label">Protocol</label> <span style="color: red">*</span>
                    <select class="select2 form-select" name="ProtocolID" id="ProtocolID" required>
                        <option value="">Select Protocol</option>
                        @foreach ($protocols as $protocol)
                            <option value="{{ $protocol->ProtocolID }}" {{ old('ProtocolID') == $protocol->ProtocolID ? 'selected' : '' }}>
                                {{ $protocol->Title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col mb-3">
                    <label for="SkuID" class="form-label">Strength</label> <span style="color: red">*</span>
                    <select class="form-control" name="SkuID" id="SkuID" required>
                        <option value="">Select Strength</option>
                    </select>
                </div>
                <div class="col mb-3">
                    <label for="PackID" class="form-label">Unit Pack</label> <span style="color: red">*</span>
                    <select class="form-select" name="PackID" id="PackID" required>
                        <option value="">Unit Pack</option>
                    </select>
                </div>

            </div>


            <div id="withdrawal-container" style="height: 500px; width: auto; overflow-y: scroll;">
                <div class="row withdrawal-row">

                     <div class="col mb-3">
                        <label for="Condition" class="form-label">Storage Condition</label> <span style="color: red">*</span>
                        <select class="form-select Condition" name="Condition[]" required>
                              <option value="">Select Condition</option>
                            @foreach ($condition as $cond)
                                <option value="{{ $cond->ConditionID }}">{{ $cond->ConditionName }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="Month" class="form-label">Month</label> <span style="color: red">*</span>
                        <select class="form-select Month" name="Month[]" required>
                            <option value="">Select Month</option>
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label for="WithdrawalDate" class="form-label">Withdraw Date</label>
                        <input type="date" name="WithdrawalDate[]" class="form-control WithdrawalDate" placeholder="Enter Withdraw Date" required>
                    </div>
                    <div class="col-auto d-flex align-items-end mb-3">
                        <button type="button" class="btn btn-success add-withdrawal">+</button>
                    </div>
                </div>
            </div>


            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save changes</button>

            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function () {
    let cachedMonths = [];

    $('#ProtocolID').on('change', function () {
        let ProtocolID = $(this).val();
        $.ajax({
            url: "{{ route('ajax.get.product') }}",
            type: "GET",
            data: { ProtocolID: ProtocolID },
            success: function (data) {
                cachedMonths = data.months || [];

                $('#SkuID').empty().append('<option value="">Select Strength</option>');
                $.each(data.skus, function (i, sku) {
                    $('#SkuID').append(`<option value="${sku.SkuID}">${sku.ProductStrength}</option>`);
                });

                $('#PackID').empty().append('<option value="">Unit Pack</option>');
                $.each(data.packs, function (i, pack) {
                    $('#PackID').append(`<option value="${pack.PackValue}">${pack.PackValue}</option>`);
                });

                populateMonthDropdowns();
            }
        });
    });

    function populateMonthDropdowns() {
        $('.Month').each(function () {
            let selected = $(this).val();
            $(this).empty().append('<option value="">Select Month</option>');
            $.each(cachedMonths, function (i, month) {
                $(this).append(`<option value="${month}" ${month == selected ? 'selected' : ''}>${month}</option>`);
            }.bind(this));
        });
    }

    $(document).on('click', '.add-withdrawal', function () {
        let row = $(this).closest('.withdrawal-row');
        let newRow = row.clone();
        newRow.find('input, select').val('');
        newRow.find('.add-withdrawal')
            .removeClass('btn-success add-withdrawal')
            .addClass('btn-danger remove-withdrawal')
            .text('-');
        $('#withdrawal-container').append(newRow);
        populateMonthDropdowns();
    });

    $(document).on('click', '.remove-withdrawal', function () {
        $(this).closest('.withdrawal-row').remove();
    });

    $(document).on('change', '.Month', function () {
        let monthCount = parseInt($(this).val());
        let sidate = $('#SIDate').val();
        let $withdrawDateInput = $(this).closest('.withdrawal-row').find('.WithdrawalDate');

        if (!sidate) {
            alert('Please select SI Date first!');
            $(this).val('');
            return;
        }

        let date = new Date(sidate);
        date.setMonth(date.getMonth() + monthCount);
        let formattedDate = date.toISOString().split('T')[0];
        $withdrawDateInput.val(formattedDate);
    });
});
</script>
@endpush
