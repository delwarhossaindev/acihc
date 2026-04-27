<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest as CreateUser;
use App\Http\Requests\UpdateUserRequest as UpdateUser;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of(User::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('UserController@edit') ? route('user.edit', $row->id) : null;
                    $deleteLink = $authUser?->hasPermission('UserController@delete') ? route('user.delete', $row->id) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->editColumn('created_at', fn ($user) => $user->created_at ? Carbon::parse($user->created_at)->toDayDateTimeString() : null)
                ->editColumn('status', fn ($data) => match ((int) $data->status) {
                    1       => "<span class='badge bg-label-success'>Active</span>",
                    0       => "<span class='badge bg-label-warning'>Inactive</span>",
                    default => '',
                })
                ->editColumn('name', fn ($user) => '<span class="text-truncate d-flex align-items-center"><span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="bx bx-user bx-xs"></i></span>' . e($user->name) . '</span>')
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
        if ($user->id == 1) {
            return $this->error('user', 'You can not delete admin');
        }

        $user->delete();

        return $this->success('user', 'User deleted successfully!');
    }

    public function edit(User $user, Request $request)
    {
        $allRoles = Role::all();

        $user_role = DB::table('role_user')
            ->where('user_id', $user->id)
            ->pluck('role_id')
            ->mapWithKeys(fn ($id) => [$id => 1])
            ->toArray();

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
