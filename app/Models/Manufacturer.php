<?php

namespace App\Models;

use App\Helpers\Addressable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Manufacturer extends Model implements Auditable
{
    use Addressable;
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Manufacturer';

    public $incrementing = true;

    protected $primaryKey = 'ManufacturerID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ManufacturerID',
        'ManufacturerName',
        'CreatedBy',
        'UpdateBy',
    ];

    public function getManufacturer()
    {
        return static::query()->with('address')->get();
    }

    public function createManufacturer($request): self
    {
        $this->fill([
            'ManufacturerName' => $request->ManufacturerName,
            'CreatedBy'        => Auth::id(),
        ])->save();

        return $this;
    }

    public function updateManufacturer($manufacturer, $request): self
    {
        $manufacturer->update([
            'ManufacturerName' => $request->ManufacturerName,
            'UpdateBy'         => Auth::id(),
        ]);

        return $this;
    }
}
