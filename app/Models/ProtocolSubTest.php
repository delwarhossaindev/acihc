<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolSubTest extends Model
{
    use HasFactory;

    protected $table = "ProtocolSubTest";

    public $incrementing = true;

    protected $primaryKey = "ProtocolSubTestID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolID',
        'TestID',
        'Value'
    ];
}
