<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolApprovalType extends Model
{
    use HasFactory;

    protected $table = 'ProtocolApprovalType';

    protected $primaryKey = 'ProtocolApprovalTypeID';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolApprovalType',
        'Active',
    ];
}