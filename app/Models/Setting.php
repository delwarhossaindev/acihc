<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'settings';

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
    ];

    public function settings()
    {
        return static::all();
    }
}
