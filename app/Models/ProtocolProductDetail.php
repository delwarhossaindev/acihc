<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ProtocolProductDetail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'ProtocolProductDetail';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolProductDetailID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolProductDetailID',
        'ProtocolID',
        'ProductID',
        'SkuID',
        'SpecificationNo',
        'STPNo',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}
