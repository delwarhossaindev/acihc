<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleApprover extends Model
{
    use HasFactory;

    protected $table = 'SampleApprover';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'SampleReportID',
        'UserID',
        'CreateDate',
        'Comment',
    ];
}
