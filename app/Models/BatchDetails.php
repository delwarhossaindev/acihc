<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchDetails extends Model
{
    protected $table = 'BatchDetails';

    protected $primaryKey = 'BatchDetailsID';

    public $timestamps = false;

    protected $fillable = [
        'BatchID',
        'WithdrawalDate',
        'Month',
        'IsWithdrawalDate',
        'IsWithdrawal',
        'WithdrawalBy',
        'ConditionID',
    ];
}
