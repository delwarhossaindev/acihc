<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ApiDetail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'ApiDetail';

    public $incrementing = true;

    protected $primaryKey = 'ApiDetailID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ApiDetailID',
        'ApiDetailName',
        'APIDetailSource',
        'ExpDate',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function batchs()
    {
        return $this->hasMany(APIDetailBatch::class, 'ApiDetailID');
    }

    public function apis()
    {
        return $this->belongsToMany(ApiDetail::class, 'ProtocolApiDetailPivot', 'ApiDetailID', 'ProtocolAPIDetailID');
    }

    public function getAPIDetail()
    {
        return static::query();
    }

    public function createApiDetail($request): self
    {
        $this->fill([
            'ApiDetailName'   => $request->ApiDetailName,
            'APIDetailSource' => $request->APIDetailSource,
            'ExpDate'         => $request->ExpDate,
            'CreatedBy'       => Auth::id(),
        ])->save();

        $this->insertBatches($this, $request->StudyTypeMonth, true);

        return $this;
    }

    public function editApiDetail($apidetail, $request): self
    {
        $apidetail->update([
            'ApiDetailName'   => $request->ApiDetailName,
            'APIDetailSource' => $request->APIDetailSource,
            'ExpDate'         => $request->ExpDate,
            'UpdatedBy'       => Auth::id(),
        ]);

        APIDetailBatch::where('APIDetailID', $apidetail->ApiDetailID)->delete();

        $this->insertBatches($apidetail, $request->StudyTypeMonth, false);

        return $this;
    }

    protected function insertBatches($apidetail, $studyTypeMonth, bool $useObjectValue): void
    {
        if (! $studyTypeMonth) {
            return;
        }

        $items = is_string($studyTypeMonth) ? json_decode($studyTypeMonth) : $studyTypeMonth;
        if (! is_array($items) && ! is_object($items)) {
            return;
        }

        $rows = [];
        foreach ($items as $batch) {
            $batchNo = $useObjectValue ? ($batch->value ?? null) : $batch;
            if ($batchNo !== null) {
                $rows[] = [
                    'ApiDetailID' => $apidetail->ApiDetailID,
                    'BatchNo'     => $batchNo,
                ];
            }
        }

        if ($rows) {
            APIDetailBatch::insert($rows);
        }
    }
}
