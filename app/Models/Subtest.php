<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtest extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Subtest";

    public $incrementing = true;

    protected $primaryKey = "SubtestID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'TestID',
        'SubtestID',
        'SubTestName',
        'TestType',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function getSubTest()
    {
        return $this::query();
    }

    public function updateSubTest($subtest, $request)
    {   
        $subtest->update([
            'SubTestName' => $request->SubTestName,
            'TestType' => $request->SubTestType,
            'UpdatedBy' => auth()->id()
        ]);

        return $this;
    }
}
