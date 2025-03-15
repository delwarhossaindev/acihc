<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtocolSkuTest extends Model
{
    use HasFactory;

    protected $table = "ProtocolSkuTest";

    public $incrementing = true;

    protected $primaryKey = "ProtocolSkuTestID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolTestID',
        'SkuID',
        'UnitPerTest'
    ];
}
