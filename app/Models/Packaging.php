<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Packaging extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Packaging";

    public $incrementing = true;

    protected $primaryKey = "PackagingID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'PackagingName', 
        'PackagingSource', 
        'PackagingDMF', 
        'PackagingResin', 
        'PackagingColorant', 
        'PackagingLiner'
    ];

    public function getPackaging()
    {
        return $this::query();
    }

    public function createPackaging($request)
    {
        $this->PackagingName = $request->PackagingName;
        $this->PackagingSource = $request->PackagingSource ?: '';
        $this->PackagingDMF = $request->PackagingDMF;
        $this->PackagingResin = $request->PackagingResin;
        $this->PackagingColorant = $request->PackagingColorant;
        $this->PackagingLiner = $request->PackagingLiner;
        $this->CreatedBy = auth()->id();
        $this->save();

        return $this;
    }

    public function updatePackaging($packaging, $request)
    {   
        $packaging->update([
            'PackagingName' => $request->PackagingName,
            'PackagingSource' => $request->PackagingSource ?: '',
            'PackagingDMF' => $request->PackagingDMF,
            'PackagingResin' => $request->PackagingResin,
            'PackagingColorant' => $request->PackagingColorant,
            'PackagingLiner' => $request->PackagingLiner,
            'UpdatedBy' => auth()->id()
        ]);

        return $this;
    }

}
