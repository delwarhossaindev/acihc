<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sample extends Model
{
    use HasFactory;

    protected $table = "Sample";

    public $incrementing = true;

    protected $primaryKey = "SampleID";

    protected $keyType = 'string';

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
        return $this->belongsTo(Product::class,'ProductID');
    }

    public function reports()
    {
        return $this->hasMany(SampleReport::class,'SampleID');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class,'ManufacturerID');
    }

    public function protocol()
    {
        return $this->belongsTo(Protocol::class,'ProtocolID');
    }

    public function getSample()
    {
        return $this::query();
    }

    public function createSample($request)
    {
        $this->ManufacturerID = $request->ManufacturerID;
        $this->ProductID = $request->ProductID;
        $this->ProtocolID = $request->ProtocolID;
        $this->GRN_NUMBER = $request->GRN_NUMBER;
        $this->Remark = $request->Remark;
        $this->ReceivingDate = $request->ReceivingDate;
        $this->PackagingDate = $request->PackagingDate;
        // $this->Headline = $request->Headline;
        // $this->Note = $request->Note;
        $this->FooterSection = $request->FooterSection;
        $this->STPNo = $request->STPNo;
        $this->SpecificationNo = $request->SpecificationNo;
        $this->save();

        return $this;
    }

    public function updateSample($sample,$request)
    {
        $sample->update([
           'ManufacturerID' => $request->ManufacturerID,
           'ProductID' => $request->ProductID,
           'ProtocolID' => $request->ProtocolID,
           'GRN_NUMBER' => $request->GRN_NUMBER,
           'Remark' => $request->Remark,
           'ReceivingDate' => $request->ReceivingDate,
           'PackagingDate' => $request->PackagingDate,
        //    'Headline' => $request->Headline,
        //    'Note' => $request->Note,
           'FooterSection' => $request->FooterSection,
           'STPNo' => $request->STPNo,
           'SpecificationNo' => $request->SpecificationNo,
        ]);

        return $this;
    }
}
