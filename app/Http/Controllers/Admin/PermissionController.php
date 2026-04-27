<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UpdatePermissionRequest as UpdateRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Permission $permission, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($permission->getPermission())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('PermissionController@edit') ? route('permission.edit', $row->id) : null;
                    $deleteLink = $authUser?->hasPermission('PermissionController@delete') ? route('permission.delete', $row->id) : null;
                    return getDynamicButtonLinkForModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.settings.permission.index');
    }

    public function store(Permission $permission, PermissionRequest $request)
    {
        $permission->savePermission($request);

        return $this->success('permission', 'Permission created successfully!');
    }

    public function edit(Permission $permission)
    {
        return view('admin.settings.permission.modal._edit', compact('permission'))->render();
    }

    public function update(Permission $permission, UpdateRequest $request)
    {
        $permission->updatePerssion($permission, $request);

        return $this->success('permission', 'Permission updated successfully!');
    }

    public function delete(Permission $permission)
    {
        $permission->delete();

        return $this->success('permission', 'Permission deleted successfully!');
    }
}
