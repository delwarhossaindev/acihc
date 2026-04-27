<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Market extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Market';

    public $incrementing = true;

    protected $primaryKey = 'MarketID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'MarketID',
        'MarketName',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function getMarket()
    {
        return static::query();
    }

    public function createMarket($request): self
    {
        $this->fill([
            'MarketName' => $request->MarketName,
            'CreatedBy'  => Auth::id(),
        ])->save();

        return $this;
    }

    public function updateMarket($market, $request): self
    {
        $market->update([
            'MarketName' => $request->MarketName,
            'UpdatedBy'  => Auth::id(),
        ]);

        return $this;
    }
}
