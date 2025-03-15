<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolTest extends Model
{
    use HasFactory;

    protected $table = "ProtocolTest";

    public $incrementing = true;

    protected $primaryKey = "ProtocolTestID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolTestID',
        'ProtocolID',
        'TestID',
        'Value'
    ];

    public function protocolSkuTest()
    {
        return $this->hasMany(ProtocolSkuTest::class,'ProtocolTestID');
    }
}
