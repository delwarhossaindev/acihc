<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdatePermissionRequest as UpdateRequest;

class PermissionController extends Controller
{   
    
    public function index(Permission $permission, Request $request)
    {   
        if ($request->ajax()) {
            $data = $permission->getPermission();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $editLink = route('permission.edit',$row->id);
                        $deleteLink = route('permission.delete',$row->id);
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

        return $this->success('permission','Permission created successfully!');
    }
    
    public function edit(Permission $permission)
    {   
        return view('admin.settings.permission.modal._edit',compact('permission'))->render();
    }

    public function update(Permission $permission, UpdateRequest $request)
    {  
        $permission->updatePerssion($permission, $request);

        return $this->success('permission','Permission updated successfully!');
    }

    public function delete(Permission $permission)
    {
        $permission->delete();

        return $this->success('permission','Permission deleted successfully!');
    }
}
