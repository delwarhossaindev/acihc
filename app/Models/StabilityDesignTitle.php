<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StabilityDesignTitle extends Model
{
    use HasFactory;

    protected $table = "StabilityDesignTitle";

    protected $primaryKey = "StabilityDesignTitleID";

    public $timestamps = false;

    protected $fillable = [
        'StabilityDesignTitleID',
        'ProtocolID',
        'Title',
    ];

    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'ProtocolID', 'ProtocolID');
    }

}
