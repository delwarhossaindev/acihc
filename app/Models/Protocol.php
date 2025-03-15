<?php

namespace App\Models;

use App\Models\ProtocolPackagingPack;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Protocol extends Model implements Auditable
{
    use HasFactory, AuditableTrait, HasRelationships;

    protected $table = "Protocol";

    public $incrementing = true;

    protected $primaryKey = "ProtocolID";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ProtocolID',
        'ProductID',
        'MarketID',
        'ManufacturerID',
        'Title',
        'Purpose',
        'Scope',
        'Responsibilities',
        'Reference',
        'AnalysisReport',
        'Reporting',
        'Conclusion',
        'RevisionHistory',
        'CreatedBy',
        'UpdatedBy',
        'Note',
        'FooterSectionNo',
        'PreviousProtocolID',
        'Reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }

    public function updatedby()
    {
        return $this->belongsTo(User::class, 'UpdatedBy');
    }

    public function strengths()
    {
        return $this->hasMany(ProductDetail::class, 'ProductID');
    }

    public function sku()
    {
        return $this->hasMany(ProtocolSkuPack::class, 'ProtocolID');
    }

    public function protocolProductDetails()
    {
        return $this->hasMany(ProtocolProductDetail::class, 'ProtocolID');
    }

    public function protocolApiDetails()
    {
        return $this->hasMany(ProtocolAPIDetail::class, 'ProtocolID');
    }

    public function protocolTestPackCount()
    {
        return $this->hasMany(ProtocolTestPackBottle::class, 'ProtocolID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }

    public function market()
    {
        return $this->belongsTo(Market::class, 'MarketID');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'ManufacturerID');
    }

    public function apis()
    {
        return $this->hasMany(ProtocolAPIDetail::class, 'ProtocolID');
    }

    public function packagings()
    {
        return $this->hasMany(ProtocolPackagingPack::class, 'ProtocolID');
    }

    public function statbilityStudy()
    {
        return $this->hasMany(ProtocolStabilityStudy::class, 'ProtocolID');
    }

    public function tests()
    {
        return $this->hasMany(ProtocolTest::class, 'ProtocolID');
    }

    public function subtests()
    {
        return $this->hasMany(ProtocolSubTest::class, 'ProtocolID');
    }



    public function ProtocolTestPackBottle()
    {
        return $this->hasOne(ProtocolTestPackBottle::class, 'ProtocolID');
    }

    public function protocolSkuUnitPack()
    {
        return $this->hasMany(ProtocolSkuUnitPack::class, 'ProtocolID');
    }

    public function protocolPlacebo()
    {
        return $this->hasMany(Placebo::class, 'ProtocolID');
    }

    public function protocolBatch()
    {
        return $this->hasMany(ProtocolBatch::class, 'ProtocolID');
    }

    public function getProtocol()
    {
        return $this::query()->orderBy('ProtocolID', 'desc');
    }

    public function storeProtocol($request): Protocol
    {

        $this->Title = $request->Title;
        $this->Purpose = $request->Purpose;
        $this->Scope = $request->Scope;
        $this->Reference = $request->Reference;
        $this->ProtocolStatusID = 1;
        $this->FooterSectionNo = $request->FooterSectionNo;
        $this->Responsibilities = $request->Responsibilities;
        $this->ProductID = $request->ProductID;
        $this->MarketID = $request->MarketID;
        $this->ManufacturerID = $request->ManufacturerID;
        $this->AnalysisReport = $request->AnalysisReport;
        $this->Reporting = $request->Reporting;
        $this->Conclusion = $request->Conclusion;
        $this->RevisionHistory = $request->RevisionHistory;
        $this->CreatedBy = auth()->id();
        $this->Note = $request->Note ?? null;

        $this->save();

        return $this;
    }

    public function updateProtocol($protocol, $request)
    {

        $protocol->update([
            'MarketID' => $request->MarketID,
            'ManufacturerID' => $request->ManufacturerID,
            'Title' => $request->Title,
            'Purpose' => $request->Purpose,
            'Scope' => $request->Scope,
            'Responsibilities' => $request->Responsibilities,
            'Reference' => $request->Reference,
            'AnalysisReport' => $request->AnalysisReport,
            'Reporting' => $request->Reporting,
            'Conclusion' => $request->Conclusion,
            'FooterSectionNo' => $request->FooterSectionNo,
            'RevisionHistory' => $request->RevisionHistory,
            'UpdatedBy' => is_null(auth()->id()) ? 1 : auth()->id(),
            'Note' => $request->Note ?? null
        ]);

        return $this;
    }

    public function storeProtocolAPIDetail($protocol, $request)
    {
        if ($protocol->apis()->count() > 0) {
            ProtocolAPIDetail::where('ProtocolID', $protocol->ProtocolID)->delete();
        }

       

        foreach ($request->ApiID as $key => $value) {
            if (isset($request['BatchNo'][$key])) {
                $protocol->apis()->create([
                    'APIDetailID' => $value,
                    'BatchNo' => $request['BatchNo'][$key],
                    'ExpDate' => $request['ExpDate'][$key]
                ]);
            }
        }

        return $this;
    }

    public function storeProtocolProductDetails($protocol, $request): Protocol
    {




        if ($protocol->protocolProductDetails()->count() > 0) {
            ProtocolProductDetail::where('ProtocolID', $protocol->ProtocolID)
                ->delete();
        }

        foreach ($request->SkuID as $key => $sku) {
            if (isset($request->SpecificationNo[$key]) && isset($request->STPNo[$key])) {
                ProtocolProductDetail::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'ProductID' => $request->ProductID,
                    'SkuID' => $sku,
                    'SpecificationNo' => $request->SpecificationNo[$key],
                    'STPNo' => $request->STPNo[$key],
                    'CreatedBy' => auth()->id()
                ]);
            }
        }
        return $this;
    }

    public function storeProtocolSkuContainerType($protocol, $request): Protocol
    {
        $data = $request->all();
        unset($data['_token']);

        if ($protocol->sku->count() > 0) {
            $ProtocolSkuPackID = $protocol->sku->pluck('ProtocolSkuPackID');
            ProtocolSkuPackContainer::whereIn('ProtocolSkuPackID', $ProtocolSkuPackID)->delete();
            ProtocolSkuPack::where('ProtocolID', $protocol->ProtocolID)->delete();
        }
        foreach ($data as $key => $value) {
            if (isset($value['SkuID'])) {
                foreach ($value['SkuID'] as $index => $sku) {
                    //return $data[$key]['SkuID'][0];
                    //dd($data[$index]['ContainerType'][0]);
                    $ProtocolSkuPack = ProtocolSkuPack::create([
                        'ProtocolID' => $protocol->ProtocolID,
                        'SkuID' => $sku,
                        'ContainerID' => $data[$key]['ContainerType'][0]
                    ]);
                    foreach ($value['PackID'] as $index => $PackID) {
                        $ProtocolSkuPack->perUnitContainer()->create([
                            'PackID' => $PackID
                        ]);
                    }
                }
            }
        }

        return $this;
    }

    public function storeProtocolPackagingProfile($protocol, $request): Protocol
    {
        $data = $request->all();
        unset($data['_token']);

        if ($protocol->packagings->count() > 0) {
            $ProtocolPackagingPackID = $protocol->packagings->pluck('ProtocolPackagingPackID');
            ProtocolPackPrimary::whereIn('ProtocolPackagingPackID', $ProtocolPackagingPackID)->delete();
            ProtocolPackSecondary::whereIn('ProtocolPackagingPackID', $ProtocolPackagingPackID)->delete();
            ProtocolPackTertiary::whereIn('ProtocolPackagingPackID', $ProtocolPackagingPackID)->delete();
            ProtocolPackagingPack::where('ProtocolID', $protocol->ProtocolID)->delete();
        }

        foreach ($data as $key => $value) {
            $protocolPackaging = ProtocolPackagingPack::create([
                'ProtocolID' => $protocol->ProtocolID,
                'SkuID' => $data[$key]['SkuID'][0],
                'PackID' => $data[$key]['PackID'][0],
            ]);
            if (isset($value['Primary'])) {
                foreach ($value['Primary'] as $index => $ContainerID) {
                    $protocolPackaging->primary()->create([
                        'ContainerID' => $ContainerID
                    ]);
                }
            }
            if (isset($value['Secondary'])) {
                foreach ($value['Secondary'] as $index => $ContainerID) {
                    $protocolPackaging->secondary()->create([
                        'ContainerID' => $ContainerID
                    ]);
                }
            }
            if (isset($value['Tertiary'])) {
                foreach ($value['Tertiary'] as $index => $ContainerID) {
                    $protocolPackaging->tertiary()->create([
                        'ContainerID' => $ContainerID
                    ]);
                }
            }
        }

        return $this;
    }

    public function storeProtocolStabilityStudy($protocol, $request): Protocol
    {
        $data = $request->all();
        unset($data['_token']);
        if ($protocol->statbilityStudy->count() > 0) {
            $ProtocolStabilityStudyID = $protocol->statbilityStudy->pluck('ProtocolStabilityStudyID');
            ProtocolStabilityStudyDetail::whereIn('ProtocolStabilityStudyID', $ProtocolStabilityStudyID)->delete();
            ProtocolStabilityStudy::where('ProtocolID', $protocol->ProtocolID)->delete();
        }
        foreach ($data as $key => $value) {
            //dd($data[$key]['StydyTypeID'][0]);
            //dd($value['StudyTypeMonth'][$key]);
            $ProtocolStabilityStudy = ProtocolStabilityStudy::create([
                'ProtocolID' => $protocol->ProtocolID,
                'StudyTypeID' => $data[$key]['StydyTypeID'][0],
                'ConditionID' => $data[$key]['ConditionID'][0]
            ]);
            // if(isset($value['StudyTypeMonth'])){
            //     foreach ($value['StudyTypeMonth'] as $index => $TestingMonth) {
            //         $ProtocolStabilityStudy->testingTimePoints()->create([
            //             'TestingMonth' => $TestingMonth
            //         ]);
            //     }
            // }
        }

        return $this;
    }

    public function storeProtocolTestStudy($protocol, $request): Protocol
    {

        $data = $request->all();
        unset($data['_token']);
        if ($protocol->tests->count() > 0) {
            $pTID = $protocol->tests->pluck('ProtocolTestID');
            ProtocolSkuTest::whereIn('ProtocolTestID', $pTID)->delete();
            ProtocolTestPackBottle::where('ProtocolID', $protocol->ProtocolID)->delete();
            ProtocolTest::where('ProtocolID', $protocol->ProtocolID)->delete();
        }
        foreach ($data as $key => $value) {
            //dd($data[$key]['Sku'][0]);
            if (isset($data[$key]['TestID'][0])) {
                $protocolTest = ProtocolTest::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'TestID' => $data[$key]['TestID'][0]
                ]);
            }
            if (isset($data[$key]['Sku'][0]) && isset($data[$key]['UnitPerTest'][0])) {
                $protocolTest->protocolSkuTest()->create([
                    'SkuID' => $data[$key]['Sku'][0],
                    'UnitPerTest' => $data[$key]['UnitPerTest'][0],
                ]);
            }
            if (isset($data[$key]['Sku'][0]) && isset($data[$key]['Pack'][0]) && isset($data[$key]['PackBottleNumber'][0])) {
                $protocol->protocolTestPackCount()->create([
                    'SkuID' => $data[$key]['Sku'][0],
                    'PackID' => $data[$key]['Pack'][0],
                    'NumberOfBottle' => $data[$key]['PackBottleNumber'][0],
                ]);
            }
        }
        return $this;
    }


