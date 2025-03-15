<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{
    public function index(Role $role, Request $request)
    {
        $roles = Role::all();
        if ($request->ajax()) {
            $data = $role->getRole();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editLink = route('role.edit', $row->id);
                    $deleteLink = route('role.delete', $row->id);
                    return getDynamicButtonLink($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.settings.role.index', ['roles' => $roles]);
    }

    public function create(Permission $permission)
    {
        $permissions = $permission->getPermission();

        return view('admin.settings.role.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Role $role, StoreRoleRequest $request)
    {
        $role->saveRole($request);

        return $this->success('role', 'Role created successfully!');
    }

    public function edit(Role $role, Permission $permission)
    {
        $permissions  = $permission->getPermission();
        $userRolePermissions = userRolePermissions($role->id);

        $role_permission       = [];

        foreach ($userRolePermissions as $r) {
            $role_permission[$r->permission_id] = 1;
        }

        return view('admin.settings.role.edit', [
            'permissions' => $permissions,
            'role' => $role,
            'role_permission' => $role_permission
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
