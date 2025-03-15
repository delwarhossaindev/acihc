<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolApprover extends Model
{
    use HasFactory;

    protected $table = 'ProtocolApprover';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolID',
        'UserID',
        'CreateDate',
        'Comment',
    ];
}
