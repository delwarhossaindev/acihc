<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolAPIDetailPivot extends Model
{
    use HasFactory;

    protected $table = "ProtocolAPIDetailPivot";

    // public $incrementing = true;

    // protected $primaryKey = "ProtocolAPIDetailID";

    // protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolAPIDetailID',
        'APIDetailID'
    ];
}