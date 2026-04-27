<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Product $product, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            $query = Product::with([
                'batchs:BatchID,ProductID,BatchNo',
                'details:SkuID,ProductID,ProductStrength',
                'packs:PackID,PackValue',
                'apis:ApiDetailID,ApiDetailName',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('batch', fn ($product) => $product->batchs->pluck('BatchNo')->unique()->implode(','))
                ->addColumn('details', fn ($product) => $product->details->pluck('ProductStrength')->implode(','))
                ->addColumn('packs', fn ($product) => $product->packs->pluck('PackValue')->implode(','))
                ->addColumn('apis', fn ($product) => $product->apis->pluck('ApiDetailName')->implode(','))
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('ProductController@edit') ? route('product.edit', $row->ProductID) : null;
                    $deleteLink = $authUser?->hasPermission('ProductController@delete') ? route('product.delete', $row->ProductID) : null;
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
        $product->load('details', 'packs');
        $previousStrength = $product->details->pluck('ProductStrength')->values()->all();

        return view('system.product.edit', compact('product', 'previousStrength'));
    }

    public function update(Product $product, Request $request)
    {
        $product->updateProduct($product, $request);

        return $this->success('product', 'Product updated successfully!');
    }

    public function delete(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                ProductDetail::where('ProductID', $product->ProductID)->delete();
                $product->delete();
            });
        } catch (\Throwable $e) {
            return $this->error('product', 'Something went wrong!');
        }

        return $this->success('product', 'Product deleted successfully!');
    }

    public function details(Product $product)
    {
        $product->load('details');

        return response()->json($product);
    }
}
