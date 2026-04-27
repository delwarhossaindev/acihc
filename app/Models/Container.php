<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Container extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Container';

    public $incrementing = true;

    protected $primaryKey = 'ContainerID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ContainerType',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function packaging(): BelongsToMany
    {
        return $this->belongsToMany(Packaging::class, 'ContainerPackaging', 'ContainerID', 'PackagingID');
    }

    public function getContainer()
    {
        return static::query()->with('packaging');
    }

    public function createContainer($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->fill([
                    'ContainerType' => $request->ContainerType,
                    'CreatedBy'     => Auth::id(),
                ])->save();

                $this->packaging()->sync((array) $request->packaging);

                return $this;
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not create data'], 500);
        }
    }

    public function updateContainer($container, $request)
    {
        try {
            DB::transaction(function () use ($container, $request) {
                $container->update([
                    'ContainerType' => $request->ContainerType,
                    'UpdatedBy'     => Auth::id(),
                ]);

                $container->packaging()->sync((array) $request->packaging);
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not update data'], 500);
        }

        return $this;
    }
}
