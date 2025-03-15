<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laratrust\Models\LaratrustRole;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel implements Auditable
{
    use AuditableTrait;

    public $guarded = [];

    protected $table = 'roles';

    public $timestamps = false;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function getRole()
    {
        return $this::orderBy('name', 'asc')->get();
    }

    public function saveRole($request): Role
    {
        DB::beginTransaction();
        try {
            $this->name = $request->name;
            $this->display_name = $request->display_name;
            $this->description = $request->description;
            $this->save();

            if ($request->has('permissions')) {
                $this->permissions()->sync($request->permissions);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Role Create failed :: ' . $e->getMessage());
        }
        DB::commit();

        return $this;
    }

    public function updateRole($role, $request): Role
    {
        DB::beginTransaction();
        try {
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Role Update failed :: ' . $e->getMessage());
        }
        DB::commit();

        return $this;
    }
}
