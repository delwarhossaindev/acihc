<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolApprovalTree extends Model
{
    use HasFactory;

    protected $table = 'ProtocolApprovalTree';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolID',
        'UserID',
        'ProtocolApprovalTypeID',
        'CreateDate',
    ];
}
