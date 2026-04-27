<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Pack extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Pack';

    public $incrementing = true;

    protected $primaryKey = 'PackID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'PackID',
        'PackValue',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function getPack()
    {
        return static::query();
    }

    public function createPack($request): self
    {
        $values = array_filter((array) $request->PackValue);
        $userId = Auth::id();

        $rows = array_map(fn ($value) => [
            'PackValue' => $value,
            'CreatedBy' => $userId,
        ], $values);

        if ($rows) {
            self::insert($rows);
        }

        return $this;
    }

    public function updatePack($pack, $request): self
    {
        $pack->update([
            'PackValue' => $request->PackValue,
            'UpdatedBy' => Auth::id(),
        ]);

        return $this;
    }
}
