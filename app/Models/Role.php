<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laratrust\Models\Role as RoleModel;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

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
        return static::orderBy('name', 'asc')->get();
    }

    public function saveRole($request): self
    {
        try {
            DB::transaction(function () use ($request) {
                $this->fill([
                    'name'         => $request->name,
                    'display_name' => $request->display_name,
                    'description'  => $request->description,
                ])->save();

                if ($request->filled('permissions')) {
                    $this->permissions()->sync($request->permissions);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Role Create failed :: ' . $e->getMessage());
        }

        return $this;
    }

    public function updateRole($role, $request): self
    {
        try {
            DB::transaction(function () use ($role, $request) {
                $role->update([
                    'name'         => $request->name,
                    'display_name' => $request->display_name,
                    'description'  => $request->description,
                ]);

                if ($request->filled('permissions')) {
                    $role->permissions()->sync($request->permissions);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Role Update failed :: ' . $e->getMessage());
        }

        return $this;
    }
}
