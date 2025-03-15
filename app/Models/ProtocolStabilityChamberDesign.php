<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolStabilityChamberDesign extends Model
{
    use HasFactory;

    protected $table = "ProtocolStabilityChamberDesign";

    public $incrementing = true;

    protected $primaryKey = "ProtocolStabilityChamberDesignID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolSkuUnitPackID',
        'Month',
        'StudyTypeID',
        'Count',
        'AditionalSample'
    ];
}
