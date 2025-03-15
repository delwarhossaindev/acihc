<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleApprovalTree extends Model
{
    use HasFactory;

    protected $table = 'SampleApprovalTree'; 

    protected $primaryKey = 'ID'; 

    public $timestamps = false; 

    protected $fillable = [
        'SampleReportID',
        'UserID',
        'SampleApprovalTypeID',
        'CreateDate',
    ];
}