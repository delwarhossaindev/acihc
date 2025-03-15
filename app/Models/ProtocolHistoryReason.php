<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtocolHistoryReason extends Model implements Auditable
{
    use HasFactory, AuditableTrait, HasRelationships;

    protected $table = "ProtocolHistoryReason";

    public $incrementing = true;

    protected $primaryKey = "ProtocolHistoryID";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolHistoryID',
        'ProtocolID',
        'Reason',
        'CreatedBy',
        'CreatedAt'
    ];



}
