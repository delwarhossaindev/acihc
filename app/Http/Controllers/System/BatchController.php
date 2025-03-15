<?php

namespace App\Http\Controllers\System;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Protocol;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BatchController extends Controller
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

        return view('system.batch.index');
    }

    public function create()
    {
        $protocols = Protocol::with('product')->get();

        return view('system.batch.create', compact('protocols'));
    }

    public function store(Batch $batch, Request $request)
    {
        $batch->createBatch($request);

        return $this->success('batch.index', 'Batch created successfully!');
    }

    public function edit(Batch $batch)
    {
        $protocols = Protocol::with('product')->get();

        $protocol = Protocol::where('ProtocolID', $batch->ProtocolID)->first();
        $months = [];
        foreach ($protocol->statbilityStudy as $statbility) {
            $arrayMonth = $statbility->study->details->pluck('StudyTypeMonth');
            array_push($months, $arrayMonth);
        }
        $months = collect($months)->flatten()->unique();

        return view('system.batch.edit', compact('batch', 'protocols', 'months'));
    }

    public function update(Batch $batch, Request $request)
    {
        $batch->updateBatch($batch, $request);

        return $this->success('batch.index', 'Batch updated successfully!');
    }

    public function delete(Batch $batch)
    {
        $batch->delete();

        return $this->success('batch.index', 'Batch deleted successfully!');
    }

    public function clone(Batch $batch)
    {
        $SIDate = $batch->where('BatchNo', $batch->BatchNo)
            ->orderBy('month', 'asc')
            ->first()
            ->value('SIDate');

        $protocols = Protocol::with('product')->get();

        return view('system.batch.create', compact('protocols', 'batch', 'SIDate'));
    }
}
