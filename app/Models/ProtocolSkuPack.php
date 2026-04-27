<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class ProtocolSkuPack extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRelationships;

    protected $table = 'ProtocolSkuPack';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolSkuPackID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolSkuPackID',
        'ProtocolID',
        'SkuID',
        'ContainerID',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function perUnit()
    {
        return $this->belongsTo(ProtocolSkuPackContainer::class, 'ProtocolSkuPackID');
    }

    public function perUnitContainer()
    {
        return $this->hasMany(ProtocolSkuPackContainer::class, 'ProtocolSkuPackID');
    }
}
