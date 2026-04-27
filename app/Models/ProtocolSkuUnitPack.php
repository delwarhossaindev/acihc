<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolSkuUnitPack extends Model
{
    use HasFactory;

    protected $table = 'ProtocolSkuUnitPack';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolSkuUnitPackID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolID',
        'SkuID',
        'PackID',
        'Month',
        'Additional',
    ];

    public function designStabilityChamber()
    {
        return $this->hasMany(ProtocolStabilityChamberDesign::class, 'ProtocolSkuUnitPackID');
    }
}
