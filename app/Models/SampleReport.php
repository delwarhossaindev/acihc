<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleReport extends Model
{
    use HasFactory;

    protected $table = 'SampleReport';

    public $incrementing = true;

    protected $primaryKey = 'SampleReportID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'SampleReportID',
        'StudyTypeID',
        'SampleID',
        'BatchID',
        'ConditionID',
        'SkuID',
        'PackID',
        'UserID',
        'Headline',
        'Note',
        'CreatedAt',
        'UpdatedAt',
    ];

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'PackID');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class, 'ConditionID');
    }

    public function study()
    {
        return $this->belongsTo(StudyType::class, 'StudyTypeID');
    }

    public function sample()
    {
        return $this->belongsTo(Sample::class, 'SampleID');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'BatchID');
    }

    public function batchDetails()
    {
        return $this->belongsTo(BatchDetails::class, 'BatchID');
    }

    public function sku()
    {
        return $this->belongsTo(ProductDetail::class, 'SkuID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function sampleReportDetails()
    {
        return $this->hasMany(SampleReportDetail::class, 'SampleReportID');
    }

    public function getSampleReport()
    {
        return static::query()->with([
            'pack',
            'sample.product',
            'condition',
            'batch',
            'sku',
            'user:id,name',
        ]);
    }
}
