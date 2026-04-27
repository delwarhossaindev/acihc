<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class StudyType extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'StudyType';

    public $incrementing = true;

    protected $primaryKey = 'StudyTypeID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'StudyTypeID',
        'StudyTypeName',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function details()
    {
        return $this->hasMany(StudyTypeDetail::class, 'StudyTypeID');
    }

    public function getStudyType()
    {
        return static::orderBy('StudyTypeID', 'desc')->get();
    }

    public function createStudyType($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->fill([
                    'StudyTypeName' => $request->StudyTypeName,
                    'CreatedBy'     => Auth::id(),
                ])->save();

                $this->insertStudyMonths($this, $request->StudyTypeMonth);

                return $this;
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not create data'], 500);
        }
    }

    public function updateMarket($studytype, $request)
    {
        try {
            DB::transaction(function () use ($studytype, $request) {
                $studytype->update([
                    'StudyTypeName' => $request->StudyTypeName,
                    'UpdatedBy'     => Auth::id(),
                ]);

                StudyTypeDetail::where('StudyTypeID', $studytype->StudyTypeID)->delete();
                $this->insertStudyMonths($studytype, $request->StudyTypeMonth);
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not update data'], 500);
        }

        return $this;
    }

    protected function insertStudyMonths($studyType, $studyTypeMonth): void
    {
        $items = is_string($studyTypeMonth) ? json_decode($studyTypeMonth) : $studyTypeMonth;

        if (! is_array($items) && ! is_object($items)) {
            return;
        }

        $rows = [];
        foreach ($items as $month) {
            if (isset($month->value)) {
                $rows[] = [
                    'StudyTypeID'    => $studyType->StudyTypeID,
                    'StudyTypeMonth' => $month->value,
                ];
            }
        }

        if ($rows) {
            StudyTypeDetail::insert($rows);
        }
    }
}