//////////////////////clone//////////////////////
public function cloneProtocolAPIDetail($protocol, $request)
{
    if ($protocol->apis()->count() > 0) {
        ProtocolAPIDetail::where('ProtocolID', $protocol->ProtocolID)->delete();
    }

    $ApiID = ProtocolAPIDetail::where('ProtocolID', $request->ProtocolID)->get();

    foreach ($ApiID as $key => $value) {
        if (isset($value->BatchNo)) {
            $protocol->apis()->create([
                'APIDetailID' => $value->APIDetailID,
                'BatchNo' => $value->BatchNo,
                'ExpDate' => $value->ExpDate
            ]);
        }
    }

    return $this;
}

public function cloneProtocolProductDetails($protocol, $request): Protocol
{
    if ($protocol->protocolProductDetails()->count() > 0) {
        ProtocolProductDetail::where('ProtocolID', $protocol->ProtocolID)
            ->delete();
    }
    $SkuID = ProtocolProductDetail::where('ProtocolID', $request->ProtocolID)->get();

    foreach ($SkuID as $key => $value) {
      
        if (isset( $value->SpecificationNo) && isset( $value->STPNo)) {
            ProtocolProductDetail::create([
                'ProtocolID' => $protocol->ProtocolID,
                'ProductID' => $value->ProductID,
                'SkuID' => $value->SkuID,
                'SpecificationNo' => $value->SpecificationNo,
                'STPNo' => $value->STPNo,
                'CreatedBy' => auth()->id()
            ]);
        }
    }
    return $this;
}

