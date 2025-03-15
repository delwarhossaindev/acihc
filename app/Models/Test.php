<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Test";

    public $incrementing = true;

    protected $primaryKey = "TestID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'TestID',
        'ParentID',
        'TestName',
        'TestType',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function child()
    {
        return $this->hasMany(Subtest::class,'TestID');
    }

    public function getTest()
    {
        return $this::query();
    }

    public function createTest($request)
    {   
        if(! $request->has('hasParent')) {
            $this->TestName = $request->TestName;
            $this->TestType = $request->TestType;
            $this->CreatedBy = auth()->id();
            $this->save();

            return $this;
        }

        Subtest::create([
            'TestID' => $request->parent,
            'SubTestName' => $request->TestName,
            'TestType' => $request->TestType,
            'CreatedBy' => auth()->id()
        ]);

        return $this;
    }

    public function updateTest($test, $request)
    {   
        $test->update([
            'TestName' => $request->TestName,
            'TestType' => $request->TestType,
            'UpdatedBy' => auth()->id()
        ]);

        return $this;
    }
}
