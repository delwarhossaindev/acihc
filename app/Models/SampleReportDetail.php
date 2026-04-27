<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleReportDetail extends Model
{
    use HasFactory;

    protected $table = 'SampleReportDetail';

    public $incrementing = true;

    protected $primaryKey = 'SampleReportDetailID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $casts = [
        'Value' => 'array',
    ];

    protected $fillable = [
        'SampleReportID',
        'TestID',
        'SubTestID',
        'Specification',
        'Value',
        'CreatedAt',
        'UpdatedAt',
    ];

    public function sampleReport()
    {
        return $this->belongsTo(SampleReport::class, 'SampleReportID');
    }

    public function setPropertiesAttribute($value): void
    {
        if (! is_array($value)) {
            $this->attributes['Value'] = null;
            return;
        }

        $properties = array_values(array_filter($value, fn ($item) => isset($item['key']) && ! is_null($item['key'])));

        $this->attributes['Value'] = json_encode($properties);
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['Value'] = json_encode($value);
    }
}