public function cloneProtocolSkuContainerType($protocol, $request): Protocol
{
    
    if ($protocol->sku->count() > 0) {
        $ProtocolSkuPackID = $protocol->sku->pluck('ProtocolSkuPackID');
        ProtocolSkuPackContainer::whereIn('ProtocolSkuPackID', $ProtocolSkuPackID)->delete();
        ProtocolSkuPack::where('ProtocolID', $protocol->ProtocolID)->delete();
    }

   
    $ProtocolSkuPackID = $request->sku->pluck('ProtocolSkuPackID');
    $ProtocolSkuPack = ProtocolSkuPack::where('ProtocolID', $request->ProtocolID)->get();
    $ProtocolSkuPackContainer = ProtocolSkuPackContainer::whereIn('ProtocolSkuPackID', $ProtocolSkuPackID)->get();


   // dd($ProtocolSkuPackID,$ProtocolSkuPackContainer,$ProtocolSkuPack,'test');

    foreach ($ProtocolSkuPackContainer as $key1 => $value1) {

        ProtocolSkuPackContainer::create([
            'PackID' => ''
        ]);

    }

    foreach ($ProtocolSkuPack as $key2 => $value2) {
        ProtocolSkuPack::create([
            'ProtocolID' => $request->ProtocolID,
            'SkuID' => $value2->SkuID,
            'ContainerID' => $value2->ContainerID
        ]);
        
    }


    return $this;
}

