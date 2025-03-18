<?php

namespace App\Models;

use Carbon\Carbon;
use App\Helpers\HasValidation;
use App\Http\Requests\BatchRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory, HasValidation;

    protected $table = "Batch";

    public $incrementing = true;

    protected $primaryKey = "BatchID";

    protected $keyType = 'string';

    public $timestamps = false;

    public function __construct()
    {
        self::$rules = (new BatchRequest())->rules();

        self::boot();
    }

    protected $fillable = [
        'BatchName',
        'BatchNo',
        'BatchSize',
        'MfgDate',
        'ExpDate',
        'SIDate',
        'WithdrawalDate',
        'ProductID',
        'SkuID',
        'Month',
        'ProtocolID',
        'PackID',
        'DescriptionOfPack',
        'IsWithdrawalDate',
        'IsWithdrawal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'ProductID');
    }

    public function createBatch($request)
    {
        

        $protocol = Protocol::where('ProtocolID',$request->ProtocolID)->first();
        $sidate = new Carbon($request->SIDate);
        $stabilty_initiation_date = $sidate->addMonths($request->Month);

        $this->BatchName = $request->BatchName;
        $this->BatchNo = $request->BatchNo;
        $this->BatchSize = $request->BatchSize;
        $this->MfgDate = date('Y-m-d', strtotime($request->MfgDate)); 
        $this->ExpDate = date('Y-m-d', strtotime($request->ExpDate)); 
        $this->SIDate = $stabilty_initiation_date->toDateString();
        $this->ProductID = $protocol->ProductID;
        $this->ProtocolID = $request->ProtocolID;
        $this->SkuID = $request->SkuID;
        $this->PackID = $request->PackID;
        $this->Month = $request->Month;
        $this->WithdrawalDate = $request->WithdrawalDate;
        $this->DescriptionOfPack = $request->DescriptionOfPack;
        $this->save();

        return $this;
    }

    public function updateBatch($batch, $request)
    {
      
        $protocol = Protocol::where('ProtocolID',$request->ProtocolID)->first();

        $stabilityInitiationDate = Carbon::parse($request->SIDate)->addMonths($request->Month)->toDateString();
       
        $batch->update([
            'BatchName' => $request->BatchName,
            'BatchNo' => $request->BatchNo,
            'BatchSize' => $request->BatchSize,
            'MfgDate' => date('Y-m-d', strtotime($request->MfgDate)),
            'ExpDate' => date('Y-m-d', strtotime($request->ExpDate)),
            'SIDate' => $stabilityInitiationDate,
            'ProductID' => $protocol->ProductID,
            'ProtocolID' => $request->ProtocolID,
            'SkuID' => $request->SkuID,
            'PackID' => $request->PackID,
            'WithdrawalDate' => $request->WithdrawalDate,
            'Month' => $request->Month,
            'DescriptionOfPack' => $request->DescriptionOfPack
        ]);

        return $this;
    }

    public function getBatch()
    {
        return $this::query();
    }

    public function withdrawalByName()
    {
        return $this->belongsTo(User::class, 'WithdrawalBy');
    }

   
}
