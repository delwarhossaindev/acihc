<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Role $role, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($role->getRole())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('RoleController@edit') ? route('role.edit', $row->id) : null;
                    $deleteLink = $authUser?->hasPermission('RoleController@delete') ? route('role.delete', $row->id) : null;
                    return getDynamicButtonLink($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.settings.role.index', ['roles' => Role::all()]);
    }

    public function create(Permission $permission)
    {
        return view('admin.settings.role.create', [
            'permissions' => $permission->getPermission(),
        ]);
    }

    public function store(Role $role, StoreRoleRequest $request)
    {
        $role->saveRole($request);

        return $this->success('role', 'Role created successfully!');
    }

    public function edit(Role $role, Permission $permission)
    {
        $role_permission = userRolePermissions($role->id)
            ->pluck('permission_id')
            ->mapWithKeys(fn ($id) => [$id => 1])
            ->toArray();

        return view('admin.settings.role.edit', [
            'permissions'     => $permission->getPermission(),
            'role'            => $role,
            'role_permission' => $role_permission,
        ]);
    }

    public function update(Role $role, EditRoleRequest $request)
    {
        $role->updateRole($role, $request);

        return $this->success('role', 'Role updated successfully!');
    }

    public function delete(Role $role)
    {
        $role->delete();

        return $this->success('role', 'Role deleted successfully!');
    }
}
