<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Pack extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Pack";

    public $incrementing = true;

    protected $primaryKey = "PackID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'PackID',
        'PackValue',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function getPack()
    {
        return $this::query();
    }

    public function createPack($request)
    {   
        foreach (array_filter($request->PackValue) as $value) {
            Pack::create([
                'PackValue' => $value,
                'CreatedBy' => auth()->id()
            ]);
        }
       
        return $this;
    }

    public function updatePack($pack, $request)
    {   
        $pack->update([
            'PackValue' => $request->PackValue,
            'UpdatedBy' => auth()->id()
        ]);

        return $this;
    }
}
