<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'Product';

    public $incrementing = true;

    protected $primaryKey = 'ProductID';

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ProductID',
        'ProductName',
        'APILotNo',
        'Properties',
        'CreatedBy',
        'UpdatedBy',
    ];

    protected $casts = [
        'Properties' => 'array',
    ];

    public function setPropertiesAttribute($value): void
    {
        if (! is_array($value)) {
            $this->attributes['Properties'] = null;
            return;
        }

        $properties = array_values(array_filter($value, fn ($item) => isset($item['key']) && ! is_null($item['key'])));

        $this->attributes['Properties'] = json_encode($properties);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductDetail::class, 'ProductID');
    }

    public function batchs(): HasMany
    {
        return $this->hasMany(Batch::class, 'ProductID');
    }

    public function packs(): BelongsToMany
    {
        return $this->belongsToMany(Pack::class, 'SkuPack', 'ProductID', 'PackID');
    }

    public function skus(): HasMany
    {
        return $this->hasMany(ProductDetail::class, 'ProductID');
    }

    public function apis(): BelongsToMany
    {
        return $this->belongsToMany(ApiDetail::class, 'ProductAPIDetail', 'ProductID', 'ApiDetailID');
    }

    public function getProduct()
    {
        return static::query()->with(['details', 'batchs']);
    }

    public function createProduct($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->fill([
                    'ProductName' => $request->ProductName,
                    'APILotNo'    => $request->APILotNo,
                    'CreatedBy'   => Auth::id(),
                ])->save();

                $this->packs()->sync((array) $request->packs);
                $this->apis()->sync((array) $request->apis);

                $this->syncStrengths($this, $request->StudyTypeMonth);

                return $this;
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not create data'], 500);
        }
    }

    public function updateProduct($product, $request)
    {
        try {
            DB::transaction(function () use ($product, $request) {
                $product->update([
                    'ProductName' => $request->ProductName,
                    'APILotNo'    => $request->APILotNo,
                    'UpdatedBy'   => Auth::id(),
                ]);

                $product->packs()->sync((array) $request->packs);
                $product->apis()->sync((array) $request->apis);

                ProductDetail::where('ProductID', $product->ProductID)->delete();

                $this->syncStrengths($product, $request->StudyTypeMonth);
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not update data'], 500);
        }

        return $this;
    }

    protected function syncStrengths($product, $studyTypeMonth): void
    {
        $items = is_string($studyTypeMonth) ? json_decode($studyTypeMonth) : $studyTypeMonth;

        if (! is_array($items) && ! is_object($items)) {
            return;
        }

        $rows = [];
        foreach ($items as $strength) {
            if (isset($strength->value)) {
                $rows[] = [
                    'ProductID'       => $product->ProductID,
                    'ProductStrength' => $strength->value,
                ];
            }
        }

        if ($rows) {
            ProductDetail::insert($rows);
        }
    }
}
