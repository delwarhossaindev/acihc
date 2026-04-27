<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ProtocolAPIDetail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'ProtocolAPIDetail';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolAPIDetailID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolAPIDetailID',
        'ProtocolID',
        'APIDetailID',
        'ExpDate',
        'CreatedBy',
        'UpdatedBy',
        'BatchNo',
    ];

    public function api()
    {
        return $this->belongsTo(ApiDetail::class, 'APIDetailID');
    }
}
