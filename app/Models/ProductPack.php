<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPack extends Model
{
    use HasFactory;

    protected $table = "SkuPack";

    protected $primaryKey = "SkuPackID";

    public $timestamps = false;
    
    protected $fillable = [
        'SkuPackID',
        'SkuID',
        'PackID',
    ];
}
