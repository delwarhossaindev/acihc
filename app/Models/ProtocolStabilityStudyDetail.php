<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolStabilityStudyDetail extends Model
{
    use HasFactory;

    protected $table = "ProtocolStabilityStudyDetail";

    public $incrementing = true;

    protected $primaryKey = "ProtocolStabilityStudyDetailID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolStabilityStudyDetailID',
        'ProtocolStabilityStudyID',
        'TestingMonth',
        'CreatedBy',
        'UpdatedBy'
    ];
}
