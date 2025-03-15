<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolSkuPackContainer extends Model
{
    use HasFactory;

    protected $table = "ProtocolSkuPackContainer";

    public $incrementing = true;

    protected $primaryKey = "ProtocolSkuPackID";

    protected $keyType = 'string';

    public $timestamps = false;
    
    protected $fillable = [
        'ProtocolSkuPackID',
        'PackID'
    ];

    public function pack()
    {
        return $this->belongsTo(Pack::class,'PackID');
    }

}
