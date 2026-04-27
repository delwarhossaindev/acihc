<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Condition extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Condition';

    public $incrementing = true;

    protected $primaryKey = 'ConditionID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ConditionID',
        'ConditionName',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function getCondition()
    {
        return static::query();
    }

    public function createCondition($request): self
    {
        $this->fill([
            'ConditionName' => $request->ConditionName,
            'CreatedBy'     => Auth::id(),
        ])->save();

        return $this;
    }

    public function updateCondition($condition, $request): self
    {
        $condition->update([
            'ConditionName' => $request->ConditionName,
            'UpdateBy'      => Auth::id(),
        ]);

        return $this;
    }
}
