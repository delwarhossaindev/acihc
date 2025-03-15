<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ApiDetail extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "ApiDetail";

    public $incrementing = true;

    protected $primaryKey = "ApiDetailID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'ApiDetailID',
        'ApiDetailName',
        'APIDetailSource',
        'ExpDate',
        'CreatedBy',
        'UpdatedBy'
    ];
    
    public function batchs()
    {
        return $this->hasMany(APIDetailBatch::class,'ApiDetailID');
    }

    public function apis()
    {
        return $this->belongsToMany(ApiDetail::class,'ProtocolApiDetailPivot','ApiDetailID','ProtocolAPIDetailID');
    }

    public function getAPIDetail()
    {   
        return $this::query();
    }

    public function createApiDetail($request) : ApiDetail
    {
        $this->ApiDetailName = $request->ApiDetailName;
        $this->APIDetailSource = $request->APIDetailSource;
        $this->ExpDate = $request->ExpDate;
        $this->CreatedBy = auth()->id();
        $this->save();
        
        if($request->StudyTypeMonth){
            foreach (json_decode($request->StudyTypeMonth) as $batch) {
                $this->batchs()->create([
                    'BatchNo' => $batch->value
                ]);
            }
        }
       
        return $this;
    }

    public function editApiDetail($apidetail, $request) : ApiDetail
    {   
        $apidetail->update([
            'ApiDetailName' => $request->ApiDetailName,
            'APIDetailSource' => $request->APIDetailSource,
            'ExpDate' => $request->ExpDate,
            'UpdatedBy' => auth()->id()
        ]);
        
        APIDetailBatch::where('APIDetailID',$apidetail->ApiDetailID)
        ->delete();
        
        if($request->StudyTypeMonth){
            foreach (json_decode($request->StudyTypeMonth) as $batch) {
                $apidetail->batchs()->create([
                    'BatchNo' => $batch
                ]);
            }
        }
        
        return $this;
    }

}
