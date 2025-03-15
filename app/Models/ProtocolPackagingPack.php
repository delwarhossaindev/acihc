<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolPackagingPack extends Model
{
    use HasFactory;

    protected $table = "ProtocolPackagingPack";

    public $incrementing = true;

    protected $primaryKey = "ProtocolPackagingPackID";

    protected $keyType = 'string';

    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolPackagingPackID',
        'ProtocolID',
        'SkuID',
        'PackID',
    ];

    public function primary()
    {
        return $this->hasMany(ProtocolPackPrimary::class,'ProtocolPackagingPackID');
    }

    public function secondary()
    {
        return $this->hasMany(ProtocolPackSecondary::class,'ProtocolPackagingPackID');
    }

    public function tertiary()
    {
        return $this->hasMany(ProtocolPackTertiary::class,'ProtocolPackagingPackID');
    }
}
