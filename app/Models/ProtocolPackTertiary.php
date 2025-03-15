<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolPackTertiary extends Model
{
    use HasFactory;

    protected $table = "ProtocolPackTertiary";

    // public $incrementing = true;

    // protected $primaryKey = "ProtocolPackagingPackID";

    // protected $keyType = 'string';

    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolPackagingPackID',
        'ContainerID'
    ];
}
