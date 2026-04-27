@extends('admin.layouts.master')

@section('content')

    <div class="row mt-3">
        <div class="col-md-2 mt-2">
            <h4 class="fw-bold">Role List</h4>
        </div>
        <div class="col-md 8"></div>
        <div class="col-md-2">
            <a class="button-create float-right" href="{{ route('role.create') }}">Create Role</a>
        </div>
    </div>
    <div class="alert alert-warning" role="alert">
        <h6 class="alert-heading fw-bold mb-2">Warning</h6>
        <p class="mb-0">A role provided access to predefined menus and features so that depending on <br> assigned role an
            administrator can have access to what user needs.</p>
    </div>

    <div class="row g-4 mb-3">
        @forelse ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-normal">Total {{ $role->users_count }} users</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @forelse ($role->users as $user)
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="" class="avatar avatar-sm pull-up"
                                        data-bs-original-title="{{ $user->name ?? '' }}">
                                        @if ($user->hasImage() && auth()->user()->image)
                                            <img class="rounded-circle" src="{{ auth()->user()->image->path }}"
                                                alt="Avatar">
                                        @else
                                            <img class="rounded-circle" src="{{ asset('admin/assets/img/avatars/1.png') }}"
                                                alt="Avatar">
                                        @endif
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="role-heading">
                                <h4 class="mb-1">{{ ucfirst($role->name) }} ({{ $role->permissions_count }})</h4>
                                <a href="{{ route('role.edit', $role->id) }}" class="role-edit-modal"><small>Edit
                                        Role</small></a>
                            </div>
                            <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="card-body text-sm-end text-center ps-sm-0">
                        <a href="{{ route('role.create') }}" class="btn btn-primary mb-4 text-nowrap add-new-role">Add New
                            Role</a>
                        <p class="mb-0">Add role, if it does not exist</p>
                    </div>
                </div>
            </div>
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
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('role') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'display_name',
                        name: 'display_name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
            });
        });
    </script>
@endpush
