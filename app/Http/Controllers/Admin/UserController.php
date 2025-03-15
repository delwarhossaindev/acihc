<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreUserRequest as CreateUser;
use App\Http\Requests\UpdateUserRequest as UpdateUser;

class UserController extends Controller
{
    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            $data = $user->userList();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editLink = route('user.edit', $row->id);
                    $deleteLink = route('user.delete', $row->id);
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at ? Carbon::parse($user->created_at)->toDayDateTimeString() : null;
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return "<span class='badge bg-label-success'>Active</span>";
                    }
                    if ($data->status == 0) {
                        return "<span class='badge bg-label-warning'>Inactive</span>";
                    }
                })
                ->editColumn('name', function ($user) {
                    return '<span class="text-truncate d-flex align-items-center"><span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="bx bx-user bx-xs"></i></span>' . $user->name . '</span>';
                })
                ->escapeColumns('status', 'name')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.user.index');
    }

    public function store(User $user, CreateUser $request)
    {
        $user->storeUser($request);

        return $this->success('user', 'User created successfully!');
    }

    public function delete(User $user)
    {
        if ($user->id == '1') {
            return $this->error('user', 'You can not delete admin');
        }
        $user->delete();

        return $this->success('user', 'User deleted successfully!');
    }

    public function edit(User $user, Request $request)
    {
        $allRoles = Role::all();
        $user_role_data = DB::table('role_user')->where('user_id', $user->id)->get();
        $user_role       = [];

        foreach ($user_role_data as $r) {
            $user_role[$r->role_id] = 1;
        }

        return view('admin.user.modal._edit', compact('user', 'user_role', 'allRoles'))->render();
    }

    public function update(User $user, UpdateUser $request)
    {
        $user->updateUser($user, $request);

        return $this->success('user', 'User updated successfully!');
    }

    public function about()
    {
        return view('admin.user.about');
    }
}
