<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolPlaceboDetail extends Model
{
    use HasFactory;

    protected $table = "ProtocolPlaceboDetail";

    public $incrementing = true;

    protected $primaryKey = "ProtocolPlaceboDetailID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'PlaceboID',
        'StudyTypeID',
        'Month',
        'Count',
        'AditionalSample'
    ];
}
