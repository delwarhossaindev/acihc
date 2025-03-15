<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Container extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Container";

    public $incrementing = true;

    protected $primaryKey = "ContainerID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'ContainerType',
        'CreatedBy',
        'UpdatedBy'
    ];
    
    public function packaging() : BelongsToMany
    {
        return $this->belongsToMany(Packaging::class, 'ContainerPackaging', 'ContainerID','PackagingID');
    }

    public function getContainer()
    {
        return $this::query()->with('packaging');
    }

    public function createContainer($request)
    {   
        DB::beginTransaction();
        try {
            $this->ContainerType = $request->ContainerType;
            $this->CreatedBy = auth()->id();
            $this->save();
    
            $this->packaging()->sync($request->packaging);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create data',
            ], 500);
        }

        return $this;
    }

    public function updateContainer($container, $request)
    {   
        DB::beginTransaction();
        try {
            $container->update([
                'ContainerType' => $request->ContainerType,
                'UpdateBy' => auth()->id()
            ]);
    
            $container->packaging()->sync($request->packaging);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create data',
            ], 500);
        }

        return $this;
    }
}