public function cloneProtocolPackagingProfile($protocol, $request): Protocol
{
    $data = $request->all();
    unset($data['_token']);

    if ($protocol->packagings->count() > 0) {
        $ProtocolPackagingPackID = $protocol->packagings->pluck('ProtocolPackagingPackID');
        ProtocolPackPrimary::whereIn('ProtocolPackagingPackID', $ProtocolPackagingPackID)->delete();
        ProtocolPackSecondary::whereIn('ProtocolPackagingPackID', $ProtocolPackagingPackID)->delete();
        ProtocolPackTertiary::whereIn('ProtocolPackagingPackID', $ProtocolPackagingPackID)->delete();
        ProtocolPackagingPack::where('ProtocolID', $protocol->ProtocolID)->delete();
    }

    foreach ($data as $key => $value) {
        $protocolPackaging = ProtocolPackagingPack::create([
            'ProtocolID' => $protocol->ProtocolID,
            'SkuID' => $data[$key]['SkuID'][0],
            'PackID' => $data[$key]['PackID'][0],
        ]);
        if (isset($value['Primary'])) {
            foreach ($value['Primary'] as $index => $ContainerID) {
                $protocolPackaging->primary()->create([
                    'ContainerID' => $ContainerID
                ]);
            }
        }
        if (isset($value['Secondary'])) {
            foreach ($value['Secondary'] as $index => $ContainerID) {
                $protocolPackaging->secondary()->create([
                    'ContainerID' => $ContainerID
                ]);
            }
        }
        if (isset($value['Tertiary'])) {
            foreach ($value['Tertiary'] as $index => $ContainerID) {
                $protocolPackaging->tertiary()->create([
                    'ContainerID' => $ContainerID
                ]);
            }
        }
    }

    return $this;
}

