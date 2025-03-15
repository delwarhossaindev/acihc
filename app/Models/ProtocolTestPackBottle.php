<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolTestPackBottle extends Model
{
    use HasFactory;

    protected $table = "ProtocolTestPackBottle";

    public $incrementing = true;

    protected $primaryKey = "ProtocolTestPackBottleID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolTestPackBottleID',
        'ProtocolID',
        'PackID',
        'NumberOfBottle'
    ];

}
