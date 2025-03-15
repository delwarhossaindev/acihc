<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAPIDetail extends Model
{
    use HasFactory;

    protected $table = "ProductAPIDetail";

    public $incrementing = true;

    protected $primaryKey = "ProductAPIDetailID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProductAPIDetailID',
        'ProductID',
        'ApiDetailID'
    ];
}
