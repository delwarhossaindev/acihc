<?php

namespace App\Models;

use App\Helpers\Addressable;
use App\Helpers\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use Addressable;
    use AuditableTrait;
    use HasApiTokens;
    use HasFactory;
    use HasRolesAndPermissions;
    use Imageable;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'designation',
        'staff_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function storeUser($request): self
    {
        $this->fill([
            'name'        => $request->name,
            'email'       => strtolower(trim($request->email)),
            'password'    => $request->password,
            'designation' => $request->designation,
            'staff_id'    => $request->staff_id,
        ])->save();

        if ($request->filled('roles')) {
            $this->roles()->sync($request->roles);
        }

        return $this;
    }

    public function updateProfile($user, $request): self
    {
        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'designation' => $request->designation,
            'staff_id'    => $request->staff_id,
            'status'      => $request->status,
        ]);

        if ($request->filled('image')) {
            $this->saveImage($request);
        }

        return $this;
    }

    public function updateUser($user, $request): self
    {
        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'designation' => $request->designation,
            'staff_id'    => $request->staff_id,
            'status'      => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        if ($request->filled('roles')) {
            $user->roles()->sync($request->roles);
        }

        return $this;
    }
}
