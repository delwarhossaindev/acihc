@extends('admin.layouts.master')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    Activity Log
</h4>

<div class="card">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered data-table text-center">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>IP Address</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>URL</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('log') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user', name: 'user.name'},
            {data: 'event', name: 'event'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'old_values', name: 'old_values'},
            {data: 'new_values', name: 'new_values'},
            {data: 'created_at', name: 'created_at'},
            {data: 'auditable_type', name: 'auditable_type'},
            {data: 'url', name: 'url'}
        ],
    });
  });
</script>
@endpush