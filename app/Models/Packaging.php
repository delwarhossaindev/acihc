<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Packaging extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Packaging';

    public $incrementing = true;

    protected $primaryKey = 'PackagingID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'PackagingName',
        'PackagingSource',
        'PackagingDMF',
        'PackagingResin',
        'PackagingColorant',
        'PackagingLiner',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function getPackaging()
    {
        return static::query();
    }

    public function createPackaging($request): self
    {
        $this->fill($this->packagingData($request) + ['CreatedBy' => Auth::id()])->save();

        return $this;
    }

    public function updatePackaging($packaging, $request): self
    {
        $packaging->update($this->packagingData($request) + ['UpdatedBy' => Auth::id()]);

        return $this;
    }

    protected function packagingData($request): array
    {
        return [
            'PackagingName'     => $request->PackagingName,
            'PackagingSource'   => $request->PackagingSource ?: '',
            'PackagingDMF'      => $request->PackagingDMF,
            'PackagingResin'    => $request->PackagingResin,
            'PackagingColorant' => $request->PackagingColorant,
            'PackagingLiner'    => $request->PackagingLiner,
        ];
    }
}
