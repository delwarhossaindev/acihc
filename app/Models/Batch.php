<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'Batch';

    public $incrementing = true;

    protected $primaryKey = 'BatchID';

    protected $keyType = 'int';

    public $timestamps = false;

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
        'IsWithdrawal',
    ];

    protected $casts = [
        'MfgDate' => 'date',
        'ExpDate' => 'date',
        'SIDate'  => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }

    public function withdrawalByName()
    {
        return $this->belongsTo(User::class, 'WithdrawalBy');
    }

    public function batchDetails()
    {
        return $this->hasMany(BatchDetails::class, 'BatchID', 'BatchID');
    }

    public function createBatch($request)
    {
        if (! $request->ProtocolID || ! $request->WithdrawalDate || ! $request->Month) {
            return response()->json(['error' => 'Missing required data.'], 422);
        }

        $protocol = Protocol::where('ProtocolID', $request->ProtocolID)->first();

        if (! $protocol) {
            return response()->json(['error' => 'Protocol not found.'], 404);
        }

        return DB::transaction(function () use ($request, $protocol) {
            $batch = self::create([
                'BatchName'         => $request->BatchName,
                'BatchNo'           => $request->BatchNo,
                'BatchSize'         => $request->BatchSize,
                'MfgDate'           => Carbon::parse($request->MfgDate)->format('Y-m-d'),
                'ExpDate'           => Carbon::parse($request->ExpDate)->format('Y-m-d'),
                'SIDate'            => Carbon::parse($request->SIDate)->format('Y-m-d'),
                'ProductID'         => $protocol->ProductID,
                'ProtocolID'        => $request->ProtocolID,
                'SkuID'             => $request->SkuID,
                'PackID'            => $request->PackID,
                'DescriptionOfPack' => $request->DescriptionOfPack,
            ]);

            $this->insertBatchDetails($batch, $request);

            return true;
        });
    }

    public function updateBatch($batch, $request): self
    {
        $protocol = Protocol::where('ProtocolID', $request->ProtocolID)->first();

        DB::transaction(function () use ($batch, $request, $protocol) {
            $batch->update([
                'BatchName'         => $request->BatchName,
                'BatchNo'           => $request->BatchNo,
                'BatchSize'         => $request->BatchSize,
                'MfgDate'           => Carbon::parse($request->MfgDate)->format('Y-m-d'),
                'ExpDate'           => Carbon::parse($request->ExpDate)->format('Y-m-d'),
                'SIDate'            => Carbon::parse($request->SIDate)->format('Y-m-d'),
                'ProductID'         => $protocol?->ProductID,
                'ProtocolID'        => $request->ProtocolID,
                'SkuID'             => $request->SkuID,
                'PackID'            => $request->PackID,
                'DescriptionOfPack' => $request->DescriptionOfPack,
            ]);

            BatchDetails::where('BatchID', $batch->BatchID)->delete();

            $this->insertBatchDetails($batch, $request);
        });

        return $this;
    }

    public function getBatch()
    {
        return static::query();
    }

    protected function insertBatchDetails($batch, $request): void
    {
        $dates = (array) $request->WithdrawalDate;
        $months = (array) $request->Month;
        $conditions = (array) $request->Condition;

        $rows = [];
        foreach ($dates as $key => $date) {
            if (! isset($months[$key])) {
                continue;
            }

            $rows[] = [
                'BatchID'        => $batch->BatchID,
                'WithdrawalDate' => Carbon::parse($date)->format('Y-m-d'),
                'Month'          => $months[$key],
                'ConditionID'    => $conditions[$key] ?? null,
            ];
        }

        if ($rows) {
            BatchDetails::insert($rows);
        }
    }
}
