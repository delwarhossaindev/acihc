<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolPackPrimary extends Model
{
    use HasFactory;

    protected $table = "ProtocolPackPrimary";

    // public $incrementing = true;

    // protected $primaryKey = "ProtocolPackagingPackID";

    // protected $keyType = 'string';

    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolPackagingPackID',
        'ContainerID'
    ];
}
