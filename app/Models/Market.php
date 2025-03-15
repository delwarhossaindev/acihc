<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Market extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Market";

    public $incrementing = true;

    protected $primaryKey = "MarketID";

    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'MarketID',
        'MarketName',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function getMarket()
    {
        return $this::query();
    }

    public function createMarket($request)
    {
        $this->MarketName = $request->MarketName;
        $this->CreatedBy = auth()->id();
        $this->save();

        return $this;
    }

    public function updateMarket($market, $request)
    {   
        $market->update([
            'MarketName' => $request->MarketName,
            'UpdatedBy' => auth()->id()
        ]);

        return $this;
    }
}
