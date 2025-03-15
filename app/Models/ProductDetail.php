<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = "ProductDetail";

    protected $primaryKey = "SkuID";

    public $timestamps = false;
    
    protected $fillable = [
        'SkuID'.
        'ProductID',
        'ProductStrength'
    ];
}
