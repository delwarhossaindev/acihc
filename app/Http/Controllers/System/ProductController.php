<?php

namespace App\Http\Controllers\System;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Product $product, Request $request)
    {
        if ($request->ajax()) {
            $data = $product->getProduct();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('batch', function ($product) {
                    $batchs = array_unique($product->batchs->pluck('BatchNo')->toArray());
                    return implode(',', $batchs);
                })
                ->addColumn('details', function ($product) {
                    return implode(',', $product->details->pluck('ProductStrength')->toArray());
                })
                ->addColumn('packs', function ($product) {
                    return implode(',', $product->packs->pluck('PackValue')->toArray());
                })
                ->addColumn('apis', function ($product) {
                    return implode(',', $product->apis->pluck('ApiDetailName')->toArray());
                })
                ->addColumn('action', function ($row) {
                    $editLink = route('product.edit', $row->ProductID);
                    $deleteLink = route('product.delete', $row->ProductID);
                    return getDynamicButtonLink($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.product.index');
    }

    public function create()
    {
        return view('system.product.create');
    }

    public function store(Product $product, Request $request)
    {
        $product->createProduct($request);

        return $this->success('product', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $previousStrength = [];

        foreach ($product->details->pluck('ProductStrength') as $key => $value) {
            $previousStrength[$key] = $value;
        }

        $product = $product->load('details', 'packs');

        return view('system.product.edit', compact('product', 'previousStrength'));
    }

    public function update(Product $product, Request $request)
    {   //return $request->all();
        $product->updateProduct($product, $request);

        return $this->success('product', 'Product updated successfully!');
    }

    public function delete(Product $product)
    {
        DB::beginTransaction();
        try {
            ProductDetail::where('ProductID', $product->ProductID)
                ->delete();
            $product->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error('product', 'Something went wrong!');
        }

        return $this->success('product', 'Study Type deleted successfully!');
    }

    public function details(Product $product)
    {
        $product = $product->load('details');

        return response()->json($product);
    }
}
