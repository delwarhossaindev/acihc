<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerPackaging extends Model
{
    use HasFactory;

    protected $table = "ContainerPackaging";

    public $incrementing = true;

    protected $primaryKey = "ContainerPackagingID";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ContainerPackagingID',
        'ContainerID',
        'PackagingID'
    ];
}
