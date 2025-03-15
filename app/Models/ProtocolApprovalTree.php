<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolApprovalTree extends Model
{
    use HasFactory;

    protected $table = 'ProtocolApprovalTree'; // Exact table name

    protected $primaryKey = 'ID'; // Primary key column name

    public $timestamps = false; // Disable Laravel's default timestamps

    protected $fillable = [
        'ProtocolID',
        'UserID',
        'ProtocolApprovalTypeID',
        'CreateDate',
    ];
}