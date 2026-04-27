<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Subtest extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Subtest';

    public $incrementing = true;

    protected $primaryKey = 'SubtestID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'TestID',
        'SubtestID',
        'SubTestName',
        'TestType',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function getSubTest()
    {
        return static::query();
    }

    public function updateSubTest($subtest, $request): self
    {
        $subtest->update([
            'SubTestName' => $request->SubTestName,
            'TestType'    => $request->SubTestType,
            'UpdatedBy'   => Auth::id(),
        ]);

        return $this;
    }
}
