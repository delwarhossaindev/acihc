<?php

namespace App\Models;

use Laratrust\Models\Permission as PermissionModel;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends PermissionModel implements Auditable
{
    use AuditableTrait;

    public $guarded = [];

    protected $table = 'permissions';

    public $timestamps = false;

    public function getPermission()
    {
        return static::orderBy('description')->get();
    }

    public function savePermission($request): self
    {
        $this->fill([
            'name'         => $request->name,
            'display_name' => $request->display_name,
            'description'  => $request->description,
        ])->save();

        return $this;
    }

    public function updatePerssion($permission, $request): self
    {
        $permission->update([
            'name'         => $request->name,
            'display_name' => $request->display_name,
            'description'  => $request->description,
        ]);

        return $this;
    }
}
