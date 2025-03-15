<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = "Product";

    public $incrementing = true;

    protected $primaryKey = "ProductID";

    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'ProductID',
        'ProductName',
        'APILotNo',
        'Properties',
        'CreatedBy',
        'UpdatedBy'
    ];
    
    protected $casts = [
        'Properties' => 'array'
    ];

    public function setPropertiesAttribute($value)
    {
        $properties = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $properties[] = $array_item;
            }
        }

        $this->attributes['Properties'] = json_encode($properties);
    }

    public function details() : HasMany
    {
        return $this->hasMany(ProductDetail::class,'ProductID');
    }

    public function batchs() : HasMany
    {
        return $this->hasMany(Batch::class,'ProductID');
    }

    public function packs() : BelongsToMany
    {
        return $this->belongsToMany(Pack::class, 'SkuPack','ProductID','PackID');
    }

    public function skus()
    {
        return $this->hasMany(ProductDetail::class,'ProductID');
    }

    public function apis() : BelongsToMany
    {
        return $this->belongsToMany(ApiDetail::class,'ProductAPIDetail','ProductID','ApiDetailID');
    }

    public function getProduct()
    {
        return $this::query()->with('details','batchs');
    }

    public function createProduct($request)
    {   
        DB::beginTransaction();
        try {
            $this->ProductName = $request->ProductName;
            $this->APILotNo = $request->APILotNo;
            //$this->Properties = $request->properties;
            $this->CreatedBy = auth()->id();
            $this->save();

            $this->packs()->sync($request->packs);
            $this->apis()->sync($request->apis);

            foreach (json_decode($request->StudyTypeMonth) as $strength) {
                $this->details()->create([
                    'ProductStrength' => $strength->value
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create data',
            ], 500);
        }

        return $this;
    }

    public function updateProduct($product, $request)
    {   
        DB::beginTransaction();
        try {  
            $product->update([
                'ProductName' => $request->ProductName,
                'APILotNo' => $request->APILotNo,
                'UpdatedBy' => auth()->id()
            ]);

            $product->packs()->sync($request->packs);
            $product->apis()->sync($request->apis);

            ProductDetail::where('ProductID',$product->ProductID)
            ->delete();
            
            foreach (json_decode($request->StudyTypeMonth) as $value) {
                $product->details()->create([
                    'ProductStrength' => $value->value
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create data',
            ], 500);
        }

        return $this;
    }
}
