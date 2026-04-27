<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $table = 'Sample';

    public $incrementing = true;

    protected $primaryKey = 'SampleID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'SampleID',
        'ManufacturerID',
        'ProductID',
        'ProtocolID',
        'GRN_NUMBER',
        'Remark',
        'ReceivingDate',
        'PackagingDate',
        'Headline',
        'Note',
        'FooterSection',
        'STPNo',
        'SpecificationNo',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }

    public function reports()
    {
        return $this->hasMany(SampleReport::class, 'SampleID');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'ManufacturerID');
    }

    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'ProtocolID');
    }

    public function getSample()
    {
        return static::query();
    }

    public function createSample($request): self
    {
        $this->fill($this->sampleData($request))->save();

        return $this;
    }

    public function updateSample($sample, $request): self
    {
        $sample->update($this->sampleData($request));

        return $this;
    }

    protected function sampleData($request): array
    {
        return [
            'ManufacturerID'  => $request->ManufacturerID,
            'ProductID'       => $request->ProductID,
            'ProtocolID'      => $request->ProtocolID,
            'GRN_NUMBER'      => $request->GRN_NUMBER,
            'Remark'          => $request->Remark,
            'ReceivingDate'   => $request->ReceivingDate,
            'PackagingDate'   => $request->PackagingDate,
            'FooterSection'   => $request->FooterSection,
            'STPNo'           => $request->STPNo,
            'SpecificationNo' => $request->SpecificationNo,
        ];
    }
}
