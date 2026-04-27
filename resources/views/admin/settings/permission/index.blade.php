@extends('admin.layouts.master')

@section('content')

<div class="row mt-3">
  <div class="col-md-2 mt-2">
    <h4 class="fw-bold">Permission</h4>
  </div>
  <div class="col-md 8"></div>
  <div class="col-md-2">
    <a class="button-create float-right" data-bs-target="#basicModal" data-backdrop="static" data-keyboard="false" data-bs-toggle="modal" >Create New</a>
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
              <th>Name</th>
              <th>Display Name</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @include('admin.settings.permission.modal._create')
  <div class="edit-modal"></div>
    
@endsection

@push('script')
<script>
    $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('permission') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ],
    });
  });
</script>
@endpush