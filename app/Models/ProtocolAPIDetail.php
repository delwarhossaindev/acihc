<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtocolAPIDetail extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "ProtocolAPIDetail";

    public $incrementing = true;

    protected $primaryKey = "ProtocolAPIDetailID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolAPIDetailID',
        'ProtocolID',
        'APIDetailID',
        'ExpDate',
        'CreatedBy',
        'UpdatedBy',
        'BatchNo'
    ];

    public function api()
    {
        return $this->belongsTo(ApiDetail::class,'APIDetailID');
    }

}
