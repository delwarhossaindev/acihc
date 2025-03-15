<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placebo extends Model
{
    use HasFactory;

    protected $table = "Placebo";

    public $incrementing = true;

    protected $primaryKey = "PlaceboID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'PlaceboID',
        'ProtocolID',
        'SkuID',
        'PackID',
        'Month',
        'Aditional'
    ];

    public function placeboDetails()
    {
        return $this->hasMany(ProtocolPlaceboDetail::class,'PlaceboID');
    }
}
