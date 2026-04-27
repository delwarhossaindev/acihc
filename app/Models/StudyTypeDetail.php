<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class StudyTypeDetail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'StudyTypeDetail';

    public $incrementing = true;

    protected $primaryKey = 'StudyTypeDetailID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'StudyTypeDetailID',
        'StudyTypeID',
        'StudyTypeMonth',
    ];
}