public function cloneProtocolStabilityStudy($protocol, $request): Protocol
{
    $data = $request->all();
    unset($data['_token']);
    if ($protocol->statbilityStudy->count() > 0) {
        $ProtocolStabilityStudyID = $protocol->statbilityStudy->pluck('ProtocolStabilityStudyID');
        ProtocolStabilityStudyDetail::whereIn('ProtocolStabilityStudyID', $ProtocolStabilityStudyID)->delete();
        ProtocolStabilityStudy::where('ProtocolID', $protocol->ProtocolID)->delete();
    }
    foreach ($data as $key => $value) {
        //dd($data[$key]['StydyTypeID'][0]);
        //dd($value['StudyTypeMonth'][$key]);
        $ProtocolStabilityStudy = ProtocolStabilityStudy::create([
            'ProtocolID' => $protocol->ProtocolID,
            'StudyTypeID' => $data[$key]['StydyTypeID'][0],
            'ConditionID' => $data[$key]['ConditionID'][0]
        ]);
        // if(isset($value['StudyTypeMonth'])){
        //     foreach ($value['StudyTypeMonth'] as $index => $TestingMonth) {
        //         $ProtocolStabilityStudy->testingTimePoints()->create([
        //             'TestingMonth' => $TestingMonth
        //         ]);
        //     }
        // }
    }

    return $this;
}

public function cloneProtocolTestStudy($protocol, $request): Protocol
{

    $data = $request->all();
    unset($data['_token']);
    if ($protocol->tests->count() > 0) {
        $pTID = $protocol->tests->pluck('ProtocolTestID');
        ProtocolSkuTest::whereIn('ProtocolTestID', $pTID)->delete();
        ProtocolTestPackBottle::where('ProtocolID', $protocol->ProtocolID)->delete();
        ProtocolTest::where('ProtocolID', $protocol->ProtocolID)->delete();
    }
    foreach ($data as $key => $value) {
        //dd($data[$key]['Sku'][0]);
        if (isset($data[$key]['TestID'][0])) {
            $protocolTest = ProtocolTest::create([
                'ProtocolID' => $protocol->ProtocolID,
                'TestID' => $data[$key]['TestID'][0]
            ]);
        }
        if (isset($data[$key]['Sku'][0]) && isset($data[$key]['UnitPerTest'][0])) {
            $protocolTest->protocolSkuTest()->create([
                'SkuID' => $data[$key]['Sku'][0],
                'UnitPerTest' => $data[$key]['UnitPerTest'][0],
            ]);
        }
        if (isset($data[$key]['Sku'][0]) && isset($data[$key]['Pack'][0]) && isset($data[$key]['PackBottleNumber'][0])) {
            $protocol->protocolTestPackCount()->create([
                'SkuID' => $data[$key]['Sku'][0],
                'PackID' => $data[$key]['Pack'][0],
                'NumberOfBottle' => $data[$key]['PackBottleNumber'][0],
            ]);
        }
    }
    return $this;
}



}
