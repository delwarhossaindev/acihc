<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Helpers\Addressable;
use App\Helpers\Imageable;
use Laratrust\Traits\LaratrustUserTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions,  AuditableTrait, Imageable, Addressable;
    // LaratrustUserTrait

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'designation',
        'staff_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function enroll()
    {
        return $this->hasOne(Enroll::class, 'user_id');
    }

    public function enrolls()
    {
        return $this->hasMany(Enroll::class, 'user_id');
    }

    public function storeUser($request)
    {
        $this->name = $request->name;
        $this->email = strtolower(trim($request->email));
        $this->password = bcrypt($request->password);
        $this->designation = $request->designation;
        $this->staff_id = $request->staff_id;
        $this->save();

        if ($request->has('roles')) {
            $this->roles()->sync($request->roles);
        }

        return $this;
    }

    public function updateProfile($user, $request): User
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'staff_id' => $request->staff_id,
            'updated_at' => now(),
            'status' => $request->status
        ]);

        if ($request->has('image')) {
            $this->saveImage($request);
        }

        return $this;
    }

    public function updateUser($user, $request)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'staff_id' => $request->staff_id,
            'updated_at' => now(),
            'status' => $request->status
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return $this;
    }

    public function userList()
    {
        return User::query();
    }
}
