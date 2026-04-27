<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Protocol extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRelationships;

    protected $table = 'Protocol';

    public $incrementing = true;

    protected $primaryKey = 'ProtocolID';

    protected $keyType = 'int';

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
        'TestNote',
        'FooterSectionNo',
        'PreviousProtocolID',
        'Reason',
        'ExhibitBatch',
        'CommercialValidationBatch',
        'AnnualStability',
        'Other',
        'ProtocolStatusID',
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

    public function approvalSteps()
    {
        return $this->hasMany(ProtocolApproval::class, 'ProtocolID')->orderBy('StepOrder');
    }

    public function getProtocol()
    {
        return static::query()->with([
            'user:id,name',
            'updatedby:id,name',
            'product:ProductID,ProductName',
            'product.skus:SkuID,ProductID,ProductStrength',
        ]);
    }

    public function storeProtocol($request): self
    {
        $this->fill([
            'Title'                     => $request->Title,
            'Purpose'                   => $request->Purpose,
            'Scope'                     => $request->Scope,
            'Reference'                 => $request->Reference,
            'ProtocolStatusID'          => 1,
            'FooterSectionNo'           => $request->FooterSectionNo,
            'Responsibilities'          => $request->Responsibilities,
            'ProductID'                 => $request->ProductID,
            'MarketID'                  => $request->MarketID,
            'ManufacturerID'            => $request->ManufacturerID,
            'AnalysisReport'            => $request->AnalysisReport,
            'Reporting'                 => $request->Reporting,
            'Conclusion'                => $request->Conclusion,
            'RevisionHistory'           => $request->RevisionHistory,
            'TestNote'                  => $request->TestNote,
            'ExhibitBatch'              => $request->ExhibitBatch,
            'CommercialValidationBatch' => $request->CommercialValidationBatch,
            'AnnualStability'           => $request->AnnualStability,
            'Other'                     => $request->Other,
            'CreatedBy'                 => Auth::id(),
            'Note'                      => $request->Note,
        ])->save();

        return $this;
    }

    public function updateProtocol($protocol, $request): self
    {
        $protocol->update([
            'MarketID'                  => $request->MarketID,
            'ManufacturerID'            => $request->ManufacturerID,
            'Title'                     => $request->Title,
            'Purpose'                   => $request->Purpose,
            'Scope'                     => $request->Scope,
            'Responsibilities'          => $request->Responsibilities,
            'Reference'                 => $request->Reference,
            'AnalysisReport'            => $request->AnalysisReport,
            'Reporting'                 => $request->Reporting,
            'Conclusion'                => $request->Conclusion,
            'FooterSectionNo'           => $request->FooterSectionNo,
            'RevisionHistory'           => $request->RevisionHistory,
            'ExhibitBatch'              => $request->ExhibitBatch,
            'CommercialValidationBatch' => $request->CommercialValidationBatch,
            'AnnualStability'           => $request->AnnualStability,
            'Other'                     => $request->Other,
            'UpdatedBy'                 => Auth::id() ?? 1,
            'Note'                      => $request->Note,
            'TestNote'                  => $request->TestNote,
        ]);

        return $this;
    }

    public function storeProtocolAPIDetail($protocol, $request): self
    {
        DB::transaction(function () use ($protocol, $request) {
            ProtocolAPIDetail::where('ProtocolID', $protocol->ProtocolID)->delete();

            $apiIds = (array) $request->ApiID;
            $batchNos = (array) $request->BatchNo;
            $expDates = (array) $request->ExpDate;

            $rows = [];
            foreach ($apiIds as $key => $value) {
                if (isset($batchNos[$key])) {
                    $rows[] = [
                        'ProtocolID'  => $protocol->ProtocolID,
                        'APIDetailID' => $value,
                        'BatchNo'     => $batchNos[$key],
                        'ExpDate'     => $expDates[$key] ?? null,
                    ];
                }
            }

            if ($rows) {
                ProtocolAPIDetail::insert($rows);
            }
        });

        return $this;
    }

    public function storeProtocolProductDetails($protocol, $request): self
    {
        DB::transaction(function () use ($protocol, $request) {
            ProtocolProductDetail::where('ProtocolID', $protocol->ProtocolID)->delete();

            $skuIds = (array) $request->SkuID;
            $specs = (array) $request->SpecificationNo;
            $stps = (array) $request->STPNo;
            $userId = Auth::id();

            $rows = [];
            foreach ($skuIds as $key => $sku) {
                if (isset($specs[$key], $stps[$key])) {
                    $rows[] = [
                        'ProtocolID'      => $protocol->ProtocolID,
                        'ProductID'       => $request->ProductID,
                        'SkuID'           => $sku,
                        'SpecificationNo' => $specs[$key],
                        'STPNo'           => $stps[$key],
                        'CreatedBy'       => $userId,
                    ];
                }
            }

            if ($rows) {
                ProtocolProductDetail::insert($rows);
            }
        });

        return $this;
    }

    public function storeProtocolSkuContainerType($protocol, $request): self
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            $existingSkuPackIds = $protocol->sku()->pluck('ProtocolSkuPackID');
            if ($existingSkuPackIds->isNotEmpty()) {
                ProtocolSkuPackContainer::whereIn('ProtocolSkuPackID', $existingSkuPackIds)->delete();
                ProtocolSkuPack::where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            foreach ($data as $key => $value) {
                if (! isset($value['SkuID']) || ! is_array($value['SkuID'])) {
                    continue;
                }

                $containerId = $value['ContainerType'][0] ?? null;
                $packIds = $value['PackID'] ?? [];

                foreach ($value['SkuID'] as $sku) {
                    $skuPack = ProtocolSkuPack::create([
                        'ProtocolID'  => $protocol->ProtocolID,
                        'SkuID'       => $sku,
                        'ContainerID' => $containerId,
                    ]);

                    foreach ($packIds as $packId) {
                        $skuPack->perUnitContainer()->create(['PackID' => $packId]);
                    }
                }
            }
        });

        return $this;
    }

    public function storeProtocolPackagingProfile($protocol, $request): self
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            $this->purgePackagingFor($protocol);

            foreach ($data as $key => $value) {
                $skuId = $value['SkuID'][0] ?? null;
                $packId = $value['PackID'][0] ?? null;

                if (! $skuId || ! $packId) {
                    continue;
                }

                $packaging = ProtocolPackagingPack::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'SkuID'      => $skuId,
                    'PackID'     => $packId,
                ]);

                $this->insertPackagingTier($packaging, $value, 'Primary', 'primary');
                $this->insertPackagingTier($packaging, $value, 'Secondary', 'secondary');
                $this->insertPackagingTier($packaging, $value, 'Tertiary', 'tertiary');
            }
        });

        return $this;
    }

    public function storeProtocolStabilityStudy($protocol, $request): self
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            $existingIds = $protocol->statbilityStudy()->pluck('ProtocolStabilityStudyID');
            if ($existingIds->isNotEmpty()) {
                ProtocolStabilityStudyDetail::whereIn('ProtocolStabilityStudyID', $existingIds)->delete();
                ProtocolStabilityStudy::where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            foreach ($data as $key => $value) {
                $studyTypeId = $value['StydyTypeID'][0] ?? null;
                $conditionId = $value['ConditionID'][0] ?? null;

                if (! $studyTypeId || ! $conditionId) {
                    continue;
                }

                ProtocolStabilityStudy::create([
                    'ProtocolID'  => $protocol->ProtocolID,
                    'StudyTypeID' => $studyTypeId,
                    'ConditionID' => $conditionId,
                ]);
            }
        });

        return $this;
    }

    public function storeProtocolTestStudy($protocol, $request): self
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            $testIds = $protocol->tests()->pluck('ProtocolTestID');
            if ($testIds->isNotEmpty()) {
                ProtocolSkuTest::whereIn('ProtocolTestID', $testIds)->delete();
                ProtocolTestPackBottle::where('ProtocolID', $protocol->ProtocolID)->delete();
                ProtocolTest::where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            foreach ($data as $key => $value) {
                $testId = $value['TestID'][0] ?? null;
                if (! $testId) {
                    continue;
                }

                $protocolTest = ProtocolTest::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'TestID'     => $testId,
                ]);

                $sku = $value['Sku'][0] ?? null;
                $unitPerTest = $value['UnitPerTest'][0] ?? null;
                $pack = $value['Pack'][0] ?? null;
                $packBottle = $value['PackBottleNumber'][0] ?? null;

                if ($sku && $unitPerTest) {
                    $protocolTest->protocolSkuTest()->create([
                        'SkuID'       => $sku,
                        'UnitPerTest' => $unitPerTest,
                    ]);
                }

                if ($sku && $pack && $packBottle) {
                    $protocol->protocolTestPackCount()->create([
                        'SkuID'          => $sku,
                        'PackID'         => $pack,
                        'NumberOfBottle' => $packBottle,
                    ]);
                }
            }
        });

        return $this;
    }

    public function cloneProtocolAPIDetail($protocol, $request): self
    {
        DB::transaction(function () use ($protocol, $request) {
            ProtocolAPIDetail::where('ProtocolID', $protocol->ProtocolID)->delete();

            $sourceApis = ProtocolAPIDetail::where('ProtocolID', $request->ProtocolID)->get();

            $rows = $sourceApis
                ->filter(fn ($api) => isset($api->BatchNo))
                ->map(fn ($api) => [
                    'ProtocolID'  => $protocol->ProtocolID,
                    'APIDetailID' => $api->APIDetailID,
                    'BatchNo'     => $api->BatchNo,
                    'ExpDate'     => $api->ExpDate,
                ])->all();

            if ($rows) {
                ProtocolAPIDetail::insert($rows);
            }
        });

        return $this;
    }

    public function cloneProtocolProductDetails($protocol, $request): self
    {
        DB::transaction(function () use ($protocol, $request) {
            ProtocolProductDetail::where('ProtocolID', $protocol->ProtocolID)->delete();

            $sourceDetails = ProtocolProductDetail::where('ProtocolID', $request->ProtocolID)->get();
            $userId = Auth::id();

            $rows = $sourceDetails
                ->filter(fn ($d) => isset($d->SpecificationNo, $d->STPNo))
                ->map(fn ($d) => [
                    'ProtocolID'      => $protocol->ProtocolID,
                    'ProductID'       => $d->ProductID,
                    'SkuID'           => $d->SkuID,
                    'SpecificationNo' => $d->SpecificationNo,
                    'STPNo'           => $d->STPNo,
                    'CreatedBy'       => $userId,
                ])->all();

            if ($rows) {
                ProtocolProductDetail::insert($rows);
            }
        });

        return $this;
    }

    public function cloneProtocolSkuContainerType($protocol, $request): self
    {
        DB::transaction(function () use ($protocol, $request) {
            $existingSkuPackIds = $protocol->sku()->pluck('ProtocolSkuPackID');
            if ($existingSkuPackIds->isNotEmpty()) {
                ProtocolSkuPackContainer::whereIn('ProtocolSkuPackID', $existingSkuPackIds)->delete();
                ProtocolSkuPack::where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            $sourceSkuPacks = ProtocolSkuPack::with('perUnitContainer')
                ->where('ProtocolID', $request->ProtocolID)
                ->get();

            foreach ($sourceSkuPacks as $sourcePack) {
                $newPack = ProtocolSkuPack::create([
                    'ProtocolID'  => $protocol->ProtocolID,
                    'SkuID'       => $sourcePack->SkuID,
                    'ContainerID' => $sourcePack->ContainerID,
                ]);

                foreach ($sourcePack->perUnitContainer ?? [] as $container) {
                    $newPack->perUnitContainer()->create([
                        'PackID' => $container->PackID,
                    ]);
                }
            }
        });

        return $this;
    }

    public function cloneProtocolPackagingProfile($protocol, $request): self
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            $this->purgePackagingFor($protocol);

            foreach ($data as $key => $value) {
                $skuId = $value['SkuID'][0] ?? null;
                $packId = $value['PackID'][0] ?? null;

                if (! $skuId || ! $packId) {
                    continue;
                }

                $packaging = ProtocolPackagingPack::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'SkuID'      => $skuId,
                    'PackID'     => $packId,
                ]);

                $this->insertPackagingTier($packaging, $value, 'Primary', 'primary');
                $this->insertPackagingTier($packaging, $value, 'Secondary', 'secondary');
                $this->insertPackagingTier($packaging, $value, 'Tertiary', 'tertiary');
            }
        });

        return $this;
    }

    public function cloneProtocolStabilityStudy($protocol, $request): self
    {
        return $this->storeProtocolStabilityStudy($protocol, $request);
    }

    public function cloneProtocolTestStudy($protocol, $request): self
    {
        return $this->storeProtocolTestStudy($protocol, $request);
    }

    protected function purgePackagingFor($protocol): void
    {
        $packagingIds = $protocol->packagings()->pluck('ProtocolPackagingPackID');
        if ($packagingIds->isEmpty()) {
            return;
        }

        ProtocolPackPrimary::whereIn('ProtocolPackagingPackID', $packagingIds)->delete();
        ProtocolPackSecondary::whereIn('ProtocolPackagingPackID', $packagingIds)->delete();
        ProtocolPackTertiary::whereIn('ProtocolPackagingPackID', $packagingIds)->delete();
        ProtocolPackagingPack::where('ProtocolID', $protocol->ProtocolID)->delete();
    }

    protected function insertPackagingTier($packaging, array $value, string $key, string $relation): void
    {
        if (! isset($value[$key]) || ! is_array($value[$key])) {
            return;
        }

        foreach ($value[$key] as $containerId) {
            $packaging->{$relation}()->create([
                'ContainerID' => $containerId,
            ]);
        }
    }
}
