<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ProtocolStabilityStudy extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'ProtocolStabilityStudy';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolStabilityStudyID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolStabilityStudyID',
        'ProtocolID',
        'StudyTypeID',
        'ConditionID',
        'Duration',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function testingTimePoints()
    {
        return $this->hasMany(ProtocolStabilityStudyDetail::class, 'ProtocolStabilityStudyID');
    }

    public function study()
    {
        return $this->belongsTo(StudyType::class, 'StudyTypeID');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class, 'ConditionID');
    }
}
