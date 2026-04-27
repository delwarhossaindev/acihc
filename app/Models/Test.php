<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Test extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Test';

    public $incrementing = true;

    protected $primaryKey = 'TestID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'TestID',
        'ParentID',
        'TestName',
        'TestType',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function child()
    {
        return $this->hasMany(Subtest::class, 'TestID');
    }

    public function getTest()
    {
        return static::query();
    }

    public function createTest($request): self
    {
        $userId = Auth::id();

        if (! $request->has('hasParent')) {
            $this->fill([
                'TestName'  => $request->TestName,
                'TestType'  => $request->TestType,
                'CreatedBy' => $userId,
            ])->save();

            return $this;
        }

        Subtest::create([
            'TestID'      => $request->parent,
            'SubTestName' => $request->TestName,
            'TestType'    => $request->TestType,
            'CreatedBy'   => $userId,
        ]);

        return $this;
    }

    public function updateTest($test, $request): self
    {
        $test->update([
            'TestName'  => $request->TestName,
            'TestType'  => $request->TestType,
            'UpdatedBy' => Auth::id(),
        ]);

        return $this;
    }
}
