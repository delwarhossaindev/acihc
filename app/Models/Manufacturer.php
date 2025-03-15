<?php

namespace App\Models;

use App\Helpers\Addressable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Manufacturer extends Model implements Auditable
{
    use HasFactory, Addressable, AuditableTrait;

    protected $table = "Manufacturer";

    public $incrementing = true;

    protected $primaryKey = "ManufacturerID";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ManufacturerID',
        'ManufacturerName',
        'CreatedBy',
        'UpdateBy'
    ];

    public function getManufacturer()
    {
        return $this::query()->with('address')->get();
    }

    public function createManufacturer($request)
    {
        $this->ManufacturerName = $request->ManufacturerName;
        $this->CreatedBy = auth()->id();
        $this->save();

        return $this;
    }

    public function updateManufacturer($manufacturer, $request)
    {
        $manufacturer->update([
            'ManufacturerName' => $request->ManufacturerName,
            'UpdateBy' => auth()->id()
        ]);

        return $this;
    }
}
