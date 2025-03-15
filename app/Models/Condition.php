<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condition extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Condition";

    public $incrementing = true;

    protected $primaryKey = "ConditionID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'ConditionID',
        'ConditionName',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function getCondition()
    {
        return $this::query();
    }

    public function createCondition($request)
    {
        $this->ConditionName = $request->ConditionName;
        $this->CreatedBy = auth()->id();
        $this->save();

        return $this;
    }

    public function updateCondition($condition, $request)
    {   
        $condition->update([
            'ConditionName' => $request->ConditionName,
            'UpdateBy' => auth()->id()
        ]);

        return $this;
    }
}
