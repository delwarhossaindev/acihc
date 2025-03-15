<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIDetailBatch extends Model
{
    use HasFactory;

    protected $table = "APIDetailBatch";

    public $incrementing = true;

    protected $primaryKey = "APIDetailBatchID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'APIDetailBatchID',
        'ApiDetailID',
        'BatchNo'
    ];
}
