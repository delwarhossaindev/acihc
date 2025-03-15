<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleReportDetail extends Model
{
    use HasFactory;

    protected $table = "SampleReportDetail";

    public $incrementing = true;

    protected $primaryKey = "SampleReportDetailID";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = [
        'Value' => 'array'
    ];

    public function sampleReport()
    {
        return $this->belongsTo(SampleReport::class,'SampleReportID');
    }

    public function setPropertiesAttribute($value)
	{
	    $properties = [];

	    foreach ($value as $array_item) {
	        if (!is_null($array_item['key'])) {
	            $properties[] = $array_item;
	        }
	    }

	    $this->attributes['Value'] = json_encode($properties);
	}

    public function setValueAttribute($value)
    {
        $this->attributes['Value'] = json_encode($value, true);
    }

    protected $fillable = [
        'SampleReportID',
        'TestID',
        'SubTestID',
        'Specification',
        'Value',
        'CreatedAt',
        'UpdatedAt',
       
    ];
}
