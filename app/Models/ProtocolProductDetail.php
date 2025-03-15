<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtocolProductDetail extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "ProtocolProductDetail";

    public $incrementing = true;

    protected $primaryKey = "ProtocolProductDetailID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolProductDetailID',
        'ProtocolID',
        'ProductID',
        'SkuID',
        'SpecificationNo',
        'STPNo',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'ProductID');
    }
}
