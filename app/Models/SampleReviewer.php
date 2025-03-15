<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleReviewer extends Model
{
    use HasFactory;

    protected $table = 'SampleReviewer';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'SampleReportID',
        'UserID',
        'CreateDate',
        'Comment',
    ];
}
