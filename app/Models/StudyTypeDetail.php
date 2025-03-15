<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyTypeDetail extends Model implements Auditable
{   
    use HasFactory, AuditableTrait;

    protected $table = "StudyTypeDetail";

    public $incrementing = true;

    protected $primaryKey = "StudyTypeDetailID";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'StudyTypeDetailID',
        'StudyTypeID',
        'StudyTypeMonth'
    ];
}
