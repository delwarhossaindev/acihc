<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class ProtocolHistoryReason extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRelationships;

    protected $table = 'ProtocolHistoryReason';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolHistoryID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolHistoryID',
        'ProtocolID',
        'Reason',
        'CreatedBy',
        'CreatedAt',
    ];
}
