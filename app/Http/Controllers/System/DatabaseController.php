<?php

namespace App\Http\Controllers\System;

use Carbon\Carbon;
use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

use Yajra\DataTables\Facades\DataTables;

class DatabaseController extends Controller
{
    public function index(Batch $batch, Request $request)
    {
        if ($request->ajax()) {
            $data = $batch::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editLink = route('batch.edit', $row->BatchID);
                    $cloneLink = route('batch.clone', $row->BatchID);
                    $deleteLink = route('batch.delete', $row->BatchID);
                    return batch_button($editLink, $cloneLink, $deleteLink);
                })
                ->addColumn('product', function ($row) {
                    $productName = $row->product->ProductName;
                    return $productName;
                })
                ->addColumn('SIDate', function ($row) {
                    $sidate = new \Carbon\Carbon($row->SIDate);
                    $stabilty_initiation_date = $sidate->subMonths($row->Month);
                    $SIDate = Carbon::parse($stabilty_initiation_date)->toFormattedDateString();
                    return $SIDate;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.database.index');
    }

    public function index_old(Request $request)
    {
        $batches = Batch::orderBy('SIDate', 'ASC')
            ->when($request->q, function (Builder $query) use ($request) {
                $query->where('ProductName', 'LIKE', "%{$request->q}%")
                    ->orWhere('BatchNo', 'LIKE', "%{$request->q}%")
                    ->orWhere('Month', 'LIKE', "%{$request->q}%");
            })
            ->orderBy('Month', 'ASC')
            ->orderBy('BatchID', 'DESC')
            ->paginate(10);



        return view('system.database.index', compact('batches'));
    }
}
