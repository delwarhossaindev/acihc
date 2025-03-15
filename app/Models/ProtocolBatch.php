<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolBatch extends Model
{
    use HasFactory;

    protected $table = "ProtocolBatch";

    public $incrementing = true;

    protected $primaryKey = "ProtocolBatchID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'ProtocolID',
        'BatchID',
        'SkuID',
        'BatchNo',
        'BatchSize',
        'MfgDate',
        'StabilityInitiationDate'
    ];

    public function protocolBatchSku()
    {
        return $this->hasMany(ProtocolBatchSku::class,'ProtocolBatchID');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class,'BatchID');
    }
}
