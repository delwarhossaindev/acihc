<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyType extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "StudyType";

    public $incrementing = true;

    protected $primaryKey = "StudyTypeID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'StudyTypeID',
        'StudyTypeName',
        'CreatedBy',
        'UpdatedBy'
    ];
    
    public function details()
    {
        return $this->hasMany(StudyTypeDetail::class,'StudyTypeID');
    }

    public function getStudyType()
    {
        return $this::orderBy('StudyTypeID','desc')
                    ->get();
    }

    public function createStudyType($request)
    {   
        DB::beginTransaction();
        try {
            $this->StudyTypeName = $request->StudyTypeName;
            $this->CreatedBy = auth()->id();
            $this->save();
            
            foreach (json_decode($request->StudyTypeMonth) as $month) {
                $this->details()->create([
                    'StudyTypeMonth' => $month->value
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create data',
            ], 500);
        }

        return $this;
    }

    public function updateMarket($studytype, $request)
    {   
        DB::beginTransaction();
        try {  
            $studytype->update([
                'StudyTypeName' => $request->StudyTypeName,
                'UpdatedBy' => auth()->id()
            ]);
            StudyTypeDetail::where('StudyTypeID',$studytype->StudyTypeID)
            ->delete();
            foreach (json_decode($request->StudyTypeMonth) as $month) {
                $studytype->details()->create([
                    'StudyTypeMonth' => $month->value
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create data',
            ], 500);
        }

        return $this;
    }
}
