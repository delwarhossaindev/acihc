<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtocolSkuPack extends Model implements Auditable
{
    use HasFactory, AuditableTrait, HasRelationships;
 
    protected $table = "ProtocolSkuPack";

    public $incrementing = true;

    protected $primaryKey = "ProtocolSkuPackID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolSkuPackID',
        'ProtocolID',
        'SkuID',
        'ContainerID',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function perUnit()
    {
        return $this->belongsTo(ProtocolSkuPackContainer::class,'ProtocolSkuPackID');
    }

    public function perUnitContainer()
    {
        return $this->hasMany(ProtocolSkuPackContainer::class,'ProtocolSkuPackID');
    }
}
