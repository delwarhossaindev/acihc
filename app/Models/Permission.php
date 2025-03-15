<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
// use Laratrust\Models\LaratrustPermission;
use Laratrust\Models\Permission as PermissionModel;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Permission extends PermissionModel implements Auditable
{
    use AuditableTrait;

    public $guarded = [];

    protected $table = 'permissions';

    public $timestamps = false;

    public function getPermission()
    {
        return $this::orderBy('description')->get();
    }

    public function savePermission($request): self
    {
        $this->name = $request->name;
        $this->display_name = $request->display_name;
        $this->description = $request->description;
        $this->save();

        return $this;
    }

    public function updatePerssion($permission, $request)
    {
        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description'  => $request->description
        ]);

        return $this;
    }
}
